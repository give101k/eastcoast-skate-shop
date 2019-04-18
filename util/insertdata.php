<?php 
require_once('../model/database.php');
$file = fopen("data.csv","r");
$query = 'INSERT INTO CAR
            (car_id, year, make, model, engine)
          VALUES
            (:id, :yr, :mk, :md, :eg';
while(! feof($file)){
  $dt = fgetcsv($file);
  var_dump($dt);
  $id = $dt[0];
  $yr = intval($dt[1]);
  $mk = $dt[2];
  $md = $dt[3];
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $id);
  $statement->bindValue(':yr', $yr);
  $statement->bindValue(':mk', $mk);
  $statement->bindValue(':md', $md);
  $statement->bindValue(':eg', $md);
  $statement->execute();
  $statement->closeCursor();
}

?>