<section id="form">

    <h2><?= TEMPLATES["form"]["title"] ?></h2>

    <form id="form--content" action="./src/handlers/levels/lvlFormSubmit.php" method="POST">
        <span class="error"></span>

        <?php

        // INPUTS
        $formInputs = TEMPLATES["form"]["inputs"];
        foreach ($formInputs as $key => $value) {
            $inputParams = $formInputs[$key]; //raccourci params de l'input
            $inputOptions = implode(" ", $formInputs[$key]["options"]) ?? null; //créer liste d'options
            $inputParams["label"] = in_array("required", $formInputs[$key]["options"]) ? $inputParams["label"] . "*" : $inputParams["label"]; // ajouter * aux champs 

            if ($inputParams["type"] === "select") {
                echo "<label class='select-wrap' for='$inputParams[id]'>$inputParams[label]<select name='$inputParams[id]' id='$inputParams[id]' $inputOptions>";

                if (in_array("required", $inputParams["options"])) echo "<option value='' hidden>---</option>";

                foreach ($inputParams["content"] as $key => $value) echo "<option value='$key'>$value</option>";
                echo "</select></label>";
            } else echo "<label for='$inputParams[id]'><span class='span-$inputParams[id]'>$inputParams[label]</span><input type='$inputParams[type]' name='$inputParams[id]' id='$inputParams[id]' $inputOptions></label>";
        }

        // OPTINS
        $formOptins = TEMPLATES["form"]["optins"];
        foreach ($formOptins as $key => $value) {
            $inputParams =  $formOptins[$key]; //raccourci params de l'input
            $inputOptions = implode(" ",  $formOptins[$key]["options"]) ?? null; //créer liste d'options
            $inputParams["label"] = in_array("required",  $formOptins[$key]["options"]) ? $inputParams["label"] . "*" : $inputParams["label"]; // ajouter * aux champs 

            echo "<div class='form-optin'><input id='$inputParams[id]' type='$inputParams[type]' name='$inputParams[id]' $inputOptions><label for='$inputParams[id]'>$inputParams[label]</label></div>";
        }

        ?>

        <p class="--required">* Champs obligatoires</p>
        <button id="Submit" class="--btn" type="submit"><?= TEMPLATES["form"]["btnSubmit"] ?></button>

    </form>
    <?php require './src/components/informations/informations.php' ?>
</section>

<script src="./src/js/FormChecks.js" defer></script>