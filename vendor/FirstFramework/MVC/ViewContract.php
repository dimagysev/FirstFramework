<?php


namespace FirstFramework\MVC;


interface ViewContract
{
    /**
     * @param  string  $path ['folder.filename']
     *
     * @return ViewContract
     */
    public function setView(string $path): ViewContract;

    /**
     * @param  string  $path ['folder.filename']
     *
     * @return ViewContract
     */
    public function setLayout(string $path): ViewContract;

    /**
     * @param  array  $variables [$name => $value]
     *
     * @return ViewContract
     */
    public function setVariables(array $variables): ViewContract;

    /**
     * @return string
     */
    public function render() : string;
}