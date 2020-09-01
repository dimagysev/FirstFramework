<?php


namespace FirstFramework\Http\Request;

interface RequestContract
{

    /**
     * @return string
     */
    public function method() : string;

    /**
     * @return array
     */
    public function getHeaders() : array;

    /**
     * @param string $key
     * @return string|null
     */
    public function getHeader(string $key): ?string;

    /**
     * @param string $key
     * @return bool
     */
    public function hasHeader(string $key) :bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function coockie(string $key);

    /**
     * @param string $key
     * @return bool
     */
    public function hasCoockie(string $key):bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function getServerParam(string $key);

    /**
     * @return array
     */
    public function getAllServerParams() :array;

    /**
     * @return array
     */
    public function getAllCookies() : array;

    /**
     * @param string $key
     * @param string|int $value
     */
    public function setServerParam(string $key, $value):void;

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getBodyParam(string $key, $default = null);

    /**
     * @return array
     */
    public function getBodyParams() : array;

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getQueryParam(string $key, $default = null);

    /**
     * @return array
     */
    public function getQueryParams() : array;

    /**
     * @return string
     */
    public function path() : string;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool;

    /**
     * @return bool
     */
    public function ajax() : bool;
}