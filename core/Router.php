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
        if($callback === false)
        {
            echo 'not found';
            exit;
        }
        echo call_user_func($callback);
    }
}
