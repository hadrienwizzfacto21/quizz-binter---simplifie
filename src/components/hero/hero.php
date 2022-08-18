 <section id="hero">
     <h1><?= TEMPLATES["hero"]["title"] ?></h1>
     <h3><?= TEMPLATES["hero"]["wording"] ?></h3>

     <?php if (isset(TEMPLATES["hero"]["image"])) : ?>
         <img src="<?= TEMPLATES["hero"]["image"] ?>" alt="<?= CONFIG["legals"]["client"] ?> Hero" class="hero-img">
     <?php endif ?>

     <?php if (isset(TEMPLATES["hero"]["btn"])) : ?>
         <a class='--btn' href='./form'><?= TEMPLATES['hero']['btn'] ?></a>
     <?php endif ?>
 </section>