<?php
$dsn = 'mysql:host=localhost;dbname=EastCoastSkateShopDataBase';
$username = 'EastCoastSkateShopDataBase';
$password = 'EastCoastSkateShoppass';

try {
  $db = new PDO($dsn, $username, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
  $error_message = $e->getMessage();
  include 'database_error.php';
  exit();
}
?>