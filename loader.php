<?php

require ROOT_DIR . '/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(ROOT_DIR);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    echo "Unable to load configuration file";
    exit(1);
}