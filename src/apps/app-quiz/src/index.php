<?php require_once __DIR__ . "/scripts/quizHandler.php" ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../../../styles/main.css">
    <link rel="stylesheet" href="./styles/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUIZ</title>
</head>

<body id="quiz--container">

    <section id="quiz--illustration">
        <img src="<?= QUIZ[QUIZ_POS]["illustration"] ?>" alt="">
    </section>

    <section id="quiz--content">
        <form method="POST" action="<?= $quizNext ?>">

            <div class="quiz--head">
                <h3><?= QUIZ[QUIZ_POS]["title"] ?></h3>
                <h1><?= QUIZ[QUIZ_POS]["ask"] ?></h1>
            </div>

            <div class="quiz--answers">
                <?php foreach (QUIZ[QUIZ_POS]["options"] as $key => $option) : ?>

                    <label for="answer<?= $key ?>">
                        <?= $option ?>
                        <input type="radio" name="answers" id="answer<?= $key ?>" value="<?= $option ?>">
                    </label>

                <?php endforeach ?>
            </div>

            <div class="quiz--submit">
                <input class="--btn --inactive" id="quizSubmit" type="submit" value="Valider">
            </div>

        </form>
    </section>


    <script>
        let radio = document.querySelectorAll("input[type='radio']")
        let quizSubmit = document.querySelector("#quizSubmit")

        radio.forEach(element => {
            element.addEventListener("click", () => {
                radio.forEach(element => {
                    if (element.checked == true) {
                        element.parentNode.classList.add("--quiz-selected", "--quiz-no-hover");
                    } else {
                        element.parentNode.classList.remove("--quiz-selected", "--quiz-no-hover");
                        quizSubmit.classList.remove("--inactive");
                    }
                })
            });
        });



        function QuizEnd() {

            window.parent.location.replace("./");


        }


        // console.log(radio[1])




        // let answer2 = document.querySelector("#answer2")

        // if (answer2.checked == true) {

        //     answer2.classList.add("--quiz-selected");
        //     console.log("yed")
        // }


        // function resizeIframe(obj) {
        //     obj.classList.add("--quiz-selected");
        // }
    </script>


</body>

</html>