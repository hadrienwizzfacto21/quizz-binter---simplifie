<?php

use Keemia\Weezio\WeezioClass;

if (!defined("CONFIG")) require_once __DIR__ . "/../config.php";

// RESET WHEN PARCOURS IS DONE
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION["endParcours"]) && $_SESSION["endParcours"]) {
}

// RUN LVL1 ONLY ONCE
if (!isset($_SESSION["wzo"]["conInfo"]["session_id"])) lvl1Run();

// LVL1 RUN
function lvl1Run()
{
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["index"]
    ]);
    if (CONFIG["weezio"]["postForm"] && isset(CONFIG["weezio"]["level_id"]["index"])) $wzo->Post();
    $_SESSION["endParcours"] = false;
}
