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

    public function applyMigrations()
    {
        $migrationsFile = dirname(__DIR__) . "/migrations/";
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir($migrationsFile);
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {

            if ($migration === '.' || $migration === '..') {
                continue;
            }

            $class_name = pathinfo($migration, PATHINFO_FILENAME);
            $class_path = dirname(__DIR__) . "/migrations/$migration";
            require_once $class_path;

            $instance   = new $class_name();
            $this->log("Applying migration to $migration");
            $instance->up();
            $this->log("migration has been Applied to $migration 😄");

            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->log("All migrations are applied 🙂");
        }
    }


    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }


    public function saveMigrations(array $newMigrations)
    {
        $migrations = implode(",", array_map(fn ($migration) => "('$migration')", $newMigrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUE $migrations");
        $statement->execute();
    }

    protected function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}
