<?php

namespace FirstFramework\Http\Router;


use FirstFramework\Http\Request\RequestContract;

interface RouterContract
{
    /**
     * Router constructor.
     * @param RouteCollectionContract $collection
     * @param RequestContract $request
     */
    public function __construct(RouteCollectionContract $collection, RequestContract $request);

    /**
     * @return RouteContract
     * @throws BadMethodException
     * @throws PageNotFoundException
     */
    public function match() : RouteContract;

    /**
     * @return RouteContract
     */
    public static function getCurrentRoute() : RouteContract;

    /**
     * @param string $routeName
     * @param array $params
     * @return string
     */
    public static function generateUrl(string $routeName, array $params = []) : string;
}