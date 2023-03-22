<?php

namespace gira\controllers;

use gira\core\Gira;
use gira\core\Request;
use gira\models\User;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->setLayout('auth');
    }

    public function registerForm()
    {
        $user = new User();
        return $this->render('register', ['model' => $user]);
    }

    public function register(Request $request)
    {
        $user          = new User();
        $data          = $request->getBody();
        $user->loadData($data);
        if ($user->validate() && $user->save()) {
            Gira::$app->session->setFlash('success','Thanks for register');
            Gira::$app->response->redirect('/');
        }
        return $this->render('register', ['model' => $user]);
    }
}
