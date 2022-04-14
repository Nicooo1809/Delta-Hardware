<?php
require_once "config.php";

try {
  $pdo = new PDO('mysql:host=' . $ini_array["mysql"]["host"] . ';dbname=' . $ini_array["mysql"]["database"] . ';charset=utf8', $ini_array["mysql"]["user"], $ini_array["mysql"]["passwd"]);
  //Connected successfully
} catch(PDOException $e) {
  // If there is an error with the connection, stop the script and display the error.  
  error_log($backtrace[count($backtrace)-1]['file'] . ':' . $backtrace[count($backtrace)-1]['line'] . ': Database connection failed: ' . $e->getMessage());
  print('Database connection failed');
  exit;
  #error_log($e->getMessage());
}
?>
