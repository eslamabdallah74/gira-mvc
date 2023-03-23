<?php

namespace gira\controllers;

use gira\core\Gira;
use gira\core\Request;
use gira\core\Response;
use gira\models\User;

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

    public function login(Request $request,Response $response)
    {
        $body = $request->getBody();
        $user = new User();
        $user->loadData($body);
        if($user->validate() && $user->login())
        {
            Gira::$app->session->setFlash('success','You have logged in successfully.');
            $response->redirect('/');
            
        }
    }
}
