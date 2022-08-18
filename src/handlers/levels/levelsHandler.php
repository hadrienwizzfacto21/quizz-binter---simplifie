<?php

use Keemia\Weezio\WeezioClass;

include_once __DIR__ . "/../../../vendor/autoload.php";

function sendLevel($levelName)
{
    if (!defined("CONFIG")) require_once __DIR__ . "/../../config/config.php";

    if (isset(CONFIG["weezio"]["level_id"][$levelName]) && CONFIG["weezio"]["postForm"]) {
        $wzo = new WeezioClass([
            "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
            "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
            "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
            "level_id" => CONFIG["weezio"]["level_id"][$levelName]
        ]);
        $wzo->Post();
        $logs->add("$levelName", "LEVEL");
    }
}
