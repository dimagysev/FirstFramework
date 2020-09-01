<?php


namespace FirstFramework\Http\Request;


class Request implements RequestContract
{
    private $post = [];
    private $get = [];
    private $files = [];
    private $coockie = [];
    private $server = [];
    private $requestHeaders = [];
    private $method;
    private $path;

    public function __construct()
    {
        $this->getGlobals();
    }

    public function method(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->requestHeaders;
    }

    public function getHeader(string $key): ?string
    {
        return $this->requestHeaders[$key] ?? null;
    }

    public function hasHeader(string $key): bool
    {
        return array_key_exists($key, $this->requestHeaders)
            && !empty($this->getHeader($key));
    }

    public function cookie(string $key)
    {
        return $this->coockie[$key] ?? null;
    }

    public function hasCookie(string $key): bool
    {
        return array_key_exists($key, $this->coockie)
            && !empty($this->cookie($key));
    }

    public function getServerParam(string $key)
    {
        return $this->server[$key] ?? null;
    }

    public function getAllServerParams(): array
    {
        return $this->server;
    }

    public function getAllCookies(): array
    {
        return $this->coockie;
    }

    public function setServerParam(string $key, $value): void
    {
        $key = strtoupper($key);
        $this->server[$key] = $value;
    }

    public function getBodyParam(string $key, $default = null)
    {
        return $this->post[$key] ?? $default ?? $key;
    }

    public function getBodyParams(): array
    {
        return $this->post;
    }

    public function getQueryParam(string $key, $default = null)
    {
        return $this->get[$key] ?? $default ?? $key;
    }

    public function getQueryParams(): array
    {
        return $this->get;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function hasQueryParam(string $key): bool
    {
        return array_key_exists($key, $this->getQueryParams())
            && !empty($this->getQueryParam($key));
    }

    public function hasBodyParam(string $key): bool
    {
        return array_key_exists($key, $this->getBodyParams())
            && !empty($this->getBodyParam($key));
    }

    public function ajax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    public function getGlobals(): void
    {
        $this->requestHeaders = getallheaders();
        $this->server = $_SERVER;
        $this->coockie = $_COOKIE;
        $this->path = $this->getPathFromGlobal();
        $this->post = $this->getBodyParamsFromGlobal();
        $this->get = $_GET;
        $this->method = $this->getRequestMethodFromGlobal();
    }

    private function getPathFromGlobal()
    {
        $queryString = $this->getServerParam('QUERY_STRING');
        $requestUri = $this->getServerParam('REQUEST_URI');
        $path = str_replace('?' . $queryString,'', $requestUri);
        $path = trim($path, '/');
        return empty($path) ? '/' : $path;
    }

    private function getBodyParamsFromGlobal() : array
    {
        $postStream = file_get_contents('php://input');
        $post = $_POST;
        if(is_object(json_decode($postStream )) && (json_last_error() == JSON_ERROR_NONE)){
            $postJSON = json_decode($postStream );
            foreach ($postJSON as $key => $value) {
                $post[$key] = $value;
            }
        }
        return $post;
    }

    private function getRequestMethodFromGlobal()
    {
        $method = $this->getServerParam('REQUEST_METHOD');
        if ($method === 'POST'){
            if ($this->hasBodyParam('_method')
                && in_array(strtoupper($this->getBodyParam('_method')), ['POST', 'PUT', 'PATCH', 'DELETE'])){
                $this->setServerParam('REQUEST_METHOD', strtoupper($this->getBodyParam('_method')));
                $method = strtoupper($this->getBodyParam('_method'));
            }
        }
        return $method;
    }
}