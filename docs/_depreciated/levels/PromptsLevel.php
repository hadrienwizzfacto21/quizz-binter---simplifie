<?php

use Keemia\Weezio\WeezioClass;

require_once __DIR__ . "/../../vendor/autoload.php";
if (!defined("CONFIG")) require_once __DIR__ . "/../config.php";

// LVL3 RUN
lvlRun();
function lvlRun()
{
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["enterPrompts"]
    ]);

    if (CONFIG["weezio"]["postForm"] && isset(CONFIG["weezio"]["level_id"]["enterPrompts"])) $wzo->Post();
    // return header('Location: ../../form');
}
