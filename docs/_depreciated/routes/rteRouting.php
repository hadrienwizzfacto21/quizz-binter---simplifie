<?php

require_once __DIR__ . '/../config.php';

$configEndOP = CONFIG["routing"]["endOP"] ?? "";
$configStartOP = CONFIG["routing"]["startOP"] ?? "";

// DEV MODE
$devMode = $_GET["dev"] ?? $_SESSION["rte"]["devMode"] ?? "false"; //enable devMode if ?dev or in session
$_SESSION["rte"]["devMode"] = $devMode; //keep devMode in session

// ROUTING (if no dev mode)
if ($devMode == "false") Routing($configStartOP, $configEndOP);
function Routing($start, $end)
{
    $actualPageName = $_GET["p"] ?? "index";
    // $actualPageName = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $now = date("ymdHi"); //yy mm dd hh minmin

    // MISE EN LIGNE/HORS LIGNE AUTO
    if ($actualPageName != "prompts") {
        if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(; Touch)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT'])) return header("Location: ./prompts?popt=PRbwser");
        if ($now <= $start) return header("Location: ./index.php?p=prompts&opt=PRtea"); //teasing
        if ($now >= $end) return header("Location: ./index.php?p=prompts&opt=PRend"); //end op
    }

    // RESTART IF NO SESSION DURING PARCOURS
    if ($actualPageName != "index" && !isset($_SESSION["wzo"]["conInfo"]["session_id"])) return header("Location: ./");
}
