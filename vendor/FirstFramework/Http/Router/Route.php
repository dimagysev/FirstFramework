<?php


namespace FirstFramework\Http\Router;


class Route implements RouteContract
{
    private $name;
    private $pattern;
    private $uri;
    private $action;
    private $params;
    private $methods = [];
    private $paramPattern =[];
    private $middlewares = [];
    private const DEFAULT_PARAM_PATTERN = '[A-Z_a-z-0-9-]+';

    /**
     * @inheritDoc
     */
    public function __construct(array $methods, string $name, string $uri, $action, array $paramPattern = [])
    {
        $this->name = $name;
        $this->methods = $methods;
        $this->action = $this->parseAction($action);
        $this->uri = $uri;
        $this->paramPattern = $paramPattern;
        $this->pattern = $this->parseUri($uri);
    }

    /**
     * @inheritDoc
     */
    public function match(string $uri): bool
    {
        if (preg_match('#' . $this->pattern . '#i', $uri, $matches)){
            $this->params = array_filter($matches, '\is_string',2);
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function generateUrl(array $params): string
    {
        $uri = preg_replace_callback('#\{([A-Z_a-z-]+[0-9]*?)\}#', function ($matches) use ($params){
            return  $params[$matches[1]];
        }, $this->uri);
        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @inheritDoc
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @inheritDoc
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @inheritDoc
     */
    public function middleware(array $middlewares)
    {
        // TODO: Implement middleware() method.
    }

    /**
     * @inheritDoc
     */
    public function getMiddlewares(): array
    {
        // TODO: Implement getMiddlewares() method.
    }

    /**
     * @param $action
     *
     * @return callable|false|string[]
     */
    private function parseAction($action)
    {
        if (is_callable($action)){
            return $action;
        }
        $action = explode('::', $action,2);
        $controller = '\\App\\Controllers\\' . $action[0];
        $action[0] = new $controller;
        return $action;
    }

    private function parseUri(string $uri) : string
    {
        $uri = preg_replace_callback('#\{([A-Z_a-z-]+[0-9]*?)\}#', function ($matches) {

            $pattern = !empty($this->paramPattern[$matches[1]])
                ? $this->paramPattern[$matches[1]]
                : self::DEFAULT_PARAM_PATTERN;

            return  '(?P<'.$matches[1] .'>' . $pattern . ')';

        }, $uri);

        $uri = trim($uri,'/');
        return '^' . $uri . '/?$';
    }
}