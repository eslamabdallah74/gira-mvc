<?php

namespace gira\models;

class User extends Model
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

    public function attributes(): array
    {
        return ['name','email','password'];
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function Register()
    {
        return $this->save();
    }
}
