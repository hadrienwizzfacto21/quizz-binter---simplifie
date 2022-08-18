<?php

$client = CONFIG["legals"]["client"] ?? "Le client" ?>

<section id="popup-legalsInfo-mention">
    <p><?= $client ?> collecte et traite vos données personnelles recueillies par ce formulaire afin de gérer votre participation au jeu. Pour en savoir plus sur la gestion de
        vos données personnelles et pour exercer vos droits, merci de <span id="popup-legalsInfo-open" onclick="OpenPopUp()"> cliquer ici.</span>
    </p>
</section>

<section id="popup-legalsInfo" style="visibility:hidden" onclick="ClosePopUp()">
    <div class="popup-legalsInfo-content">
        <p>
            <?= $client ?>, agissant en qualité de responsable de traitement, collecte et traite vos données complétées dans ce formulaire afin de gérer votre participation au jeu, le cas échéant de sélectionner les gagnants des lots du concours et effectuer auprès de vous des actions de prospection commerciale. Fondé sur le consentement requis lors de la collecte de vos données, les destinataires de vos données sont les services internes spécifiquement habilités de <?= $client ?> ainsi que nos éventuels sous-traitants et partenaires intervenant dans tout ou partie des opérations précitées. Vos données sont conservées en base active jusqu'à réception d’une opposition de votre part ou en cas d’absence prolongée à nos sollicitations avant de faire l’objet d’une suppression.<br><br>
            Conformément au Règlement général 2016/679 (EU) sur la protection des données, vous disposez de la faculté d'introduire une réclamation auprès de l'autorité de contrôle compétente, de définir des directives relatives à la conservation, à l'effacement et à la communication de vos données après votre décès ainsi qu’un droit d'accès, de rectification, d'effacement, de limitation, de portabilité et d'opposition pour motif légitime aux données personnelles vous concernant.<br><br>
            Pour exercer l’un de ces droits, merci de nous contacter soit par courrier postal, soit sur les coordonnées disponibles sur notre site internet. La communication d’une pièce justificative de votre identité sera susceptible d'être demandée.
        </p>
    </div>
</section>

<script>
    function ClosePopUp() {
        document.getElementById("popup-legalsInfo").style.visibility = "hidden";
    }

    function OpenPopUp() {
        document.getElementById("popup-legalsInfo").style.visibility = "visible";
    }
</script>