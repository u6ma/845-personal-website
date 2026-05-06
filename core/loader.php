<?php

// YO GURT LOADER Version 2

function findfiles($dir): array
{
    $files = [];
    $rootdir = __DIR__ . "/$dir";

    if (!is_dir($rootdir)) {
        return $files;

    }

    foreach (scandir($rootdir) as $item){
        if ($item === '.' || $item === '..') continue;
        $path = $rootdir . '/' . $item;

        if (is_dir($path)) {
            $files = array_merge($files, findfiles("$dir/$item"));
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $files[] = $path;
        }

    }
    return $files;
}


function requirefiles(array $files): void
{
    foreach ($files as $file) {
        if (file_exists($file)) {
            require_once $file;
        }
    }
}

requirefiles(findfiles('helpers'));

requirefiles(findfiles('middleware'));

requirefiles(findfiles('controllers'));
