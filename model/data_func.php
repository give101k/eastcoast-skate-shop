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

function get_car_id($car){
  global $db;
  $query = 'SELECT DISTINCT car_id
            FROM CAR
            WHERE year = :year AND make =:make AND model = :model AND engine = :engine';
  $statement = $db->prepare($query);
  $statement->bindValue(':year', $car['year']);
  $statement->bindValue(':make', $car['make']);
  $statement->bindValue(':model', $car['model']);
  $statement->bindValue(':engine', $car['engine']);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}

function get_part_cat($crid){
  global $db;
  $query = 'SELECT DISTINCT HAS_PARTS.category
            FROM HAS_PARTS
            WHERE HAS_PARTS.cr_id = :carid';
  $statement = $db->prepare($query);
  $statement->bindValue(':carid', $crid);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}

function get_products($cat, $id){
  global $db;
  $query ='SELECT DISTINCT PART.part_number, PART.brand, PART.name, PART.price, PART.description, PART.img_url, HAS_PARTS.category
            FROM HAS_PARTS, PART
            WHERE HAS_PARTS.cr_id = :carid AND HAS_PARTS.pt_num = PART.part_number AND HAS_PARTS.category = :cat';
  $statement = $db->prepare($query);
  $statement->bindValue(':carid', $id);
  $statement->bindValue(':cat', $cat);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}

function get_prod_into($pnum){
  global $db;
  $query = 'SELECT PART.brand, PART.name, PART.price, PART.part_number, PART.img_url
            FROM PART
            WHERE PART.part_number = :pnum';
  $statement = $db->prepare($query);
  $statement->bindValue(':pnum', $pnum);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row[0];
}

function in_cart($pnum){
  for ($i=0; $i < sizeof($_SESSION['cart']) ; $i++) { 
    if($_SESSION['cart'][$i] == $pnum){
      return true;
    }
  }
  return false;
}
function ordernum_exist($onum){
  global $db;
  $query = 'SELECT ORDERS.order_number
            FROM ORDERS
            WHERE ORDERS.order_number = :onum';
  $statement = $db->prepare($query);
  $statement->bindValue(':onum', $onum);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  if (!$row) {
    return false;
  } else{
    return true;
  }
}

function load_cart(){
  global $db;
  $query = 'SELECT CART.cname, CART.part, CART.qyt
            FROM CART
            WHERE CART.cname = :cname';
  $statement = $db->prepare($query);
  $statement->bindValue(':cname', $_SESSION['username']);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  if(!$row){
    return 0;
  }else{
    foreach ($row as $prod) {
      array_push($_SESSION['cart'], $prod['part']);
      $_SESSION['quantiy'][$prod['part']] = $prod['qyt'];
    }
  }
}

function update_cart($part){
  global $db;
  $qyt = 1;
  $query = 'INSERT INTO CART(cname, part, qyt) VALUES (:cname, :part, :qyt)';
  $statement = $db->prepare($query);
  $statement->execute(array('cname' => $_SESSION['username'], 'part' => $part, 'qyt' => $qyt));
  $statement->closeCursor();
}

function remove_item_from_cart($pnum){
  global $db;
  $query = 'DELETE FROM CART WHERE CART.cname = :cname AND CART.part = :pnum';
  $statement = $db->prepare($query);
  $statement->execute(array('cname' => $_SESSION['username'], 'pnum' => $pnum));
  $statement->closeCursor();
}
?>