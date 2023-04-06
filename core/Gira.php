<?php

namespace gira\core;

use gira\controllers\Controller;

/**
 * Base core class for Gira
 * Author: Eslam Abdallah
 */
class Gira
{
    public static Gira $app;

    public Database $database;
    public Request $request;
    public Router $router;
    public Response $response;
    public Session $session;
    public Controller $controller;
    public ?DbModel $user;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(array $config)
    {
        self::$app        = $this;
        $this->request    = new Request();
        $this->response   = new Response();
        $this->session    = new Session();
        $this->router     = new Router($this->request, $this->response);
        $this->database   = new Database($config['db']);
    }

    public function setController(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public function login(DbModel $user)
    {
        $this->user = $user;
    }
}
