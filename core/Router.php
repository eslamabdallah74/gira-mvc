<?php

namespace gira\core;

use VARIANT;

class Router
{

    public Request $request;
    public Response $response;

    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request  = new Request();
        $this->response = new Response();
    }

    /**
     * get
     * @param  mixed $path
     * @param  mixed $callback
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


    /**
     * resolve
     * @return void // callback function => rendering view
     */
    public function resolve()
    {
        $path     = $this->request->getPath();
        $method   = $this->request->getMethod();
        return $this->getCallbackAndRender($path, $method);
    }

    /**
     * getCallbackAndRender
     * @param  mixed $path
     * @param  mixed $method
     * @return void
     */
    protected function getCallbackAndRender($path, $method)
    {
        $callback = $this->routes[$method][$path] ?? false;
        if (!is_array($callback)) {
            return $this->render($callback);
        }
        $getControllerAndMethod = $this->checkControllerAndMethod($callback);
        return call_user_func(
            [$getControllerAndMethod['controller'], $getControllerAndMethod['method']],
            $this->request
        );
    }

    protected function checkControllerAndMethod($callback)
    {
        if (!class_exists($callback[0])) {
            echo "Controller not found: "."<b>". $callback[0] ."<b/>";
            return;
        }
        $controller = new $callback[0]();
        $method     = $callback[1];
        if (!method_exists($controller, $method)) {
            echo "Method not found: " . "<b>{$method}</b>";
            return;
        }
        return [
            'controller' => $controller,
            'method' => $method
        ];
    }
    /**
     * renderView
     * @param mixed $viewName
     */
    protected function render($viewName)
    {
        if ($viewName === false) {
            return  $this->render404();
        }
        if (is_string($viewName)) {
            $layouts            = $this->renderLayout();
            $viewContent        = $this->renderOnlyView($viewName);
            return  str_replace('{{ content }}', $viewContent, $layouts);
        }
    }

    /**
     * render404
     * @return void
     */
    protected function render404()
    {
        $statusCode = $this->response->setStatusCode(404);
        $file = __DIR__ . "/../views/404.php";
        if (!file_exists($file)) {
            $this->createView($file, '404');
        }
        ob_start();
        include $file;
        return ob_get_clean();
    }


    /**
     * renderOnlyView
     * @param  mixed $viewName
     * @return void
     */
    protected function renderOnlyView($viewName)
    {
        $file = __DIR__ . "/../views/{$viewName}.php";
        if (!file_exists($file)) {
            $this->createView($file, $viewName);
        }
        ob_start();
        include_once $file;
        return ob_get_clean();
    }

    /**
     * layoutContent
     * @return void
     */
    protected function renderLayout()
    {
        $file = __DIR__ . "/../views/layouts/main.php";
        if (!file_exists($file)) {
            $this->createView($file, 'main');
        }
        ob_start();
        include_once $file;
        return ob_get_clean();
    }

    /**
     * createView
     * @param  mixed $filePath
     * @param  mixed $viewName
     * @return void
     */
    protected function createView($filePath, $viewName)
    {
        $file = fopen($filePath, 'w');
        fwrite($file, '<h1>New ' . $viewName . ' File</h1>');
        fclose($file);
    }
}
