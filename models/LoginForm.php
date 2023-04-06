<?php

namespace gira\models;

use gira\core\Gira;

class LoginForm extends User
{
    public $email = '';
    public $password = '';

    public function rules(): array
    {
        return [
            'email'     => [
                self::REQUIRED, self::EMAIL,
            ],
            'password'  => [self::REQUIRED, [self::MIN, 'min' => 6]],
        ];
    }


    public function attributes(): array
    {
        return ['email', 'password'];
    }


    public function login()
    {
        $user = LoginForm::findOne(['email'=>$this->email]);
        if(!$user)
        {
            $this->addError('email','Email not found');
            return false;
        }
        if(!password_verify($this->password,$user->password)) {
            $this->addError('password','Password is wrong');
            return false;
        }
        // Gira::$app->login();
    }

}
