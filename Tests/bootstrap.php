<?php

if (is_file($autoloadFile = 'vendor/autoload.php')) {
    $loader = require $autoloadFile;
} elseif (is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    $loader = require $autoloadFile;
} else {
    throw new \LogicException('Run "composer install --dev" to create autoloader.');
}
