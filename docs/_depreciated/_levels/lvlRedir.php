<?php

use Keemia\Weezio\WeezioClass;

if (!defined("CONFIG")) require_once __DIR__ . "/../config.php";

// LVL4 RUN
lvl4Run();
function lvl4Run()
{
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["redir"]
    ]);

    if (CONFIG["weezio"]["postForm"] && isset($_SESSION["wzo"]["conInfo"]["session_id"]) && isset(CONFIG["weezio"]["level_id"]["redir"])) $wzo->Post();
    header('Location: ' . PROMPTS["clientRedir"]);
}
