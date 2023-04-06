<?php

namespace gira\controllers;

use gira\core\Gira;
use gira\core\Request;
use gira\core\Response;
use gira\models\LoginForm;
use gira\models\User;

class loginController extends Controller
{
    public function __construct()
    {
        $this->setLayout('auth');
    }

    public function loginForm()
    {
        $model = new LoginForm();
        return $this->render('login', ['model' => $model]);
    }

    public function login(Request $request, Response $response)
    {
        $body = $request->getBody();
        $user = new LoginForm();
        $user->loadData($body);
        if ($user->validate() && $user->login()) {
            $response->redirectWithMessage('/', 'success', 'logged in');
        }
        return $this->render('login', ['model' => $user]);

    }
}
