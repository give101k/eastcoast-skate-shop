<?php
require_once 'database.php';

function get_prod_into($pnum)
{
  global $db;
  $query = 'SELECT PRODUCTS.brand, PRODUCTS.name, PRODUCTS.price, PRODUCTS.product_number, PRODUCTS.img_url
            FROM PRODUCTS
            WHERE PRODUCTS.product_number = :pnum';
  $statement = $db->prepare($query);
  $statement->bindValue(':pnum', $pnum);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row[0];
}

function in_cart($pnum)
{
  for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
    if ($_SESSION['cart'][$i] == $pnum) {
      return true;
    }
  }
  return false;
}
function ordernum_exist($onum)
{
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
  } else {
    return true;
  }
}

function load_cart()
{
  global $db;
  $query = 'SELECT CART.cname, CART.part, CART.qyt
            FROM CART
            WHERE CART.cname = :cname';
  $statement = $db->prepare($query);
  $statement->bindValue(':cname', $_SESSION['username']);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  if (!$row) {
    return 0;
  } else {
    foreach ($row as $prod) {
      array_push($_SESSION['cart'], $prod['part']);
      $_SESSION['quantiy'][$prod['part']] = $prod['qyt'];
    }
  }
}

function update_cart($part)
{
  global $db;
  $qyt = 1;
  $query = 'INSERT INTO CART(cname, part, qyt) VALUES (:cname, :part, :qyt)';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'cname' => $_SESSION['username'],
    'part' => $part,
    'qyt' => $qyt
  ));
  $statement->closeCursor();
}

function remove_item_from_cart($pnum)
{
  global $db;
  $query = 'DELETE FROM CART WHERE CART.cname = :cname AND CART.part = :pnum';
  $statement = $db->prepare($query);
  $statement->execute(array('cname' => $_SESSION['username'], 'pnum' => $pnum));
  $statement->closeCursor();
}

function get_all_prod()
{
  global $db;
  $query = 'SELECT *
            FROM PRODUCTS';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function get_decks()
{
  global $db;
  $query = 'SELECT *
            FROM PRODUCTS
            WHERE PRODUCTS.categories = "deck"';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function get_trucks()
{
  global $db;
  $query = 'SELECT *
            FROM PRODUCTS
            WHERE PRODUCTS.categories = "trucks"';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function get_bearings()
{
  global $db;
  $query = 'SELECT *
            FROM PRODUCTS
            WHERE PRODUCTS.categories = "bearings"';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function get_wheels()
{
  global $db;
  $query = 'SELECT *
            FROM PRODUCTS
            WHERE PRODUCTS.categories = "wheels"';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function get_accs()
{
  global $db;
  $query = 'SELECT *
            FROM PRODUCTS
            WHERE PRODUCTS.categories = "accs"';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function insert_order($od_number, $sub, $tx, $tot)
{
  global $db;
  $timestamp = date('Y-m-d G:i:s');
  $query = 'INSERT INTO ORDERS(order_number, total_price, status, date, cusername, tax, subtotal) 
            VALUES (:odnum, :tot, :status, :date, :cname, :tx, :sub)';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'odnum' => $od_number,
    'tot' => $tot,
    'status' => "ordered",
    'date' => $timestamp,
    'cname' => $_SESSION['username'],
    'tx' => $tx,
    'sub' => $sub
  ));
  $statement->closeCursor();
}
function insert_order_products($od_number)
{
  global $db;
  foreach ($_SESSION['cart'] as $pd_num) {
    $query =
      'INSERT INTO PRODUCTS_PURCHASED(od_num, pd_num, qt) VALUES (:odnum, :pd_num, :qt)';
    $statement = $db->prepare($query);
    $statement->execute(array(
      'odnum' => $od_number,
      'pd_num' => $pd_num,
      'qt' => $_SESSION['quantiy'][$pd_num]
    ));
    $statement->closeCursor();
  }
}
function getname()
{
  global $db;
  $query = 'SELECT CLIENT.First_name, CLIENT.Last_name
            FROM CLIENT
            WHERE CLIENT.usrname = :uname';
  $statement = $db->prepare($query);
  $statement->bindValue(':uname', $_SESSION['username']);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function update_inv($pdnum)
{
  global $db;
  $query = 'UPDATE PRODUCTS
          SET PRODUCTS.num_stock = PRODUCTS.num_stock - :qt
          WHERE PRODUCTS.product_number =:pdnum';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'qt' => $_SESSION['quantiy'][$pdnum],
    'pdnum' => $pdnum
  ));
  $statement->closeCursor();
}
function get_orders()
{
  global $db;
  $query = 'SELECT *
            FROM ORDERS
            WHERE ORDERS.cusername = :uname
            ORDER BY date DESC';
  $statement = $db->prepare($query);
  $statement->bindValue(':uname', $_SESSION['username']);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}

function valid_order()
{
  global $db;
  foreach ($_SESSION['cart'] as $pd) {
    $query = 'SELECT num_stock
              FROM PRODUCTS
              WHERE product_number = :pnum';
    $statement = $db->prepare($query);
    $statement->bindValue(':pnum', $pd);
    $statement->execute();
    $row = $statement->fetchAll();
    $statement->closeCursor();
    if ($row[0]['num_stock'] < $_SESSION['quantiy'][$pd]) {
      return false;
    }
  }
  return true;
}
function get_items($odnum)
{
  global $db;
  $query = 'SELECT PRODUCTS.name, PRODUCTS.price, PRODUCTS_PURCHASED.qt
            FROM PRODUCTS, PRODUCTS_PURCHASED
            WHERE PRODUCTS.product_number = PRODUCTS_PURCHASED.pd_num AND PRODUCTS_PURCHASED.od_num = :odnum';
  $statement = $db->prepare($query);
  $statement->bindValue(':odnum', $odnum);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function get_order($odnum)
{
  global $db;
  $query = 'SELECT *
            FROM ORDERS
            WHERE ORDERS.order_number = :odnum';
  $statement = $db->prepare($query);
  $statement->bindValue(':odnum', $odnum);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
?>
