<?php


namespace FirstFramework\Http\Response;


class Response implements ResponseContract
{
    protected $content;
    protected $code;
    protected $headers = [];
    protected $isRedirect = false;
    protected $redirectPath ;

    public function __construct($content = null, int $code = 200, array $headers = [])
    {
        $this->content = $content;
        $this->code = $code;
        $this->setHeaders($headers);
    }

    public function setStatusCode(int $code) : ResponseContract
    {
        $this->code = $code;
        return $this;
    }

    public function setHeader(string $header, string $value) : ResponseContract
    {
        $this->headers[$header] = $value;
        return $this;
    }

    public function setHeaders(array $headers) : ResponseContract
    {
        foreach ($headers as $header => $value){
            $this->setHeader($header, $value);
        }
        return $this;
    }

    public function content($content) : ResponseContract
    {
        if (is_array($content)){
            $this->json($content);
        }else{
            $this->content = ($content instanceof Response)
                ? $this->content = $content->content
                : $this->content = $content;
        }
        return $this;
    }

    public function json($content, int $code = 200) : ResponseContract
    {
        $this->setHeader('Content-Type', 'application/json');
        $this->setStatusCode($code);
        $this->content = (!$json = json_encode($content, JSON_FORCE_OBJECT, 1024))
            ? $json = json_encode(['error' => json_last_error_msg()])
            : $json;
        return $this;
    }

    public function redirect($path = '/') : ResponseContract
    {
        $this->redirectPath = $path;
        $this->code = Response::REDIRECT;
        $this->isRedirect = true;
        return $this;
    }

    public function back() : ResponseContract
    {
        return $this->redirect(request()->server('HTTP_REFERER'));
    }

    public function with(string $key, $value) : ResponseContract
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function send() :void
    {
        $this->sendHeaders();
        if ($this->isRedirect) {
            header('Location: ' . $this->redirectPath, false, $this->code);
        }
        echo $this->content;
    }

    public function sendHeaders(): void
    {
        http_response_code($this->code);
        foreach ($this->headers as $header => $value) {
            header($header . ': ' . $value);
        }
    }

}