<?php

namespace gira\controllers;

use gira\core\Gira;
use gira\core\Request;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->setLayout('auth');
    }

    public function registerForm()
    {
        return $this->render('register');
    }

    public function register(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
    }
}
