<?php

use gira\core\Gira;

class m00001_posts
{
  public function up()
  {
    $db  = Gira::$app->database;
    $SQL = "CREATE TABLE posts (
      id INT AUTO_INCREMENT PRIMARY KEY,
      body VARCHAR(255) NOT NULL,
      slug varchar(255),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=INNODB;";
    $db->pdo->exec($SQL);
  }

  public function down()
  {
    $db  = Gira::$app->database;
    $SQL = "DROP TABLE posts;";
    $db->pdo->exec($SQL);
  }
}
