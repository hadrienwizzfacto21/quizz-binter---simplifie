<?php

namespace Keemia\UserAgent;

/**
 * UserAgentClass
 */
class UserAgentClass
{
    public $userAgent;

    public function __construct()
    {
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * Browser
     *
     * @return string
     */
    public function Browser(): string
    {
        switch (true) {
            case preg_match('/MSIE/i',  $this->userAgent) && !preg_match('/Opera/i',  $this->userAgent):
                return 'Internet Explorer';
                break;

            case preg_match('/Firefox/i',  $this->userAgent):
                return 'Firefox';
                break;

            case preg_match('/Edg/i',  $this->userAgent):
                return 'Edge';
                break;

            case preg_match('/Chrome/i',  $this->userAgent):
                return 'Chrome';
                break;

            case preg_match('/Safari/i',  $this->userAgent):
                return 'Safari';
                break;

            case preg_match('/Opera/i',  $this->userAgent):
                return 'Opera';
                break;

            default:
                return 'Autre';
                break;
        }
    }

    /**
     * Device
     *
     * @return string
     */
    public function Device(): string
    {
        switch (true) {
            case preg_match('/mobile|mob/i', $this->userAgent):
            case preg_match('/iPhone/i',  $this->userAgent):
            case preg_match('/linux|Android/i',  $this->userAgent):
                return "Mobile";
                break;

            case preg_match('/iPad/i',  $this->userAgent):
            case preg_match('/tablette|tab|tablet/i', $this->userAgent):
                return "Tablette";
                break;

            case preg_match('/macintosh|mac os x/i',  $this->userAgent):
            case preg_match('/macintosh|mac os x/i',  $this->userAgent):
            case preg_match('/windows|win32/i',  $this->userAgent):
            default:
                return "Desktop";
                break;
        }
    }

    /**
     * Platform
     *
     * @return string
     */
    public function Platform(): string
    {
        switch (true) {
            case preg_match('/linux|Android/i',  $this->userAgent):
                return 'Android';
                break;

            case preg_match('/iPhone/i',  $this->userAgent):
                return 'iOS';
                break;

            case preg_match('/iPad/i',  $this->userAgent):
                return 'iPadOS';
                break;

            case preg_match('/macintosh|mac os x/i',  $this->userAgent):
                return 'macOS';
                break;
            case preg_match('/windows|win32/i',  $this->userAgent):
                return 'Windows';
                break;

            default:
                return 'Autre';
                break;
        }
    }

    /**
     * Create an array of all datas
     *
     * @return array
     */
    public function ToArray(): array
    {
        return [
            "operating_system" => $this->Platform(),
            "browser" => $this->Browser(),
            "device" => $this->Device()
        ];
    }
}
