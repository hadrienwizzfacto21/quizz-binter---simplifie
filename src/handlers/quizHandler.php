<?php

if (session_status() === PHP_SESSION_NONE) session_start();

// if (isset($_SESSION[""]))

$quizContent = [
    [
        "title" => "DESTINATION 1",
        "ask" => "Où se situe ce paysage ?",
        "options" => [
            "Gran Canaria",
            "Maldives",
            "Seychelles"
        ],
        "answers" => [
            "Gran Canaria"
        ],
        "illustration" => "./styles/img/quiz-quest1.jpg"
    ],

    [
        "title" => "DESTINATION 2",
        "ask" => "Où se situe ce paysage ?",
        "options" => [
            "Tunisie",
            "Namibie",
            "Gran Canaria"
        ],
        "answers" => [
            "Gran Canaria"
        ],
        "illustration" => "./styles/img/quiz-quest2.jpg"
    ],

    [
        "title" => "DESTINATION 3",
        "ask" => "Où pouvez-vous visiter cette ville ?",
        "options" => [
            "Cuba",
            "Gran Canaria",
            "Martinique"
        ],
        "answers" => [
            "Gran Canaria"
        ],
        "illustration" => "./styles/img/quiz-quest3.jpg"
    ],




];
define("QUIZ", $quizContent);



$quizPos = $_GET["quizPos"] ?? 0;
define("QUIZ_POS", $quizPos);

// $quizNextCalc = 1 + $quizPos;
// $quizNext = (1 + QUIZ_POS >= count(QUIZ)) ? "?quizEnd=true" : "?quizPos=$quizNextCalc";
