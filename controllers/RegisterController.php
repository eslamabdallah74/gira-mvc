<?php

namespace gira\controllers;

use gira\core\Gira;
use gira\core\Request;
use gira\models\Register;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->setLayout('auth');
    }

    public function registerForm()
    {
        $RegisterModel = new Register();
        return $this->render('register', ['model' => $RegisterModel]);
    }

    public function register(Request $request)
    {
        $RegisterModel = new Register();
        $data          = $request->getBody();
        $RegisterModel->loadData($data);
        if ($RegisterModel->validate() && $RegisterModel->Register()) {
            return 'Data has been submitted';
        }
        return $this->render('register', ['model' => $RegisterModel]);
    }
}
