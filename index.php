<?php

//set_error_handler("errorHandler");
//set_exception_handler("exceptionHandler");

require_once __DIR__ . "/lib/Autoloader.php";

$autoloader = new Autoloader;
$autoloader->register();

$autoloader->addNamespace('Library', __DIR__ . '/lib/');
$autoloader->addNamespace('MediaPlatform\\Controller', __DIR__ . '/controller/');

$frontController = new Library\FrontController();
$frontController->run();

function errorHandler($errno, $errstr, $errfile, $errline)
{
    echo "error no $errno <br>\n";
    echo "error str $errstr <br>\n";
    echo "error file $errfile <br>\n";
    echo "error line $errline <br>\n";
}

function exceptionHandler($exception)
{
    http_response_code(404);
    include(__DIR__ . "/view/404.html");
    //echo "exception with $exception";
}

