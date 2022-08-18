<?php
define("ROOT", __DIR__ . DIRECTORY_SEPARATOR);
require_once __DIR__ . '/src/loader.php';
$bodyStyle = isset(TEMPLATES["globals"]["bg"]["bg-image"]) ? "style=\"background-image:url('" . TEMPLATES['globals']['bg']['bg-image'] . "')\"" : "";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="<?= CONFIG["meta"]["descr"] ?>">
    <meta name="keywords" content="<?= CONFIG["meta"]["keywords"] ?>">
    <meta property="og:title" content="<?= CONFIG["meta"]["descrTitle"] ?>">
    <meta property="og:description" content="<?= CONFIG["meta"]["descr"] ?>">
    <meta property="og:image" content="<?= CONFIG["meta"]["illustration"] ?>">
    <meta property="og:type" content="website">
    <link rel="apple-touch-icon" sizes="180x180" href="./styles/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./styles/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./styles/favicon/favicon-16x16.png">
    <link rel="manifest" href="./styles/favicon/site.webmanifest">
    <link rel="stylesheet" href="./styles/main.css">
    <title><?= CONFIG["meta"]["title"] ?></title>
</head>

<body <?= $bodyStyle ?>>

    <main>

        <?php include "./src/components/header/header.php" ?>

        <div id="main_container">

            <?php

            // PHP8
            // match (parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?? "/") {
            //     "/" => require(__DIR__ . "/src/views/home.php"),
            //     "/form" => require(__DIR__ . "/src/views/form.php"),
            //     "/reglement" => header('Location:' . CONFIG["legals"]["reglementUrl"]),
            //     "/mentionslegales" => require(__DIR__ . "/src/views/mentionslegales.php"),
            //     "/game" => require(__DIR__ . "/src/views/game.php"),
            //     "/quiz" => require(__DIR__ . "/src/views/quiz.php"),
            //     "/prompts" => require(__DIR__ . "/src/views/prompts.php"),
            //     default => header('Location: ./'),
            // };

            $loadView = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?? "/";
            switch ($loadView) {

                case stripos($loadView, '/prompts') !== false:
                    require __DIR__ . "/src/views/prompts.php";
                    break;

                case stripos($loadView, '/mentionslegales') !== false:
                    require __DIR__ . "/src/views/mentionslegales.php";
                    break;

                case stripos($loadView, '/reglement') !== false:
                    header('Location:' . CONFIG["legals"]["reglementUrl"]);
                    break;

                case stripos($loadView, '/game') !== false:
                    require __DIR__ . "/src/views/game.php";
                    break;

                case stripos($loadView, '/form') !== false:
                    require __DIR__ . "/src/views/form.php";
                    break;

                case stripos($loadView, '/quiz') !== false:
                    require __DIR__ . "/src/views/quiz.php";
                    break;

                default:
                    require __DIR__ . "/src/views/home.php";
                    break;
            }

            ?>

        </div>

        <?php //include "./src/components/footer/footer.php" 
        ?>
        <?php include './src/components/cookies/cookies-audience.php' ?>

    </main>

</body>

</html>