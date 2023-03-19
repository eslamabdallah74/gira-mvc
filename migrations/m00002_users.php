<?php

use gira\core\Gira;

class m00002_users
{
  public function up()
  {
    $db  = Gira::$app->database;
    $SQL = "CREATE TABLE users (
      id INT AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      email VARCHAR(255) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=INNODB;";
    $db->pdo->exec($SQL);
  }

  public function down()
  {
    $db  = Gira::$app->database;
    $SQL = "DROP TABLE users;";
    $db->pdo->exec($SQL);  
  }
}
