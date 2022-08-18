<?php

namespace Keemia;

class RouterClass
{

    public function __construct()
    {
    }

    /**
     * Check if DevMode is active   
     *
     * @return bool
     */
    public function IsDevMode(): bool
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $devMode = $_GET["dev"] ?? $_SESSION["rte"]["devMode"] ?? "false"; //enable devMode if ?dev or in session
        $_SESSION["rte"]["devMode"] = $devMode; // keep in session

        return (isset($devMode) && $devMode != "false");
    }

    /**
     * Check si le site est accessible ou en page teasing
     *
     * @param  mixed YYY MM DD HH II date de début
     * @return bool
     */
    public function IsStarted(int $startOP): bool
    {
        return date("ymdHi") <= $startOP;
    }

    /**
     * Check si le site n'est plus accessible ou en page fin d'op
     *
     * @param  mixed YYY MM DD HH II date de fin
     * @return bool
     */
    public function IsEnded(int $endOP): bool
    {
        return date("ymdHi") >= $endOP;
    }

    /**
     * Check si le navigateur est compatible avec le site
     *
     * @return bool
     */
    public function IsNotCompatible(): bool
    {
        return (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(; Touch)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT']));
    }

    //    
    /**
     * Check si un session id est bien défini, sinon retour sur la home
     *
     * @return string
     */
    public function IsSessionIdSet(): string
    {
        return isset($_SESSION["wzo"]["conInfo"]["session_id"]); //no session ids
    }

    /**
     * Retourne la page actuelle
     *
     * @return string
     */
    public function CurrentPage(): string
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?? "/";
    }

    /**
     * Retourne le template utilisé
     *
     * @param  mixed Tableau de configuration (json weezio)
     * @return string LP=landing page MS=MiniSite etc
     */
    public function Template(array $config): string
    {
        $type = $config["routing"]["type"] ?? null;
        if ($type == "LP") return "./templates/landingpage/landingpage.php";
        if ($type == "MS") return "./templates/minisite/minisite.php";
    }

    public function Redirect(string $target = null)
    {
        return isset($target) ? header("Location: ./prompts?opt=$target") : header("Location: ./");
    }
}
