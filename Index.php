<?php


header("Content-Type: application/json; charset=UTF-8");


use App\Service\WorkWithJson\Request;
use App\Container\Container;
use App\Routes\Routes;
use App\Model\DatabaseConfig\DatabaseConnect;
require 'vendor/autoload.php';

$db = new DatabaseConnect();
$pdo = $db->getConnection();

$container = new Container();
$container->registerClassesInDirectory(__DIR__ . '/src');
$container->registerInstance(\PDO::class, $pdo);

$request = $container->get(Request::class)->getRequest();
$url = $request['url'];
$method = $request['method'];

$routes = new Routes();
$routes->routes($container, $url, $method);



