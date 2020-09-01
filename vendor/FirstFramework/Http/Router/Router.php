<?php


namespace FirstFramework\Http\Router;


use FirstFramework\Http\Request\RequestContract;
use FirstFramework\Http\Router\RouteContract;
use FirstFramework\Http\Router\RouteCollectionContract;

class Router implements RouterContract
{
    private static $collection;
    private static $route;
    private static $request;

    /**
     * @inheritDoc
     */
    public function __construct(RouteCollectionContract $collection, RequestContract $request) {
        static::$collection = $collection;
        static::$request = $request;
    }

    /**
     * @inheritDoc
     */
    public function match(): RouteContract
    {
        foreach (static::$collection->getRoutes() as $route) {
            if (in_array(static::$request->method(), $route->getMethods())
                && $route->match(static::$request->path())){
                return static::$route = $route;
            }
        }
        if (true){
            if ($this->badMethod()){
                throw new \Exception('Bad method');
            }
        }
        throw new \Exception('Page not found');
    }

    /**
     * @inheritDoc
     */
    public static function getCurrentRoute(): RouteContract
    {
        return static::$route;
    }

    /**
     * @inheritDoc
     */
    public static function generateUrl(string $routeName, array $params = []): string {
        foreach (static::$collection->getRoutes() as $route) {
            if (!in_array(static::$request->method(), $route->getMethods())){
                if ($route->match(static::$request->path())){
                    return true;
                }
            }
        }
        return false;
    }

    private function badMethod(): bool
    {
        foreach (static::$collection->getRoutes() as $route) {
            if (!in_array(static::$request->method(), $route->getMethods())) {
                if ($route->match(static::$request->path())) {
                    return true;
                }
            }
        }
        return false;
    }
}