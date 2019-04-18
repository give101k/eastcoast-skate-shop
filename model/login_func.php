<?php
  function valid_login($usr, $pass){
    global $db;
    $query = 'SELECT password
              FROM USERS
              WHERE username = :user';
    $statement = $db->prepare($query);
    $statement->bindValue(':user', $usr);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    $hash = $row['password'];
    return password_verify($pass, $hash);
  }

  function usr_type($usr){
    global $db;
    $query = 'SELECT type_usr
              FROM USERS
              WHERE username = :user';
    $statement = $db->prepare($query);
    $statement->bindValue(':user', $usr);
    $statement->execute();
    $row = $statement->fetch();
    $statement->closeCursor();
    return $row['type_usr'];
  }
?>