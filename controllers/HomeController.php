<?php

namespace gira\controllers;

use gira\core\Gira;

class HomeController extends controller
{
    public function index()
    {
        $name = 'eslam';
        return $this->render('Home', ['name' => $name]);
    }
}
