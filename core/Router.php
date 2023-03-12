<?php

namespace gira\core;

use VARIANT;

class Router
{

    public Request $request;
    protected array $routes = [];

    public function __construct(Request $request)
    {
        $this->request = new Request();
    }

    /**
     * get
     *
     * @param  mixed $path
     * @param  mixed $callback
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path     = $this->request->getPath();
        $method   = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            return 'not found';
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        return call_user_func($callback);
    }


    public function renderView($viewName)
    {
        $layouts            = $this->layoutContent();
        $viewContent        = $this->renderOnlyView($viewName);
        return str_replace('{{ content }}', $viewContent, $layouts);
    }

    protected function renderOnlyView($viewName)
    {
        ob_start();
        include_once __DIR__ . "/../views/{$viewName}.php";
        return ob_get_clean();
    }

    protected function layoutContent()
    {
        ob_start();
        include_once __DIR__ . "/../views/layouts/main.php";
        return ob_get_clean();
    }

    protected function createView($filePath, $viewName)
    {
        $file = fopen($filePath, 'w');
        fwrite($file, '<h1>New ' . $viewName . ' File</h1>');
        fclose($file);
    }
}
