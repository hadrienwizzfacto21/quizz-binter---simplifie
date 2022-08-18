<?php

namespace Keemia\Weezio;

include_once __DIR__ . "/../../../vendor/autoload.php";


class ScenarioClass
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function Start()
    {
        $_SESSION["startParcours"] = true;
        $_SESSION["endParcours"] = $_SESSION["endQuiz"] = false;
    }

    public function End()
    {
        $_SESSION["startParcours"] = false;
        $_SESSION["endParcours"] = $_SESSION["endQuiz"] = true;
    }

    public function Reset()
    {
        unset($_SESSION["wzo"]["conInfo"]["session_id"]);
        unset($_SESSION["prompts"]);
        $this->Start();
    }


    public function ParcoursGetState()
    {
        return [
            "session_id" => isset($_SESSION["wzo"]["conInfo"]["session_id"]),
            "endParcours" =>  $_SESSION["endParcours"] ?? false,
            "endQuiz" =>  $_SESSION["endQuiz"] ?? false,
        ];
    }
}
