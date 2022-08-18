<?php

namespace Keemia\Weezio;

require_once __DIR__ . "/../../../vendor/autoload.php";

use Keemia\UserAgent\UserAgentClass;

// WEEZIO CLASS VER:PROD UPDATE:26/11/2021
class WeezioClass
{
    public $conInfo;
    public $toSend;


    // WEEZIO CLASSE CONSTRUCTION
    public function __construct(array $wzoConfig, int $cookiesDuration = 86400)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params($cookiesDuration);
            session_start();
        }

        $this->conInfo = [
            "api_key" => $wzoConfig["api_key"],
            "task_id" => $wzoConfig["task_id"] ?? null,
            "interface_id" => $wzoConfig["interface_id"] ?? null,
            "level_id" => $wzoConfig["level_id"] ?? 1,
            "user_agent" => $this->GetUserAgent(),
            "source_id" => $this->GetSourceID($wzoConfig["source_id"] ?? null), //source_id
            "session_id" => $this->GetSessionID($wzoConfig["session_id"] ?? null, $wzoConfig["session_id_length"] ?? null)
        ];

        // GET FORM
        $this->toSend = $this->GetForm();

        // SAVE IN SESSION
        $_SESSION["wzo"] = [
            "conInfo" => $this->conInfo,
            "toSend" => $this->toSend
        ];

        /* CONFIG EXAMPLE 
        require_once __DIR__ . "/../weezio/WeezioClass.php";
        $wzo = new WeezioClass([
            "api_key" => "96e3f8b0-c2e5-4db0-be59-61d4bae2656d",
            "interface_id" => 57,
            "task_id" => 30,
            "level_id" => 1,
            "source_id" => 1,
            "session_id" => "123456789",
            "session_id_length" => "short/borne/web(default)"
        ]); */
    }

    // SESSION_ID
    public function GetSessionID($pSessionID = null, $pLenght = "web")
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

            case 'borne':
                // wip
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
        if (isset($_GET["source_id"])) return htmlentities($_GET["source_id"]); //via GET
        if (isset($_SESSION["wzo"]["conInfo"]["source_id"])) return $_SESSION["wzo"]["conInfo"]["source_id"]; // via Session
        return; //aucun
    }

    // USER_AGENT
    public function GetUserAgent(): array
    {
        $ua = new UserAgentClass;
        return $ua->ToArray();
    }

    // FORM VALUES
    public function GetForm()
    {
        if (!isset($_POST)) return; //if no form

        $formData = [];
        foreach ($_POST as $inputKey => $inputValue) if (isset($inputValue) || !empty($inputValue)) $formData[$inputKey] = $this->SecureInput($inputValue);
        return $formData;
    }


    // CHECK INPUTS
    public function SecureInput($targetedInput)
    {
        if (!is_array($targetedInput)) {
            $targetedInput = trim($targetedInput);
            $targetedInput = stripslashes($targetedInput);
            $targetedInput = htmlspecialchars($targetedInput);
        }

        return $targetedInput;
    }



    public function Get(?string $input = null, ?string $filter = null, string $endPoint = "participations")
    {
        $pInput ?? $pInput ?? $this->toSend["Email"] ?? "";
        $filter ?? "";
        $getURL = "https://bk.weezio.net/api/v1/{$endPoint}?automation_task_id={$this->conInfo["task_id"]}&{$filter}={$input}";

        $curl = curl_init($getURL);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "x-api-key:{$this->conInfo['api_key']}",
            ),
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);
        return $response;
    }


    public function Post(string $endPoint = "participations/weezioapp"): string
    {
        $postURL = "https://bk.weezio.net/api/v1/{$endPoint}?interface_id={$this->conInfo['interface_id']}&source_id={$this->conInfo['source_id']}&level_id={$this->conInfo['level_id']}&session_id={$this->conInfo['session_id']}&device={$this->conInfo['user_agent']['device']}&operating_system={$this->conInfo['user_agent']['operating_system']}&browser={$this->conInfo['user_agent']['browser']}";

        $curl = curl_init($postURL);
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->toSend,
            CURLOPT_HTTPHEADER => array(
                "x-api-key:{$this->conInfo['api_key']}",
            ),
        ));

        curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        return $error;
    }


    public function IsUnique($target = null, $filter = "q[lead_email_eq]"): bool
    {
        $target = $target ?? $this->toSend["Email"];
        $response = $this->Get($target, $filter);

        return !isset($response['participations']['0']['id']);
    }
}
