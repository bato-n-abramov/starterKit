<?php

// Prevent loading from WP, only use command line with one argument.
if (!isset($argc) || $argc != 2 || ($argv[1] != 'install' && $argv[1] != 'update')) {
    return;
}

$files = new RecursiveDirectoryIterator(__DIR__);

$paths = [];

// Find path to execute composer install
foreach (new RecursiveIteratorIterator($files) as $filePath) {
    $exploded = explode('/', $filePath);
    $fileName = array_pop($exploded);

    // Check if the file is a composer.json and is not a /vendor children
    if ($fileName == 'composer.json' && !in_array('vendor', $exploded)) {
        $paths[] = implode('/', $exploded);
    }
}

// Execute composer install on foud paths
foreach ($paths as $path) {
    $cmd = sprintf('cd %s && composer --no-interaction --ansi %s', $path, $argv[1]);
    echo sprintf("\n\n——— Running composer in [ %s ]\n————————— cmd: %s\n\n", $path, $cmd);
    echo shell_exec($cmd);
}
