<?php

namespace gira\core;

use Exception;
use PDO;
use PDOException;

class Database
{
    public PDO $pdo;

    public function __construct(array $config)
    {
        $DSN = $config['dsn'] ?? '';
        $userName = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        try {
            $this->pdo = new PDO($DSN, $userName, $password, $options = null);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $error) {
            throw $error;
        }
    }
}
