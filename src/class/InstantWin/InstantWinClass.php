<?php

namespace Keemia\InstantWin;

// A refaire + maj wzo saas
class InstantWinClass
{
    public $activePrize;
    public $activeCode;
    public $now;

    public $iwFile;
    public $ucFile;

    // INSTANT WIN CONSTRUCT
    public function __construct($iwFilePath, $ucFilePath, $cookiesDuration = 86400)
    {
        // START SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params($cookiesDuration);
            session_start();
        }

        // OPEN PRIZES/CODES FILES
        $this->iwFile = json_decode(file_get_contents($iwFilePath, true), true);
        $this->ucFile = json_decode(file_get_contents($ucFilePath, true), true);

        // SET NOW
        $this->now = date("ymdHis");

        // RESTAURE IF SESSION
        if (isset($_SESSION["iw"]["activePrize"])) $this->SetActivePrize($_SESSION["iw"]["activePrize"]["id"]);
    }

    // SET ACTIVE PRIZE
    // Récupérer un lot et le render actif tout le long du script
    public function SetActivePrize($pTarget = null)
    {
        // GET TARGET PRIZE
        $setActivePrize = $pTarget ?? $_GET["prize_id"] ?? $_SESSION["iw"]["activePrize"]["id"] ?? "Lose";

        // Return active prize or Lose
        if (!isset($this->iwFile[$setActivePrize])) return $this->SetLosePrize(); //if prize doesn't exist in file (+Lose)
        return $this->activePrize = $this->iwFile[$setActivePrize]; //pick prize in file
    }

    // SET Lose PRIZE
    // Scénario spécial lot perdu
    public function SetLosePrize()
    {
        $this->activeCode = null;

        return  $this->activePrize = [
            "id" => "Lose",
            "Prompts" => "PRlse",
            "Name" => "Perdu",
            "Level" => 0
        ];
    }

    // DRAW PRIZE
    // Vérifie toutes les conditions pour sortir un lot gagnant
    public function DrawPrize()
    {
        // LOOK ALL PRIZES
        foreach ($iwFile = $this->iwFile as $prizeKey => $prizeValue) {
            if ($iwFile[$prizeKey]["Stocks"]["Quantity"] <= 0) continue; //skip if quantity 0
            if ($iwFile[$prizeKey]["Stocks"]["MaxPerDay"] <= $this->StocksMaxPerDay($prizeKey)) continue; //skip if over maxperday
            if ($this->now < $this->StocksDate($prizeKey)) continue; //skip if not time yet

            return $this->SetActivePrize($prizeKey);  //make the drawn prize active
        }
        return $this->SetActivePrize("Lose"); //else set Lose active
    }

    // LOGIC FOR STOCKS MAXPERDAY
    // Compte le nomre de lots gagnés ce jour même (yy mm dd)
    public function StocksMaxPerDay($pTarget)
    {
        $prizeWonCount = array_filter($this->iwFile[$pTarget]["Won"], function ($count) {
            if (substr($count, 0, 6) == date("ymd")) return $count;
        });
        $prizeCueCount = array_filter($this->iwFile[$pTarget]["Cue"], function ($count) {
            if (substr($count, 0, 6) == date("ymd")) return $count;
        });

        return count($prizeWonCount) + count($prizeCueCount);
    }

    // LOGIC FOR STOCKS DATE
    // Trier les heures/dates et selectionner la plus petite
    public function StocksDate($pTarget)
    {
        $dateList = $this->iwFile[$pTarget]["Stocks"]["Date"];

        // If not an array of dates
        if (!is_array($dateList)) return $dateList;

        // ElseIf an array
        sort($dateList, SORT_NUMERIC);
        return $dateList[0];
    }

    // PRIZE ADD TO CUE
    // Ajouter un lot à la file d'attente
    function CueAddPrize($pTarget = null)
    {
        // GET TARGET PRIZE
        $this->SetActivePrize($pTarget ?? $this->activePrize["id"]);
        if ($this->activePrize['id'] == "Lose") return; //ignore if Lose
        $pTarget = $this->activePrize["id"];

        // Get prize date and frequency
        $dateList = $this->StocksDate($pTarget);
        $frequency = $this->iwFile[$pTarget]["Stocks"]["Frequency"];

        // Retirer date si array
        if (is_array($this->iwFile[$pTarget]["Stocks"]["Date"])) array_shift($this->iwFile[$pTarget]["Stocks"]["Date"]);

        // Sinon ajouter fréquence
        if (!is_array($this->iwFile[$pTarget]["Stocks"]["Date"])) $this->iwFile[$pTarget]["Stocks"]["Date"] = $this->TimeConverter($this->now, $frequency, true);

        // Then substract quantity and add to cue
        --$this->iwFile[$pTarget]["Stocks"]["Quantity"];
        array_push($this->iwFile[$pTarget]["Cue"], $dateList);
    }

    // PRIZE CUE WIN
    public function CueWinPrize($pTarget = null)
    {
        // GET TARGET PRIZE
        $this->SetActivePrize($pTarget ?? $this->activePrize["id"]);
        if ($this->activePrize['id'] == "Lose") return; //ignore if Lose
        $pTarget = $this->activePrize["id"];

        if (!isset($this->iwFile[$pTarget]["Cue"][0])) return $this->SetActivePrize("lose"); //si lot plus dispo

        array_push($this->iwFile[$pTarget]["Won"], $this->iwFile[$pTarget]["Cue"][0]); //ajouter prize à Won
        array_shift($this->iwFile[$pTarget]["Cue"]); //retirer prize de Cue
    }

    // DRAW CODE
    // Tirer un code correspondant au lot
    public function DrawCode($pTarget = null)
    {
        // Check activePrize
        $this->SetActivePrize($pTarget ?? $this->activePrize["id"]);
        if ($this->activePrize['id'] == "Lose" || !isset($this->ucFile[$pTarget]["Codes"][0])) {
            $this->SetActivePrize("Lose");
            return  $this->activeCode;
        };

        // Get code
        $this->activeCode = $this->ucFile[$pTarget]["Codes"][0];

        // Move code to Won
        array_shift($this->ucFile[$pTarget]["Codes"]);
        array_push($this->ucFile[$pTarget]["Won"], $this->activeCode);

        return $this->activeCode;
    }

    // UPDATE FILE
    // Mettre à jour le json des lots et codes
    public function UpdateFiles($pFilesTarget = "default", $pUpdateSession = true)
    {
        // Update files
        switch ($pFilesTarget) {
            case 'all':
                file_put_contents(__DIR__ . "/iwPrizesList.json", json_encode($this->iwFile, JSON_PRETTY_PRINT));
                file_put_contents(__DIR__ . "/iwCodesList.json", json_encode($this->ucFile, JSON_PRETTY_PRINT));
                break;
            case 'iw':
                file_put_contents(__DIR__ . "/iwPrizesList.json", json_encode($this->iwFile, JSON_PRETTY_PRINT));
                break;
            case 'uc':
                file_put_contents(__DIR__ . "/iwCodesList.json", json_encode($this->ucFile, JSON_PRETTY_PRINT));
                break;
            default:
                file_put_contents(__DIR__ . "/iwPrizesList.json", json_encode($this->iwFile, JSON_PRETTY_PRINT));
                break;
        }

        // Save in session
        if ($pUpdateSession) $_SESSION["iw"]["activePrize"] = $this->activePrize;
        return true; //done
    }

    // TIME CONVERTER
    // Additionner et soustraire des dates/heures
    public function TimeConverter($fTime, $fFrequence, $fAdd = true)
    {
        $fTime = str_pad($fTime, 12, "0", STR_PAD_LEFT); //Completer avec des 0 pour former Mois/Jours/Heures/Minutes/Secondes
        $fFrequence = str_pad($fFrequence, 12, "0", STR_PAD_LEFT); //Completer avec des 0 pour former Jours/Mois/Heures/Minutes/Secondes
        $newTime = \DateTime::createFromFormat('ymdHis', $fTime, new \DateTimeZone('UTC')); //Selon le format définit (mois, jour, heure, minutes, secondes), créer un \date

        // Splite \date
        $year = substr($fFrequence, 0, -10) . 'Y';
        $month = substr($fFrequence, 2, -8) . 'M';
        $day = substr($fFrequence, 4, -6) . 'D';
        $hour = substr($fFrequence, 6, -4) . 'H';
        $minute = substr($fFrequence, 8, -2) . 'M';
        $second = substr($fFrequence, -2) . 'S';

        // Créer un interval
        if ($fAdd) {
            $newTime->add(new \DateInterval('P' . $year . $month . $day . 'T' . $hour . $minute . $second));
        } else $newTime->sub(new \DateInterval('P' . $year . $month . $day . 'T' . $hour . $minute . $second)); //Créer un interval

        return $newTime->format('ymdHis');
    }
}
