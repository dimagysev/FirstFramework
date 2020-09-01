<?php


namespace FirstFramework\Http\Response;



interface ResponseContract
{
    /**
     * ResponseContract constructor.
     *
     * @param  null  $content
     * @param  int  $code
     * @param  array  $headers
     */
    public function __construct($content = null, int $code = 200, array $headers = []);

    /**
     * @param  int  $code
     *
     * @return ResponseContract
     */
    public function setStatusCode(int $code) : ResponseContract;

    /**
     * @param  string  $header
     * @param  string  $value
     *
     * @return ResponseContract
     */
    public function setHeader(string $header, string $value) : ResponseContract;

    /**
     * @param  array  $headers [key => value]
     *
     * @return ResponseContract
     */
    public function setHeaders(array $headers) : ResponseContract;

    /**
     * @param $content
     *
     * @return ResponseContract
     */
    public function content($content) : ResponseContract;

    /**
     * @param $content
     * @param  int  $code
     *
     * @return ResponseContract
     */
    public function json( $content, int $code = 200) : ResponseContract;

    /**
     * @param  string  $path
     *
     * @return ResponseContract
     */
    public function redirect(string $path) : ResponseContract;

    /**
     * @return ResponseContract
     */
    public function back() : ResponseContract;

    /**
     * @param  string  $key
     * @param $value
     *
     * @return ResponseContract
     */
    public function with(string $key, $value) : ResponseContract;

    public function send() :void;

    public function sendHeaders(): void;
}