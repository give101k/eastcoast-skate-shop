<?php 
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
  
}
?>