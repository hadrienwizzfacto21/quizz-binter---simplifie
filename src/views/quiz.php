<?php

$currentPage = "quiz";
$levelName = "";

if (stripos($router->CurrentPage(), $currentPage) && $_SESSION["endParcours"]) exit(header('Location: ./'));

echo "<div class='--full-grid-large'>";
include "./src/handlers/quizHandler.php";
include "./src/components/quiz/quiz.php";
echo "</div>";


$logs->add($currentPage, "NAV");
