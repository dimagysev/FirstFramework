<?php

namespace FirstFramework\Http\Router;

interface RouteContract
{
    /**
     * RouteContract constructor.
     * @param array $methods
     * @param string $name
     * @param string $uri
     * @param callable|string $action
     * @param array $paramPattern
     */
    public function __construct(array $methods, string $name, string $uri, $action, array $paramPattern = []);

    /**
     * @param string $uri
     * @return bool
     */
    public function match(string $uri) : bool;

    /**
     * @param array $params
     * @return string
     */
    public function generateUrl(array $params) : string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return callable|false|string[]
     */
    public function getAction();

    /**
     * @return array
     */
    public function getParams() : array;

    /**
     * @return array
     */
    public function getMethods(): array;

    /**
     * @param array $middlewares
     * @return RouteContract
     */
    public function middleware(array $middlewares);

    /**
     * @return array
     */
    public function getMiddlewares(): array;
}