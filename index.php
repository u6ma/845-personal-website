<?php
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

