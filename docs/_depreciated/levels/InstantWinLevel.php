<?php

use Keemia\Weezio\WeezioClass;
use Keemia\InstantWin\InstantWinClass;

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../config.php";

switch (isset($_GET["reqmode"]) ? $_GET["reqmode"] : "default") {
    case 'run':
        echo iwRun();
        break;

    case 'end':
        iwEnd();
        break;

    default:
        // header('Location:  ../../prompts');
}

// RUN INSTANT WIN
function iwRun()
{
    // Tirer lot
    $iw = new InstantWinClass();


    if (isset($_SESSION["iw"]["activePrize"]) && !empty($_SESSION["iw"]["activePrize"]["id"])) {
        $iw->SetActivePrize($_SESSION["iw"]["activePrize"]["id"]);
    } elseif (isset($_SESSION["wzo"]["conInfo"]["session_id"])) {
        $iw->DrawPrize();
        $iw->CueAddPrize();
        $iw->UpdateFiles();
    } else $iw->SetActivePrize("Lose");

    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["runGame"]
    ]);
    if (CONFIG["weezio"]["postForm"] && isset(CONFIG["weezio"]["level_id"]["runGame"])) $wzo->Post();

    // Afficher lot id pour l'app
    return $iw->activePrize["id"];
}

// END INSTANT WIN
function iwEnd()
{
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["formSubmit"]
    ]);

    // Check participation
    if (!$wzo->IsUnique() && CONFIG["weezio"]["checkParticipation"]) return header('Location:  ../../prompts?opt=participationErrorPage');

    // Set prize to win
    $iw = new InstantWinClass();
    $iw->CueWinPrize($iw->activePrize["id"]);
    $iw->DrawCode($iw->activePrize["id"]);
    $iw->UpdateFiles("all");
    unset($_SESSION["iw"]["activePrize"]);

    // Prize to weezio
    if ((!isset($iw->activePrize["id"])) || (empty($iw->activePrize["id"])) || ($iw->activePrize["id"] == "Lose")) {
        $wzo->toSend["LostName"] = "Perdu";
        $wzo->toSend["LostLevel"] = "0";
    } else {
        $wzo->toSend["PrizeName"] = $iw->activePrize["Name"];
        $wzo->toSend["PrizeLevel"] = $iw->activePrize["Level"];
        $wzo->toSend["CodeUnique"] = $iw->activeCode;
    }

    if (CONFIG["weezio"]["postForm"] && isset(CONFIG["weezio"]["level_id"]["form"])) $wzo->Post();

    $_SESSION["endParcours"] = true;
    $prompts = $_SESSION["prompts"] = $iw->activePrize["Prompts"];

    return header('Location: ../../prompts?opt=' . $prompts);
}
