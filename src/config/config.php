
<?php

// CONFIG
// Edit globals landing pages settings
$_SESSION["library"]["config"] = $config = [

    "meta" => [
        "author" => "BINTER",
        "title" => "BINTER ",
        "descrTitle" => "BINTER : Cliquez pour participer !", //useful when sharing link
        "descr" => " Jouez avec BINTER et tentez de gagner de nombreux lots !",
        "keywords" => "BINTER, jeu, formulaire, quiz",
        "illustration" => "./styles/img/illuIndex.jpg" //useful on social media
        // "favicon" => "./styles/ico/favicon.ico"
    ],

    "legals" => [
        "client" => "BINTER",
        "politiqueConfidentialiteUrl" => "https://www.bintercanarias.com/fre/privacity",
        "reglementUrl" => "./reglement.pdf",
        "mentionsLegalesUrl" => "./mentionslegales",
        "googleTag" => "G-D7F06H4Q1T" //optional
    ],

    "routing" => [
        "startOP" => "2208260000", //when the op start YYMMDDhhmm
        "endOP" => "2208272359" //when the op end YYMMDDhhmm
    ],

    "weezio" => [
        "weezioParam" => [
            "api_key" => "3cb1cd5b-add6-48d9-bd02-b32911b4c1d5",
            "interface_id" => 168,
            "task_id" => 126
        ],
        "level_id" => [
            "scenarioStart" => 1,
            "formSubmit" => 2,
            "scenarioEnd" => 3,
            "redirection" => 4
        ],
        "postForm" => true, //alow data to be sent
        "checkParticipation" => false //allow only one participation/email adress
    ],
];


// TEMPLATES
// Edit templates sections settings, styling and content
$_SESSION["library"]["configTemplates"] = $configTemplates = [

    "globals" => [
        "bg" => [
            "bg-image" => null
        ],
    ],

    "header" => [
        "active" => true,
        "logo" => [
            "./styles/img/logo.png",
        ]
    ],

    "hero" => [
        "active" => true,
        "title" => "2 vols pour<br>2 personnes à gagner<br>depuis Lille",
        "image" => null,
        "wording" => "du 26 au 27 Août<br><br>",
        "btn" => "Je joue !"
    ],

    "illustration" => [
        "index" => [
            "active" => true,
            "onMobile" => true,
            "image" => [
                "desktop" => "./styles/img/illu-index.jpg",
                "alt" => "Illustration"
            ],
            "wording" => [
                null
            ]
        ],
        "form" => [
            "active" => true,
            "onMobile" => false,
            "image" => [
                "desktop" => "./styles/img/illu-form.jpg",
                "alt" => "Illustration"
            ],
            "wording" => [
                "<h1>Embarquez pour la Gran Canaria</h1>"
            ]
        ]
    ],

    "apps" => [
        "active" => true,
        "title" => null,
        "activeApp" => "app-quiz", //app-scratch/app-jackpot/app-wheel ...
        "btnNext" => null
    ],

    "networks" => [
        "active" => false,
        "website" => [null, "./styles/ico/website.svg"], //URL + Ico path
        "facebook" => ["https://fr-fr.facebook.com/bintercanarias", "./styles/ico/facebook.svg"],
        "linkedin" => [null, "./styles/ico/linkedin.svg"],
        "twitter" => [null, "./styles/ico/twitter.svg"],
        "youtube" => [null, "./styles/ico/youtube.svg"],
        "instagram" => ["https://www.instagram.com/binter_fr", "./styles/ico/instagram.svg"]
    ],

    "form" => [
        "active" => true,
        "title" => "Vos coordonnées",
        "btnSubmit" => "C'est parti !",
        "inputs" => [
            // [
            //     "id" => "Area",
            //     "type" => "select",
            //     "label" => "Secteur",
            //     "options" => [
            //         "required",
            //     ],
            //     "content" => [
            //         "Strasbourg" => "Strasbourg",
            //         "Lille" => "Lille",
            //         "Nancy-Metz" => "Nancy-Metz",
            //     ]
            // ],
            [
                "id" => "LastName",
                "type" => "text",
                "label" => "Nom",
                "options" => [
                    "required",
                    "pattern=\"[A-Za-zÀ-ÿ '-]{2,20}\"",
                    "size='20'"
                ]
            ],
            [
                "id" => "FirstName",
                "type" => "text",
                "label" => "Prénom",
                "options" => [
                    "required",
                    "pattern=\"[A-Za-zÀ-ÿ '-]{2,20}\"",
                    "size='20'"
                ]
            ],
            [
                "id" => "Email",
                "type" => "email",
                "label" => "Email",
                "options" => [
                    "required",
                    "pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$'",
                    "size='20'",
                ]
            ],
            [
                "id" => "Telephone",
                "type" => "tel",
                "label" => "Téléphone",
                "options" => [
                    "pattern ='[0-9]{10}'",
                    "size='10'"
                ]
            ],
        ],

        "optins" => [
            [
                "id" => "Optin1",
                "type" => "checkbox",
                "label" => "J'accepte le règlement du jeu",
                "options" => ["required"]
            ],
            [
                "id" => "Optin2",
                "type" => "checkbox",
                "label" => "J'accepte de recevoir la Newsletter de Binter par email",
                "options" => [null]
            ],
            [
                "id" => "Optin3",
                "type" => "checkbox",
                "label" => "J'accepte de recevoir la Newsletter de Binter par SMS",
                "options" => [null]
            ],

        ]
    ],
];


// PROMTPS
// Edit the wordings of the /prompts page
$_SESSION["library"]["configPrompts"] = $configPrompts = [

    "clientRedir" => "https://www.bintercanarias.com/fre",

    "commonWording" => [
        "<h3>Retrouvez toutes nos actualités sur www.bintercanarias.com</h3>"
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
            "<h2>Merci de réessayer plus tard.</h2>",
        ]
    ],

    "PRl1t" => [ //prize 1 wording
        "restricted" => true,
        "wording" => [
            "<h3>Une seule bonne réponse :</h3><h1>Gran Canaria !</h1><br>",
            "<h2>Félicitations</h2><p>Votre participation est enregistrée pour participer à notre tirage au sort et gagner des vols depuis Lille en direction de Gran Canaria !</p>"
        ],
        "image" => [
            "desktop" => "./styles/img/hero.jpg",
            "mobile" => "",
            "alt" => "Lot 1"
        ]
    ],

    "PRlse" => [ //lost wording
        "restricted" => true,
        "wording" => [
            "<h1>Oh non ...<br>dommage !</h1><hr>",
            "<h2>Vous n'avez pas gagné.</h2>"
        ],
        "image" => [
            "desktop" => "",
            "mobile" => "",
            "alt" => "Perdu"
        ]
    ]
];

// DEFINE CONSTANTS
define("CONFIG", $config);
define("TEMPLATES", $configTemplates);
define("PROMPTS", $configPrompts);
