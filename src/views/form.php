<?php

$currentPage = "form";
$levelName = "enterForm";

if (stripos($router->CurrentPage(), $currentPage) && $_SESSION["endParcours"]) exit(header('Location: ./'));

sendLevel($levelName);

if (TEMPLATES["illustration"][$currentPage]["active"]) include "./src/components/illustration/illustration.php";
if (TEMPLATES["form"]["active"]) include "./src/components/form/form.php";

$logs->add($currentPage, "NAV");
