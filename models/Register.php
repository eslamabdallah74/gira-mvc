<?php

namespace gira\models;

class Register extends Model
{
    public $name = '';
    public $email = '';
    public $password = '';

    public function rules(): array
    {
        return [
            'name'      => [self::REQUIRED],
            'email'     => [self::REQUIRED, self::EMAIL],
            'password'  => [self::REQUIRED, [self::MIN,'min' => 6]],
        ];
    }

    public function Register()
    {
    }
}
