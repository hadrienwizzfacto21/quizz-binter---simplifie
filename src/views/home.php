<?php

$currentPage = "index";
$levelName = "";

include __DIR__ . "/../handlers/levels/lvlScenarioStart.php";

if (TEMPLATES["illustration"][$currentPage]["active"]) include "./src/components/illustration/illustration.php";
if (TEMPLATES["hero"]["active"]) include "./src/components/hero/hero.php";

$logs->add($currentPage, "NAV");
