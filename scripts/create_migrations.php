#!/usr/bin/php
<?php
if (count($argv) < 2) {
    die("Usage: create_file.php <filename>\n");
}

$filename = 'm_' . date("Y-m-d_H-i") . "_" . $argv[1];
if (strpos($filename, ".") === false) {
    $filename .= ".php";
}
$class_name = $argv[1];
$class_definition = <<<EOT
<?php

class $class_name
{
  public function up()
  {
    // Add migration logic here
  }

  public function down()
  {
    // Add rollback logic here
  }
}

EOT;
$file = fopen($filename, "w");
fwrite($file, $class_definition);
fclose($file);

echo "File created: " . $filename . "\n";
?>