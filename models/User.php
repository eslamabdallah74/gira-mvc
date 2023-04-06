<?php

namespace gira\models;

use gira\core\Gira;

class User extends Model
{
    public $name = '';
    public $email = '';
    public $password = '';

    public function rules(): array
    {
        return [
            'name'      => [self::REQUIRED],
            'email'     => [
                self::REQUIRED, self::EMAIL,
                [self::UNIQUE, 'class' => self::class, 'attribute' => 'email']
            ],
            'password'  => [self::REQUIRED, [self::MIN, 'min' => 6]],
        ];
    }

    public function primaryKey(): string
    {
        return 'id';
    }

    public function attributes(): array
    {
        return ['name', 'email', 'password'];
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
}
