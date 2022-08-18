<?php

use Keemia\Weezio\WeezioClass;



if (!defined("CONFIG")) require __DIR__ . "/../../loader.php";


$levelName = "formSubmit";
$rteError = "../../../prompts/?opt=formErrorPage";
$rteParticipation = "../../../prompts/?opt=participationErrorPage";
$rteNext = "../../../quiz";

lvlFormSubmit($rteError, $rteParticipation, $rteNext, $levelName, $logs);
function lvlFormSubmit($rteError, $rteParticipation, $rteNext, $levelName, $logs)
{
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"][$levelName]
    ]);

    if (empty($wzo->toSend["Email"])) return header("Location: $rteError");
    if (!$wzo->IsUnique() && CONFIG["weezio"]["checkParticipation"]) return header("Location: $rteParticipation");

    if (isset(CONFIG["weezio"]["level_id"][$levelName]) && CONFIG["weezio"]["postForm"]) $wzo->Post();
    $logs->add("$levelName", "LEVEL");

    return header("Location: $rteNext");
}
