<?php
require "core/loader.php";

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_filter(explode('/', trim($request, '/')));

$routesDir = __DIR__ . '/routes/';
$params = [];
$targetPath = $routesDir;

try {
    foreach ($segments as $segment) {
        $found = false;
        $dirs = glob($targetPath . '/*', GLOB_ONLYDIR);

         foreach ($dirs as $dir) {
             $dirname = basename($dir);
             if (($dirname === $segment) || (str_starts_with($dirname, '[') and str_ends_with($dirname, ']'))){
                 if (str_starts_with($dirname, '[')){
                     $key = trim($dirname, '[]');
                      $params[$key] = $segment;
                 }
                 $targetPath = $dir;
                 $found = true;
                 break;
             }
         }
         if (!$found) {
             http_response_code(404);
             die("404 Not Found");
         }
    }

    $pageFile = $targetPath . '/+page.php';
    if (file_exists($pageFile)) {
        extract($params);
        require $pageFile;
    } else {
        http_response_code(404);
        echo "Page template not found.";
    }
} catch (Throwable $e){

    http_response_code(500);

    // log it

    $logger->log(300, $e->getMessage());

    if ($UTIL->IsDevMode()) {

        echo $e;

    } else {

        echo "Internal Server Error";
    }
}
