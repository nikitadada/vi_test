<?php declare(strict_types=1);
$loader = require '../vendor/autoload.php';
$loader->register();

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

switch($request->getPathInfo()) {
    case '/':
        echo 'Home page';
        break;
    default:
        echo 'Not found';
}
