<?php

namespace gira\core;


/**
 * Base core class for Gira
 * Author: Eslam Abdallah
 */
class Gira
{
    public Request $request;
    public Router $router;
    public Response $response;
    public static Gira $app;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        self::$app        = $this;
        $this->request    = new Request();
        $this->response   = new Response();
        $this->router     = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
