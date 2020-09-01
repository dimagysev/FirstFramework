<?php

require_once '../vendor/autoload.php';



try {
    $routes = require '../router/routes.php';
    $request = new FirstFramework\Http\Request\Request();
    $router = new \FirstFramework\Http\Router\Router($routes, $request);
    $route = $router->match();
    $result = call_user_func($route->getAction(), ...array_values($route->getParams()));
    (new \FirstFramework\Http\Response\Response($result))->send();

}catch (Throwable $e){
    dump($e);
}
