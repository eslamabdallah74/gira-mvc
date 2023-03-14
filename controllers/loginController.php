<?php 

namespace gira\controllers;

use gira\core\Gira;
use gira\core\Request;

class loginController extends controller
{
    public function index()
    {
        return $this->render('users');
    }


    public function login(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
    }
}