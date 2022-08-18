<?php



function uaUserAgent()
{
    // GET USER AGENT
    $u_agent = $_SERVER['HTTP_USER_AGENT'];

    // GET BROWSER
    switch (true) {
        case preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent):
            $browser = 'Internet Explorer';
            break;

        case preg_match('/Firefox/i', $u_agent):
            $browser = 'Firefox';
            break;

        case preg_match('/Edg/i', $u_agent):
            $browser = 'Edge';
            break;

        case preg_match('/Chrome/i', $u_agent):
            $browser = 'Chrome';
            break;

        case preg_match('/Safari/i', $u_agent):
            $browser = 'Safari';
            break;

        case preg_match('/Opera/i', $u_agent):
            $browser = 'Opera';
            break;

        default:
            $browser = 'Autre';
            break;
    }

    // GET DEVICE
    switch (true) {
        case preg_match('/mobile|mob/i', $u_agent):
            $device = "Mobile";
            break;

        case preg_match('/tablette|tab|tablet/i', $u_agent):
            $device = "Tablette";
            break;

        default:
            $device = "Desktop";
            break;
    }

    // GET PLATFORM
    switch (true) {
        case preg_match('/linux|Android/i', $u_agent):
            $platform = 'Android';
            $device = "Mobile";
            break;

        case preg_match('/iPhone/i', $u_agent):
            $platform = 'iOS';
            $device = "Mobile";
            break;

        case preg_match('/iPad/i', $u_agent):
            $platform = 'iPadOS';
            $device = "Tablette";
            break;

        case preg_match('/macintosh|mac os x/i', $u_agent):
            $platform = 'macOS';
            $device = "Desktop";
            break;
        case preg_match('/windows|win32/i', $u_agent):
            $platform = 'Windows';
            $device = "Desktop";
            break;

        default:
            $platform = 'Autre';
            $device = "Autre";
            break;
    }

    // RETURN
    return $userAgent = [
        "operating_system" => $platform,
        "browser" => $browser,
        "device" => $device
    ];
}
