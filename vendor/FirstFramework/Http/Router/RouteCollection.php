<?php


namespace FirstFramework\Http\Router;

use FirstFramework\Http\Router\RouteCollectionContract;
use FirstFramework\Http\Router\RouteContract;

class RouteCollection implements RouteCollectionContract
{
    private $collection = [];

    /**
     * @inheritDoc
     */
    public function add(array $methods = [], string $name, string $uri, $action, array $paramPattern = []): RouteContract
    {
        $methods = array_map(function ($item){
            return strtoupper($item);
        }, $methods);
        return $this->collection[$name] = new Route($methods, $name, $uri, $action, $paramPattern);
    }

    /**
     * @inheritDoc
     */
    public function post(string $name, string $uri, $action, array $paramPattern = []): RouteContract
    {
        return $this->collection[$name] = new Route(['POST'], $name, $uri, $action, $paramPattern);
    }

    /**
     * @inheritDoc
     */
    public function get(string $name, string $uri, $action, array $paramPattern = []): RouteContract
    {
        return $this->collection[$name] = new Route(['GET'], $name, $uri, $action, $paramPattern);
    }

    /**
     * @inheritDoc
     */
    public function put(string $name, string $uri, $action, array $paramPattern = []): RouteContract
    {
        return $this->collection[$name] = new Route(['PUT'], $name, $uri, $action, $paramPattern);
    }

    /**
     * @inheritDoc
     */
    public function patch(string $name, string $uri, $action, array $paramPattern = []): RouteContract
    {
        return $this->collection[$name] = new Route(['PATCH'], $name, $uri, $action, $paramPattern);
    }

    /**
     * @inheritDoc
     */
    public function delete(string $name, string $uri, $action, array $paramPattern = []): RouteContract
    {
        return $this->collection[$name] = new Route(['DELETE'], $name, $uri, $action, $paramPattern);
    }

    /**
     * @inheritDoc
     */
    public function getRoutes(): array
    {
        return $this->collection;
    }

    /**
     * @inheritDoc
     */
    public function getRouteByName(string $name): RouteContract
    {
        return $this->collection[$name];
    }
}