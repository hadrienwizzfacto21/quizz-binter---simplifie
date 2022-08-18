<?php

use Keemia\Weezio\WeezioClass;

if (!defined("CONFIG")) require_once __DIR__ . "/../config.php";

lvlRun();
function lvlRun()
{
    $wzo = new WeezioClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["formSubmit"]
    ]);

    // CHECK PARTICIPATION
    if (empty($wzo->toSend["Email"])) return header('Location: ../../prompts?opt=formErrorPage');
    if (!$wzo->IsUnique() && CONFIG["weezio"]["checkParticipation"]) return header('Location: ../../prompts?opt=participationErrorPage');
    if (CONFIG["weezio"]["postForm"] && isset(CONFIG["weezio"]["level_id"]["form"])) $wzo->Post();

    return header('Location: ../../game');
}
