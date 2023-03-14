<?php

namespace gira\controllers;

use gira\core\Gira;

class HomeController extends Controller
{
    public function index()
    {
        $name = 'eslam';
        return $this->render('Home', ['name' => $name]);
    }
}
