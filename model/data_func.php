<?php 
require_once('database.php');
function get_car_year(){
  global $db;
  $query = 'SELECT DISTINCT year
            FROM CAR
            ORDER BY year DESC';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}

function get_car_make($year){
  global $db;
  $query = 'SELECT DISTINCT make
            FROM CAR
            WHERE year = :year
            ORDER BY make';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}

function get_car_model($year, $make){
  global $db;
  $query = 'SELECT DISTINCT model
            FROM CAR
            WHERE year = :year AND make = :make
            ORDER BY model';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':make', $make);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}

function get_car_engine($year, $make, $model){
  global $db;
  $query = 'SELECT DISTINCT engine
            FROM CAR
            WHERE year = :year AND make = :make AND model = :model
            ORDER BY engine';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $year);
  $statement->bindValue(':make', $make);
  $statement->bindValue(':model', $model);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
?>