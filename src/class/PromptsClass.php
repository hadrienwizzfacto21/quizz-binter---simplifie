<?php

namespace Keemia;

class PromptsClass
{
    public $default;

    public function __construct(?string $target = null)
    {
        $this->target = $target ?? $this->getTarget();

        $this->default = [

            "commonWording" => [
                ""
            ],

            "startOPPage" => [ //teasing page
                "restricted" => false,
                "wording" => [
                    "<h1>Le site n'est pas <br> encore disponible !</h1><hr>",
                    "<h2>Revenez ici un peu plus tard.</h2>"
                ]
            ],

            "endOPPage" => [ //end of the op wording
                "restricted" => false,
                "wording" => [
                    "<h1>Le site n'est plus <br> accessible !</h1><hr>",
                    "<h2>Merci d'avoir participé</h2>"
                ]
            ],

            "formErrorPage" => [ //form error wording
                "restricted" => false,
                "wording" => [
                    "<h1>Vérifiez le formulaire !</h1><hr>",
                    "<h2>Il y a eu un problème ...</h2>"
                ]
            ],

            "participationErrorPage" => [ //already participated wording
                "restricted" => false,
                "wording" => [
                    "<h1>Vous avez<br>déjà participé !</h1><hr>",
                    "<h2>Vous ne pouvez participer qu'une seule fois.</h2>"
                ]
            ],

            "defaultErrorPage" => [ //for any other or unknown errors wording
                "restricted" => false,
                "wording" => [
                    "<h1>Il y a eu un problème !</h1><hr>",
                    "<h2>Merci de réessayer plus tard.</h2>"
                ]
            ],

            "PRl1t" => [ //prize 1 wording
                "restricted" => true,
                "wording" => [
                    "<h1>Merci d’avoir joué !</h1><hr>",
                    "<h2>Vous allez recevoir<br>un mail de confirmation</h2>",
                    "<p>Surveillez votre boîte mail.</p>"
                ]
            ],

            "PRlse" => [ //lost wording
                "restricted" => true,
                "wording" => [
                    "<h1>Oh non ...<br>dommage !</h1><hr>",
                    "<h2>Vous n'avez pas gagné.</h2>"
                ]
            ],

            "navigateur" => [
                "restricted" => false,
                "wording" => [
                    "<h1>Votre navigateur n'est pas compatible ...</h1><hr>",
                    "<h2>Vous pouvez utiliser les dernières versions de Google Chrome, Mozila Firefox, Safari ou Microsoft Edge.</h2>"
                ]
            ]
        ];
    }

    /**
     * Récupérer l'identifiant du prompt à afficher
     *
     * @return string
     */
    public function getTarget(): string
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        return $_GET['opt'] ?? $_SESSION["prompts"] ?? "default";
    }



    public function selectedPrompt(): array
    {
        if (defined("PROMPTS")) return PROMPTS[$this->target] ?? $this->default["defaultErrorPage"];
        return $this->default[$this->target] ?? $this->default["defaultErrorPage"];
    }

    public function getWording(): string
    {
        return implode("<br>", $this->selectedPrompt()["wording"]) ?? null;
    }

    public function getCommon(): ?string
    {
        return defined("PROMPTS") ? implode("<br>", PROMPTS["commonWording"]) : null;
    }

    public function getImage(): ?array
    {
        return $this->selectedPrompt()["image"] ?? null;
    }

    public function isRestricted(): bool
    {
        return $this->selectedPrompt()["restricted"];
    }
}
