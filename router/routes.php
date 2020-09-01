<?php
$routes = new \FirstFramework\Http\Router\RouteCollection();

$routes->get('index', '/', 'IndexController::index');
$routes->get('test', '/test', 'IndexController::test');
$routes->get('callback', '/test/callback/{id}', function ($id){
    return 'callback-----' . $id;
});

return $routes;