<?php


namespace FirstFramework\MVC\Controller;

use FirstFramework\MVC\View\View;

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