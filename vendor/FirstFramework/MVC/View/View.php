<?php


namespace FirstFramework\MVC\View;


class View implements ViewContract
{
    private $view;
    private $layout;
    private $variables = [];

    public function setView(string $path): ViewContract
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        $this->view = APP . 'Views' . DIRECTORY_SEPARATOR . $path . '.php';
        return $this;
    }

    public function setLayout(string $path): ViewContract
    {
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        $this->layout = APP . 'Layouts' . DIRECTORY_SEPARATOR . $path . '.php';
        return $this;
    }

    public function setVariables(array $variables): ViewContract
    {
        $this->variables = $variables;
        return $this;
    }

    public function render(): string
    {
        extract($this->variables);

        if (!file_exists($this->layout)){
            http_response_code(404);
            throw new \Exception('Page not found');
        }
        if (!file_exists($this->view)){
            http_response_code(404);
            throw new \Exception('Page not found');
        }

        ob_start();
        require_once $this->view;
        $content = ob_get_clean();

        ob_start();
        require_once $this->layout;
        return ob_get_clean();
    }
}