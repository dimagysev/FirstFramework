<?php


namespace FirstFramework\MVC\View;


interface ViewContract
{
    /**
     * @param  string  $path
     *
     * @return ViewContract
     */
    public function setView(string $path): ViewContract;

    /**
     * @param  string  $path
     *
     * @return ViewContract
     */
    public function setLayout(string $path): ViewContract;

    /**
     * @param  array  $variables
     *
     * @return ViewContract
     */
    public function setVariables(array $variables): ViewContract;

    /**
     * @return string
     */
    public function render(): string;
}