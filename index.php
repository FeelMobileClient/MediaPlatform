<?php

require_once __DIR__ . "/lib/Autoloader.php";

$autoloader = new Autoloader;
$autoloader->register();

$autoloader->addNamespace('Library', __DIR__ . '/lib/');

$frontController = new Library\FrontController();
$frontController->run();
