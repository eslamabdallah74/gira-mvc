<?php

namespace gira\core;

use gira\models\Model;

abstract class DbModel
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName          = $this->tableName();
        $attributes         = $this->attributes();
        $injectAttributes   = implode(',', $attributes);
        $params             = array_map(fn ($attr) => ":$attr", $attributes);
        $injectParams       = implode(',', $params);

        $sqlStatement       = self::prepare("INSERT INTO $tableName 
        (" . $injectAttributes . ") VALUES(" . $injectParams . ")");

        foreach ($attributes as $attribute) {
            $sqlStatement->bindValue(":$attribute", $this->{$attribute});
        }

        $sqlStatement->execute();
        return true;
    }

    public static function prepare(string $sqlStatement)
    {
        return Gira::$app->database->pdo->prepare($sqlStatement);
    }


    public static function findOne($where)
    {
        $tableName  = static::tableName();
        $attributes = array_keys($where);
        $sql        = implode('AND ', array_map(fn ($attr) => "$attr = :$attr", $attributes));
        $statement  = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }
}
