<?php

namespace gira\core;

use VARIANT;

class Router
{

    public Request $request;
    public Response $response;

    protected $layouts;
    protected $pageNotFoundPath;
    protected array $routes = [];


    public function __construct(Request $request, Response $response)
    {
        $this->request              = new Request();
        $this->response             = new Response();
        $this->pageNotFoundPath     = __DIR__ . "/../views/" . Constant::NotFoundPageName . ".php";
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
        $callback = $this->getCallback($path, $method);

        if ($callback) {
            $this->render($callback);
            return call_user_func(
                [
                    $this->getControllerAndMethod($callback)['controller'],
                    $this->getControllerAndMethod($callback)['method']
                ],
                $this->request
            );
        }
        if ($callback === false) {
            $layouts            = $this->renderLayout();
            $notFoundPage       = $this->render404();
            return  str_replace('{{ content }}', $notFoundPage, $layouts);
        }
    }

    protected function getCallback($path, $method)
    {
        $callback = $this->routes[$method][$path] ?? false;
        return $callback;
    }

    protected function checkControllerAndMethod($callback)
    {
        if (!class_exists($callback[0])) {
            echo "Controller not found: " . "<b>" . $callback[0] . "<b/>";
            return;
        }
        Gira::$app->controller = new $callback[0]();
        $method     = $callback[1];
        if (!method_exists(Gira::$app->controller, $method)) {
            echo "Method not found: " . "<b>{$method}</b>";
            return;
        }
        return $callback;
    }

    public function getControllerAndMethod($callback)
    {
        $callback = $this->checkControllerAndMethod($callback);
        return [
            'controller' => new $callback[0],
            'method'     => $callback[1]
        ];
    }
    /**
     * renderView
     * @param mixed $viewName
     */
    public function render($viewName, $params = [])
    {
        if (is_string($viewName)) {
            $layouts            = $this->renderLayout();
            $viewContent        = $this->renderOnlyView($viewName, $params);
            return  str_replace('{{ content }}', $viewContent, $layouts);
        }
    }

    /**
     * render404
     */
    protected function render404()
    {
        $statusCode = $this->response->setStatusCode(404);
        if (!file_exists($this->pageNotFoundPath)) {
            $this->createView($this->pageNotFoundPath, Constant::NotFoundPageName);
        }
        ob_start();
        include $this->pageNotFoundPath;
        return ob_get_clean();
    }


    /**
     * renderOnlyView
     * @param  mixed $viewName
     */
    protected function renderOnlyView($viewName, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
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
     */
    protected function renderLayout()
    {
        $layout = Gira::$app->controller->layout;
        $file = __DIR__ . "/../views/layouts/$layout.php";
        if (!file_exists($file)) {
            $this->createView($file, $layout);
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
