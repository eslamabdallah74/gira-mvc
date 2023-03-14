<?php

namespace gira\controllers;

use gira\core\Gira;

class controller
{    
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
