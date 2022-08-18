<?php
if ($_SESSION["quizEnd"] ?? false) {
  echo <<<END
  <script>  window.location.replace("./");</script>
END;
  exit;
}

?>


<section id="apps">

  <h2><?= TEMPLATES["apps"]["title"] ?></h2>
  <iframe height="100%" width="100%" style="overflow:hidden;height:100%;width:100%" src="./src/apps/<?= TEMPLATES["apps"]["activeApp"] ?>/src/" frameborder="0" id="apps-iframe" title="Mini-Jeu"></iframe>

  <?php if (isset(TEMPLATES["apps"]["btnNext"])) : ?>
    <a id="GameRequired" href="./src/levels/lvlIW.php?reqmode=end" class="--btn --inactive"><?= TEMPLATES["apps"]["btnNext"] ?></a>
  <?php endif ?>

</section>

<script src="./src/js/GamesFunctions.js" defer></script>

<script>
  let iframe = document.querySelector("iframe");

  window.addEventListener('resize', Resize)
  iframe.onload = Resize

  function Resize() {
    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
  }
</script>