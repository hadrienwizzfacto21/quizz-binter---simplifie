<?php

use Keemia\Weezio\WeezioClass;
use Keemia\Weezio\ScenarioClass;

if (!defined("CONFIG")) require __DIR__ . "/../../loader.php";

$levelName = "redirection";
$rteNext = PROMPTS["clientRedir"];

lvlScenarioEnd($rteNext, $levelName, $logs);
function lvlScenarioEnd($rteNext, $levelName, $logs)
{
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["$levelName"]
    ]);
    if (isset(CONFIG["weezio"]["level_id"]["$levelName"]) && CONFIG["weezio"]["postForm"]) $wzo->Post();

    $scn = new ScenarioClass();
    $scn->End();

    $logs->add("$levelName", "LEVEL");

    header('Location:' . $rteNext);
}
