<?php
define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/loader.php';

$params = require ROOT_DIR . '/config/params.php';
$bootstrap = new \App\Bootstrap(new \App\Config($params));

(new \App\Application($bootstrap))->run();
