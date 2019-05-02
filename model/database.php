<?php
    $dsn = 'mysql:host=localhost;dbname=AutoDirect';
    $username = 'admin';
    $password = 'pass';

    try {
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('database_error.php');
        exit();
    }
?>