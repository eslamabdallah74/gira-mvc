<?php

namespace gira\controllers;

use gira\core\Gira;

class Controller
{

    public $layout = 'main';
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    /**
     * render
     * @param  mixed $view
     * @param  mixed $params
     * @return void
     */
    public function render(string $fileName, $params = [])
    {
        return Gira::$app->router->render($fileName, $params);
    }
}
