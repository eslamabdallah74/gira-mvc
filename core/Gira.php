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
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->router  = new Router($this->request);

    } 

    public function run()
    {
        $this->router->resolve();
    }
}