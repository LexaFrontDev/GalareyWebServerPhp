<?php


header("Content-Type: application/json; charset=UTF-8");


use App\Service\WorkWithJson\Request;
use App\Container\Container;
use App\Routes\Routes;
require 'vendor/autoload.php';

$container = new Container();
$container->registerClassesInDirectory(__DIR__ . '/src');

$request = $container->get(Request::class)->getRequest();
$url = $request['url'];
$method = $request['method'];

$routes = new Routes();
$routes->routes($container, $url, $method);



