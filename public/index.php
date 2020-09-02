<?php

define('ROOT', dirname(__DIR__));
define('VENDOR', ROOT  . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);
define('APP', ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR);
define('WWW', ROOT  . DIRECTORY_SEPARATOR .  'public' . DIRECTORY_SEPARATOR);
define('CONFIG', ROOT  . DIRECTORY_SEPARATOR .  'config' . DIRECTORY_SEPARATOR);
define('ROUTER', ROOT . DIRECTORY_SEPARATOR . 'router' . DIRECTORY_SEPARATOR);
define('LAYOUT', 'default');
define('DEBUG', true);

require_once VENDOR . 'autoload.php';

(\Dotenv\Dotenv::createUnsafeImmutable(ROOT))->load();

try {

    $request = new FirstFramework\Http\Request\Request();
    $routes = require ROUTER . 'routes.php';
    $route = (new \FirstFramework\Http\Router\Router($routes, $request))->match();
    $result = call_user_func($route->getAction(), ...array_values($route->getParams()));
    (new \FirstFramework\Http\Response\Response($result))->send();
    $pdo = (\FirstFramework\DB\DBConnection::instance())->pdo();
    dump($pdo);

}catch (Throwable $e){
    dump($e);
}
