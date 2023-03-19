#!/usr/bin/php
<?php
if (count($argv) < 2) {
  die("Usage: create_file.php <filename>\n");
}

// set the migrations directory path
$migrations_dir = __DIR__ . '/../migrations/';

// get the list of files in the directory
$files = scandir($migrations_dir);
// sort the files by name
sort($files);

// check if there are any files in the directory
if (count($files) === 2) { // the only two files in the directory are '.' and '..'
  $file_number = 1;
  $class_name = 'm00001_' . $argv[1];
  $filename = $migrations_dir . $class_name . '.php';
} else {
  // get the last filename in the sorted list
  $last_file = end($files);
  // extract the file number from the filename
  $file_number = (int) preg_replace('/[^0-9]/', '', $last_file);
  // generate the new file number
  $new_file_number = $file_number + 1;
  $class_name = 'm' . sprintf('%05d', $new_file_number) . '_' . $argv[1];
  $filename = $migrations_dir . $class_name . '.php';
}

$class_definition = <<<EOT
<?php

namespace gira\migrations;

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