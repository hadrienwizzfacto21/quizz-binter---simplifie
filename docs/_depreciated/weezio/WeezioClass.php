<?php

// LOGS
require_once __DIR__ . '/../logs/logs.php';

// WEEZIO CLASS VER:PROD UPDATE:26/11/2021
class WeezioClass
{
    public $conInfo;
    public $toSend;


    // WEEZIO CLASSE CONSTRUCTION
    public function __construct($wzoConfig, $cookiesDuration = 86400)
    {
        // START SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params($cookiesDuration);
            session_start();
        }

        // CONFIG
        $this->conInfo["api_key"] = $wzoConfig["api_key"]; //api_key required
        $this->conInfo["task_id"] = $wzoConfig["task_id"] ?? null; //task_id
        $this->conInfo["interface_id"] = $wzoConfig["interface_id"] ?? null; //interface_id
        $this->conInfo["level_id"] = $wzoConfig["level_id"] ?? 1; //level_id

        // AUTO GENERATE
        $this->conInfo["user_agent"] = $this->GetUserAgent(); //user_agent
        $this->conInfo["source_id"] = $this->GetSourceID($wzoConfig["source_id"] ?? null); //source_id
        $this->conInfo["session_id"] = $this->GetSessionID($wzoConfig["session_id"] ?? null, $wzoConfig["session_id_length"] ?? null); //session_id

        // GET FORM
        $this->GetForm();

        // SAVE IN SESSION
        $_SESSION["wzo"] = [
            "conInfo" => $this->conInfo,
            "toSend" => $this->toSend
        ];

        /* CONFIG EXAMPLE 
        require_once __DIR__ . "/../weezio/WeezioClass.php";
        $wzo = new WeezioClass($wzoConfig = [
            "api_key" => "96e3f8b0-c2e5-4db0-be59-61d4bae2656d",
            "interface_id" => 57,
            "task_id" => 30,
            "level_id" => 1,
            "source_id" => 1,
            "session_id" => "123456789",
            "session_id_length" => "short/mid/long"
        ]); */
    }

    // SESSION_ID
    public function GetSessionID($pSessionID = null, $pLenght = "long")
    {
        // CHECK IF SESSION_ID EXIST
        if (isset($pSessionID)) return $pSessionID; //via wzoConfig
        if (isset($_GET["session_id"])) return $_GET["session_id"]; // via GET
        if (isset($_SESSION["wzo"]["conInfo"]["session_id"])) return $_SESSION["wzo"]["conInfo"]["session_id"]; // via Session

        // ELSE GENERATE ONE
        switch ($pLenght) {
            case 'short':
                $date = date('is');
                $n = rand(10, 99);
                $newSessionID = $date . $n;
                break;

            default:
                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $pass = array();
                $alphaLength = strlen($alphabet) - 1;
                for ($i = 0; $i < 31; $i++) {
                    $n = rand(0, $alphaLength);
                    $pass[] = $alphabet[$n];
                }
                $pass = implode($pass);
                $newSessionID =  "-" . $pass;
                break;
        }
        return $newSessionID;
    }

    // SOURCE_ID
    public function GetSourceID($pSourceId = null)
    {
        // CHECK IF SOURCE_ID EXIST
        if (isset($pSourceId)) return $pSourceId; //via wzoConfig
        if (isset($_GET["source_id"])) return $_GET["source_id"]; //via GET
        if (isset($_SESSION["wzo"]["conInfo"]["source_id"])) return $_SESSION["wzo"]["conInfo"]["source_id"]; // via Session
        return; //aucun
    }

    // USER_AGENT
    public function GetUserAgent()
    {
        require_once __DIR__ . '/useragent/uaFunctions.php';
        return uaUserAgent();
    }

    // FORM VALUES
    public function GetForm()
    {
        if (!isset($_POST)) return; //if no form

        foreach ($_POST as $inputKey => $inputValue) if (isset($inputValue) || !empty($inputValue)) $this->toSend[$inputKey] = $this->SecureInput($inputValue);
        return $this->toSend;
    }

    // CHECK PARTICIPATION
    public function ParticipationUnique($pInput = null, $pFilter = "q[lead_email_eq]")
    {
        $pInput = $pInput ?? $this->toSend["Email"]; //default input to reconcilitate

        // GET FROM WEEZIO
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://bk.weezio.net/api/v1/participations?automation_task_id=" . $this->conInfo["task_id"] . "&" . $pFilter . "=" . $pInput,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "x-api-key:" . $this->conInfo['api_key'],
            ),
        ));


        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return !isset($response['participations']['0']['id']); //true if participation is unique
    }

    // POST FORM
    public function PostForm()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://bk.weezio.net/api/v1/participations/weezioapp?interface_id=" . $this->conInfo["interface_id"] . "&source_id=" . $this->conInfo["source_id"] . "&level_id=" . $this->conInfo["level_id"] . "&session_id=" . $this->conInfo["session_id"] . "&device=" . $this->conInfo["user_agent"]["device"] . "&operating_system=" . $this->conInfo["user_agent"]["operating_system"] . "&browser=" . $this->conInfo["user_agent"]["browser"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->toSend,
            CURLOPT_HTTPHEADER => array(
                "x-api-key:" . $this->conInfo['api_key'],
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    // CHECK INPUTS
    public function SecureInput($targetedInput)
    {
        if (!is_array($targetedInput)) {
            $targetedInput = trim($targetedInput);
            $targetedInput = stripslashes($targetedInput);
            $targetedInput = htmlspecialchars($targetedInput);
            // $targetedInput = preg_replace("/\s+/", "", $targetedInput);
        }

        return $targetedInput;
    }
}
