<?php

namespace Keemia\LogsClass;

class LogsClass
{
    public function __construct(?string $logFile = '/errors.log')
    {
        error_reporting(E_ALL ^ E_STRICT);
        ini_set('error_log', __DIR__ . $logFile);
        ini_set('log_errors', 1);
        ini_set('display_errors', 0);
        ini_set('html_errors', 0);
    }

    public function AddLogEvent($pContent, $pType = "LEADLOG", $LeadLogSessionID = null): void
    {
        $leadLog = $LeadLogSessionID ?? $_SESSION["wzo"]["conInfo"]["session_id"] ?? "No session_id";
        error_log("$pType -> $pContent ($leadLog) ", 0);
    }
}
