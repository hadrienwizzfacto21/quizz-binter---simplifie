<?php
header('Access-Control-Allow-Origin: *');

$appConfig = [

    "global" => [
        "id" => "mj_scratch",
        "iwPath" => "../../../levels/InstantWinLevel.php?reqmode=run",
        "assetsPath" => "",
        "redirPath" => "",
        "gameHeight" => "",
        "gameWidth" => ""
    ],

    "assets" => [
        "scratchSurface" => "../assets/placeholder.png",
        "scratchParticules" => null,
    ],

    "endResults" => [
        "Lose" => "../assets/prizelose.jpg",
        "Prize1" => "../assets/prizewin.jpg",
        "Prize2" => "../assets/prizewin2.jpg"
    ]
];

echo json_encode($appConfig, true);
