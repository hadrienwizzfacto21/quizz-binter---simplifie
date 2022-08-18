<?php if (!empty($prompt->getImage())) : ?>
    <section id="promptsdisplay">
        <img src="<?= $prompt->getImage()['desktop'] ?>" alt="<?= $prompt->getImage()['alt'] ?>">
    </section>
<?php endif ?>