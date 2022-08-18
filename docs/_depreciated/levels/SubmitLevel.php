<?php

use Keemia\RouterClass;
use Keemia\Weezio\LevelsClass;

include_once __DIR__ . "/../../vendor/autoload.php";
if (!defined("CONFIG")) require_once __DIR__ . "/../config.php";

lvlRun();
function lvlRun()
{
    $rte = new RouterClass;
    if (!isset($_SESSION["wzo"]["conInfo"]["session_id"])) return $rte->Redirect();

    $lvl = new LevelsClass([
        "api_key" => CONFIG["weezio"]["weezioParam"]["api_key"],
        "interface_id" => CONFIG["weezio"]["weezioParam"]["interface_id"],
        "task_id" => CONFIG["weezio"]["weezioParam"]["task_id"],
        "level_id" => CONFIG["weezio"]["level_id"]["submitForm"]
    ]);

    if (empty($lvl->toSend["Email"])) return $rte->Redirect("formErrorPage");
    if (!$lvl->IsUnique() && CONFIG["weezio"]["checkParticipation"]) return $rte->Redirect("participationErrorPage");

    if (CONFIG["weezio"]["postForm"] && isset(CONFIG["weezio"]["level_id"]["submitForm"])) $lvl->Post();

    $_SESSION["quizEnd"] = false;
    return header('Location: ../../game');
}
