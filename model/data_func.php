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
      $_SESSION['quantity'][$prod['part']] = $prod['qyt'];
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
      'qt' => $_SESSION['quantity'][$pd_num]
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
  return $row[0];
}
function update_inv($pdnum)
{
  global $db;
  $query = 'UPDATE PRODUCTS
          SET PRODUCTS.num_stock = PRODUCTS.num_stock - :qt
          WHERE PRODUCTS.product_number =:pdnum';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'qt' => $_SESSION['quantity'][$pdnum],
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
    if ($row[0]['num_stock'] < $_SESSION['quantity'][$pd]) {
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
function valid_user($uname)
{
  global $db;
  $query = 'SELECT usrname
            FROM CLIENT
            WHERE usrname = :uname';
  $statement = $db->prepare($query);
  $statement->bindValue(':uname', $uname);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  if ($row == null) {
    return true;
  } else {
    return false;
  }
}
function add_user($username, $fname, $lname, $add, $town, $state)
{
  global $db;
  $query = 'INSERT INTO CLIENT(usrname, First_name, Last_name, address, town, state) 
            VALUES (:username, :fname, :lname, :add, :town, :state)';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'username' => $username,
    'fname' => $fname,
    'lname' => $lname,
    'add' => $add,
    'town' => $town,
    'state' => $state
  ));
  $statement->closeCursor();
}
function add_user_pass($username, $pass)
{
  global $db;
  $query = 'INSERT INTO USERS(username, password, type_usr)  
            VALUES (:username, :pass, :type)';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'username' => $username,
    'pass' => $pass,
    'type' => "client"
  ));
  $statement->closeCursor();
}
function clear_cart()
{
  global $db;
  $query = 'DELETE FROM `CART` WHERE `cname` = :username';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'username' => $_SESSION['username']
  ));
  $statement->closeCursor();
}
function get_all_orders()
{
  global $db;
  $query = 'SELECT *
            FROM ORDERS
            ORDER BY date DESC';
  $statement = $db->prepare($query);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function updatestatus($odnum, $stat)
{
  global $db;
  $query = 'UPDATE ORDERS SET status = :status WHERE order_number = :odnum';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'odnum' => $odnum,
    'status' => $stat
  ));
  $statement->closeCursor();
}
function get_info($uname)
{
  global $db;
  $query = 'SELECT CLIENT.First_name, CLIENT.Last_name, CLIENT.address, CLIENT.town, CLIENT.state
            FROM CLIENT 
            WHERE CLIENT.usrname = :uname';
  $statement = $db->prepare($query);
  $statement->bindValue(':uname', $uname);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row[0];
}
function insert_product(
  $pnum,
  $brand,
  $name,
  $price,
  $stocknum,
  $desc,
  $imgurl,
  $cat
) {
  global $db;
  $query = 'INSERT INTO PRODUCTS(product_number, brand, name, price, num_stock, description, img_url, categories) 
            VALUES (:product_number, :brand, :name, :price, :num_stock, :description, :img_url, :categories)';
  $statement = $db->prepare($query);
  $statement->execute([
    'product_number' => $pnum,
    'brand' => $brand,
    'name' => $name,
    'price' => $price,
    'num_stock' => $stocknum,
    'description' => $desc,
    'img_url' => $imgurl,
    'categories' => $cat
  ]);
  $statement->closeCursor();
}
function product_exist($pnum)
{
  global $db;
  $query = 'SELECT PRODUCTS.product_number
            FROM PRODUCTS 
            WHERE PRODUCTS.product_number = :pnum';
  $statement = $db->prepare($query);
  $statement->bindValue(':pnum', $pnum);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  if ($row == null) {
    return false;
  } else {
    return true;
  }
}
function search_db($qry)
{
  $temp = "%" . $qry;
  $qry = $temp . "%";
  global $db;
  $query = 'SELECT * 
            FROM PRODUCTS 
            WHERE PRODUCTS.name LIKE :qry';
  $statement = $db->prepare($query);
  $statement->bindValue(':qry', $qry);
  $statement->execute();
  $row = $statement->fetchAll();
  $statement->closeCursor();
  return $row;
}
function change_inv($pdnum, $qt)
{
  global $db;
  $query =
    'UPDATE PRODUCTS SET num_stock = :num_stock WHERE product_number = :pdnum';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'pdnum' => $pdnum,
    'num_stock' => $qt
  ));
  $statement->closeCursor();
}
function delete_product($pdnum)
{
  global $db;
  $query = 'DELETE FROM PRODUCTS WHERE product_number =  :pdnum';
  $statement = $db->prepare($query);
  $statement->execute(array(
    'pdnum' => $pdnum
  ));
  $statement->closeCursor();
}
?>