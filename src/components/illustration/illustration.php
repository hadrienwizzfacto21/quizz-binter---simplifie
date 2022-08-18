<section id="illustration">

    <?php
    if (isset(TEMPLATES["illustration"][$currentPage]["wording"])) echo implode("<br>", TEMPLATES["illustration"][$currentPage]["wording"]);
    ?>

    <?php if (isset(TEMPLATES["illustration"][$currentPage]["image"]["desktop"])) : ?>
        <img src="<?= TEMPLATES["illustration"][$currentPage]["image"]["desktop"] ?>" class="<?= TEMPLATES["illustration"][$currentPage]["onMobile"] ? "" : "--hide-mobile" ?>" alt="<?= TEMPLATES["illustration"][$currentPage]["image"]["alt"] ?>">
    <?php endif ?>

</section>