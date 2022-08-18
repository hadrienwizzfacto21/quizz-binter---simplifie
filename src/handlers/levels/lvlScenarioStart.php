<?php

use Keemia\Weezio\WeezioClass;
use Keemia\Weezio\ScenarioClass;

if (!defined("CONFIG")) require __DIR__ . "/../../loader.php";


$levelName = "scenarioStart";

lvlRun($levelName, $logs);
function lvlRun($levelName, $logs)
{
    $scn = new ScenarioClass();

    // si parcours terminé 
    if ($scn->ParcoursGetState()["endParcours"]) $scn->Reset();

    // si parcours déjà en cours
    if ($scn->ParcoursGetState()["session_id"]) return $scn->Start();

    // sinon commencer parcours
    $scn->Start();
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"][$levelName]
    ]);
    if (isset(CONFIG["weezio"]["level_id"][$levelName]) && CONFIG["weezio"]["postForm"]) $wzo->Post();

    $logs->add("$levelName", "LEVEL");
}
