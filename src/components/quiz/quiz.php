<script>
    let quizPos = 0;
</script>


<section class="quiz">

    <div class="quiz--illustration">
        <img class="--illustration-img" src="" alt="">
    </div>

    <div class="quiz--content">
        <div class="quiz--head">
            <h3 class="--head-h3">cat</h3>
            <h1 class="--head-h1">title</h1>
        </div>

        <div class="quiz--answers">

            <?php foreach (QUIZ[QUIZ_POS]["options"] as $key => $value) : ?>
                <label for="answer<?= $key ?>" class="answers">
                    <span>test</span>
                    <input type="radio" name="answers" id="answer<?= $key ?>" value="">
                </label>
            <?php endforeach ?>

        </div>

        <div class="quiz--submit">
            <button class="--btn --inactive" id="quizSubmit" onclick="UpdateQuiz(++quizPos)">Valider</button>
        </div>
    </div>

</section>


<script>
    let radio = document.querySelectorAll("input[type='radio']");
    let quizSubmit = document.querySelector("#quizSubmit");

    radio.forEach((element) => {
        element.addEventListener("click", () => {
            UpdateRadio();
        });
    });

    function UpdateRadio() {
        radio.forEach((element) => {
            if (element.checked == true) {
                element.parentNode.classList.add("--quiz-selected", "--quiz-no-hover");
                quizSubmit.classList.remove("--inactive");
            } else {
                element.parentNode.classList.remove("--quiz-selected", "--quiz-no-hover");
            }
        });
    }

    UpdateQuiz(0)

    function UpdateQuiz(quizPos) {

        let phpQuizContent = <?= json_encode(QUIZ, true); ?>

        let illu = document.querySelector(".--illustration-img");

        let headH3 = document.querySelector(".--head-h3");
        let headH1 = document.querySelector(".--head-h1");

        let answers = document.querySelectorAll(".answers");
        let answersRadio = document.querySelectorAll("input[type='radio']");

        let count = Object.keys(phpQuizContent).length;
        if (quizPos > count - 1) return window.location.replace("./src/handlers/levels/lvlScenarioEnd.php");

        illu.src = phpQuizContent[quizPos]["illustration"];
        illu.classList.remove("--anim");
        void illu.offsetWidth;
        illu.classList.add("--anim");

        headH3.innerHTML = phpQuizContent[quizPos]["title"];
        headH1.innerHTML = phpQuizContent[quizPos]["ask"];

        answers.forEach((value, i) => {
            value.querySelector("span").innerHTML = phpQuizContent[quizPos]["options"][i];
        });

        answersRadio.forEach(element => {
            element.checked = false
        });
        UpdateRadio();
    }
</script>