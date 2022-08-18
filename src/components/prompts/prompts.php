 <?php

   use Keemia\PromptsClass;
   use Keemia\RouterClass;

   $promptRoute = new RouterClass;
   $prompt = new PromptsClass;

   $promptAutho = $_SESSION["prompts"] ?? null;
   if ($prompt->isRestricted() && $promptAutho != $prompt->getTarget() && !$promptRoute->IsDevMode()) header("Location: ./");
   ?>

 <section id="prompts">
    <?= $prompt->getWording() ?>
 </section>

 <?php if (!empty($prompt->getCommon())) : ?>

    <section class="prompts-common">
       <?= $prompt->getCommon() ?>
       <?php if (TEMPLATES["networks"]["active"]) include "./src/components/networks/networks.php"; ?>
    </section>

 <?php endif ?>