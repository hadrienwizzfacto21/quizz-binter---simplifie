<?php
$currentPage = "game";
$levelName = "game";

if (stripos($router->CurrentPage(), $currentPage) && $_SESSION["endParcours"]) exit(header('Location: ./'));

echo "<div class='--full-grid-large'>";
if (TEMPLATES["apps"]["active"]) include "./src/components/game/apps.php";
echo "</div>";
   // include "./src/levels/GameLevel.php";