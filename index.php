<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if (php_sapi_name() === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    if (is_file($file)) {
        return false;
    }
}

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$viewDir = '/views/';

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;

    case '/contact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $token = $_POST['cf-turnstile-response'] ?? '';

            $secret = $_ENV['TURNSTILE_SECRET_KEY'];

            $verify = file_get_contents(
                "https://challenges.cloudflare.com/turnstile/v0/siteverify",
                false,
                stream_context_create([
                    'http' => [
                        'method' => 'POST',
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'content' => http_build_query([
                            'secret' => $secret,
                            'response' => $token,
                            'remoteip' => $_SERVER['REMOTE_ADDR'],
                        ]),
                    ]
                ])
            );

            $result = json_decode($verify, true);

            if (!empty($result['success'])) {
                // CAPTCHA passed — show contact info
                echo "<h2>Thanks For Verifying</h2>";
                echo "<h4>Contact Info <br> Email: iusearchbtw845@gmail.com <br> Alternate Email (in case i don't respond within a month): vinci845@icloud.com </h4>";
                exit;
            } else {
                // CAPTCHA failed — show error or form again
                echo "<p>CAPTCHA failed — try again.</p>";
                require __DIR__ . $viewDir . 'contact.php';
                exit;
            }
        }
        require __DIR__ . $viewDir . 'contact.php';
        break;

    case '/portfolio':
        require __DIR__ . $viewDir . 'portfolio.php';
        break;

    case '/projects':
        require __DIR__ . $viewDir . 'projects.php';
        break;

    case '/matrix':
        require __DIR__ . $viewDir . 'matrix.php';
        break;

    case '/portfolio/commission':
        require __DIR__ . $viewDir . 'commission.php';
        break;

    case '/gallery':
        require __DIR__ . $viewDir . 'gallery.php';
        break;

    case '/host':
        require __DIR__ . $viewDir . 'host.php';
        break;

    // EASTER EGGS

    case '/845':
        require __DIR__ . $viewDir . '845.php';
        break;

    case '/bob':
        require __DIR__ . $viewDir . 'bob.php';
        break;


    default:
        http_response_code(404) or http_response_code(403) or http_response_code(303) or http_response_code(500);
        $error = http_response_code();
        require __DIR__ . $viewDir . 'error.php';
        break;
}

