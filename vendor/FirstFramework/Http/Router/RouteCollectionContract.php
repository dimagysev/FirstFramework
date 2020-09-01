<?php

namespace FirstFramework\Http\Router;

interface RouteCollectionContract
{
    /**
     * @param array $methods
     * @param string $name
     * @param string $uri
     * @param callable|string $action
     * @param array $paramPattern
     * @return RouteContract
     */
    public function add(array $methods = [], string $name, string $uri, $action, array $paramPattern = []) : RouteContract;

    /**
     * @param string $name
     * @param string $uri
     * @param callable|string $action
     * @param array $paramPattern
     * @return RouteContract
     */
    public function post(string $name, string $uri, $action, array $paramPattern = []) : RouteContract;

    /**
     * @param string $name
     * @param string $uri
     * @param callable|string $action
     * @param array $paramPattern
     * @return RouteContract
     */
    public function get(string $name, string $uri, $action, array $paramPattern = []) :RouteContract;

    /**
     * @param string $name
     * @param string $uri
     * @param callable|string $action
     * @param array $paramPattern
     * @return RouteContract
     */
    public function put(string $name, string $uri, $action, array $paramPattern = []) :RouteContract;

    /**
     * @param string $name
     * @param string $uri
     * @param callable|string $action
     * @param array $paramPattern
     * @return RouteContract
     */
    public function patch(string $name, string $uri, $action, array $paramPattern = []) :RouteContract;

    /**
     * @param string $name
     * @param string $uri
     * @param callable|string $action
     * @param array $paramPattern
     * @return RouteContract
     */
    public function delete(string $name, string $uri, $action, array $paramPattern = []) : RouteContract;

    /**
     * @return array
     */
    public function getRoutes() : array;

    /**
     * @param string $name
     * @return RouteContract
     */
    public function getRouteByName(string $name): RouteContract;
}