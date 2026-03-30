<?php
require __DIR__ . '/vendor/autoload.php';

use Brick\DateTime\Instant;
use Brick\DateTime\Duration;

session_start();

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

function IsDevMode(): bool
{
    if ($_ENV['ENV_TYPE'] == 'DEVELOPMENT')
        return true;
    elseif ($_ENV['ENV_TYPE'] == 'PRODUCTION')
        return false;
    else return false;
}

function CloudflareTurnstileVerify(string $token): bool
{
    if (empty($token)) {
        return false;
    }

    $secret = $_ENV['TURNSTILE_SECRET'];

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

    if ($verify === false) {
           return false;
    }

    $result = json_decode($verify, true);

    return !empty($result['success']);
}

function rateLimit(string $key, int $maxRequests, int $windowSeconds): bool
{
    if (IsDevMode()) {
        return true;
    }

    $now = Instant::now();
    $window = Duration::ofSeconds($windowSeconds);

    $history = $_SESSION['rate_limit'][$key] ?? [];

    // filter using Instant recreation from epoch
    $_SESSION['rate_limit'][$key] = array_filter(
        $history,
        function ($epoch) use ($now, $window) {
            $t = Instant::of($epoch);
            return $t->plus($window)->isAfter($now);
        }
    );

    if (count($_SESSION['rate_limit'][$key]) >= $maxRequests) {
        return false;
    }

    // store epoch seconds
    $_SESSION['rate_limit'][$key][] = $now->getEpochSecond();

    return true;
}

switch ($request) {
    case '':
    case '/':
        require __DIR__ . $viewDir . 'home.php';
        break;

    case '/contact':
        if (!rateLimit('contact',7, 10)) {
            http_response_code(429);
            $error = http_response_code();
            require __DIR__ . $viewDir . 'error.php';
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $token = $_POST['cf-turnstile-response'] ?? '';

            if (CloudflareTurnstileVerify($token) or (IsDevMode())) {
                $_SESSION['turnstile_once'] = true;
                header('Location: /contactinfo');
                exit;
            } else {
                require __DIR__ . $viewDir . 'contact.php';
                exit;
            }
        }
        require __DIR__ . $viewDir . 'contact.php';
        break;

    case '/contactinfo':
        if (!rateLimit('contactinfo', 3, 20)) {
            http_response_code(429);
            $error = http_response_code();
            require __DIR__ . $viewDir . 'error.php';
            exit;
        }

        if (empty($_SESSION['turnstile_once'])) {
            http_response_code(403);
            $error = http_response_code();
            require __DIR__ . $viewDir . 'error.php';
            exit;
        }

        unset($_SESSION['turnstile_once']);

        require __DIR__ . $viewDir . 'protected/info.php';
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

// TODO, FINISH Random number generator

//    case '/randomnumbers':
//        if (!rateLimit('randomnumbers', 10, 20)) {
//            http_response_code(429);
//            $error = http_response_code();
//            require __DIR__ . $viewDir . 'error.php';
//            exit;
//        }
//
//        require __DIR__ . $viewDir . 'rng.php';
//        break;

    // EASTER EGGS

    case '/845':
        require __DIR__ . $viewDir . 'easter/845.php';
        break;

    case '/bob':
        require __DIR__ . $viewDir . 'easter/bob.php';
        break;



    default:
        http_response_code(404) or http_response_code(403) or http_response_code(303) or http_response_code(500);
        $error = http_response_code();
        require __DIR__ . $viewDir . 'error.php';
        break;
}
