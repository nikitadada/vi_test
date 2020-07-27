<?php

use App\Container;

require_once('../vendor/autoload.php');

$container = Container::buildContainer(dirname(__DIR__));

$response = $container->get('response');
$response->send();