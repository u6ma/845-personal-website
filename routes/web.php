<?php

$viewDir = '../views/';

return [
    'GET' => [
    // Static pages
        '/' => fn() => require __DIR__ . $viewDir . 'home.php',
        '/portfolio' => fn() => require __DIR__ . $viewDir . 'portfolio.php',
        '/portfolio/commission' => fn() => require __DIR__ . $viewDir . 'commission.php',
        '/contact' => fn() => require __DIR__ . $viewDir . 'contact.php',
        '/gallery' => fn() => require __DIR__ . $viewDir . 'gallery.php',
        '/projects' => fn() => require __DIR__ . $viewDir . 'projects.php',
        '/host' => fn() => require __DIR__ . $viewDir . 'host.php',
        '/matrix' => fn() => require __DIR__ . $viewDir . 'matrix.php',

        // TEMPLATE
        // '' => fn() => require __DIR__ . $viewDir . '',
    ],
    'POST' => [

    ],
];
