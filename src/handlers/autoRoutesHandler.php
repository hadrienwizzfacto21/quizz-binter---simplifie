<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Keemia\RouterClass;

$router = new RouterClass;

AutomationRoutes($router);
function AutomationRoutes($ROUTER)
{

    // $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    // if (stripos($url, 'prompts') == false && stripos($url, '') == false && $_SESSION["endParcours"] ?? false) return header("Location: ./");


    if ($ROUTER->IsDevMode()) return;

    if (!stripos($ROUTER->CurrentPage(), 'prompts')) {
        if ($ROUTER->IsStarted(CONFIG["routing"]["startOP"])) return exit(header("Location: ./prompts?opt=startOPPage"));
        if ($ROUTER->IsEnded(CONFIG["routing"]["endOP"])) return exit(header("Location: ./prompts?opt=endOPPage"));
        if ($ROUTER->IsNotCompatible()) return header("Location: ./prompts?opt=navigateur");
        // if (!$ROUTER->IsSessionIdSet()) return header("Location: ./");
    }
}
