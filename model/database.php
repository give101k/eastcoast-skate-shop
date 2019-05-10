<?php
$dsn = 'mysql:host=localhost;dbname=EastCoastSkate';
$username = 'admin';
$password = 'pass';

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  $error_message = $e->getMessage();
  include 'database_error.php';
  exit();
}
?>