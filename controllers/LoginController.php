<?php

namespace gira\controllers;

use gira\core\Gira;
use gira\core\Request;

class loginController extends Controller
{
    public function __construct()
    {
        $this->setLayout('auth');
    }
    
    public function loginForm()
    {
        return $this->render('login');
    }

    public function login(Request $request)
    {
        $body = $request->getBody();
    }
}
