<?php


namespace FirstFramework\MVC;

use FirstFramework\MVC\View;

abstract class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function view($viewPath = '', $variables = [], string $layoutPath = LAYOUT)
    {
        return $this->view->setView($viewPath)
            ->setLayout($layoutPath)
            ->setVariables($variables)
            ->render();
    }

}