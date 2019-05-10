<?php
//set the default timezone and starts the session and loades required files
date_default_timezone_set('America/New_York');
session_start();
require_once "model/database.php";
require_once "model/login_func.php";
require_once 'model/data_func.php';

// sets the login messages to null and sets default session values
$login_message = "";
if (!isset($_SESSION['is_valid'])) {
  $_SESSION['is_valid'] = false;
}
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}
if (!isset($_SESSION['cartqt'])) {
  $_SESSION['cartqt'] = 0;
}
if (!isset($_SESSION['quantity'])) {
  $_SESSION['quantity'] = array();
}
if (!isset($_SESSION['user_type'])) {
  $_SESSION['user_type'] = '';
}

// if there is no action it sets the default action
$action = filter_input(INPUT_POST, 'action');
if ($action == null) {
  $action = filter_input(INPUT_GET, 'action');
  if ($action == null) {
    if ($_SESSION['user_type'] == 'admin') {
      $action = 'adminhome';
    } else {
      $action = 'home';
    }
  }
}

switch ($action) {
  // Case for when the user will login admin or client
  // check username and password against the datebase
  // if it is valid login it redirects to the right page for that user
  case 'login':
    $user = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    if (valid_login($user, $password)) {
      $_SESSION['is_valid'] = true;
      $_SESSION['username'] = $user;
      if (usr_type($user) == "admin") {
        $_SESSION['user_type'] = 'admin';
        include 'view/admin.php';
      } elseif (usr_type($user) == "client") {
        load_cart();
        $_SESSION['user_type'] = 'client';
        if (!empty($_SESSION['cart'])) {
          $_SESSION['cartqt'] = array_sum($_SESSION['quantity']);
        } else {
          $_SESSION['cartqt'] = 0;
        }

        include 'view/home.php';
      } else {
        echo "invlaid type";
      }
    } elseif ($password !== null && !valid_login($user, $password)) {
      $login_message =
        "Error: Invlaid credential, you must correctly login to view this site";
      include 'view/login.php';
    } else {
      include 'view/login.php';
    }
    break;

  // case for home button
  case 'home':
    include 'view/home.php';
    break;

  // case for when user logs out
  case 'logout':
    session_unset();
    session_destroy();
    $login_message = 'You have been logged out.';
    include 'view/login.php';
    break;

  // case for product page
  // will diplay products bassed on thier category
  case 'products':
    $cat = filter_input(INPUT_GET, 'cat');
    switch ($cat) {
      case 'all':
        $products = get_all_prod();
        break;
      case 'decks':
        $products = get_decks();
        break;
      case 'trucks':
        $products = get_trucks();
        break;
      case 'bearings':
        $products = get_bearings();
        break;
      case 'wheels':
        $products = get_wheels();
        break;
      case 'acc':
        $products = get_accs();
        break;
    }
    include 'view/products.php';
    break;

  // case for when user click on buy button
  // gets the product number adds it to the cart to keep track
  // if it is already in the cart it will just display the cart but will not add another
  case 'buy':
    $product = filter_input(INPUT_POST, 'product');
    if (in_cart($product) == false) {
      array_push($_SESSION['cart'], $product);
      $_SESSION['quantity'][$product] = 1;
      $_SESSION['cartqt'] = array_sum($_SESSION['quantity']);
      if ($_SESSION['is_valid'] == true) {
        update_cart($product);
      }
    }
    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    include 'view/cart.php';
    break;

  // case for the user update the quantity
  // gets the number update if 0 removes it from the cart other wise updates the quantity
  case 'cartupdate':
    $qt = filter_input(INPUT_POST, 'updateqt');
    $ptnum = filter_input(INPUT_POST, 'pnum');
    if ($qt == 0 && in_array($ptnum, $_SESSION['cart']) == true) {
      $key = array_search($ptnum, $_SESSION['cart']);
      array_splice($_SESSION['cart'], $key, $key + 1);
      unset($_SESSION['quantity'][$ptnum]);
      if ($_SESSION['is_valid'] == true) {
        remove_item_from_cart($ptnum);
      }
    }
    $_SESSION['quantity'][$ptnum] = $qt;
    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    $_SESSION['cartqt'] = array_sum($_SESSION['quantity']);
    include 'view/cart.php';
    break;

  // case for when user checksout
  // it will make user login if they are not already
  // it then will proccess the order and put it in the database
  case 'checkout':
    if ($_SESSION['is_valid'] == false) {
      include 'view/login.php';
    } elseif (valid_order() == true) {
      do {
        $odnum = uniqid();
      } while (ordernum_exist($odnum) == true);
      $subtotal = 0;
      for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
        $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
      }
      foreach ($prod as $p) {
        $subtotal += $p['price'] * $_SESSION['quantity'][$p['product_number']];
      }
      $tax = $subtotal * 0.06;
      $total = $subtotal + $tax;
      insert_order($odnum, $subtotal, $tax, $total);
      insert_order_products($odnum);
      clear_cart();
      foreach ($_SESSION['cart'] as $p) {
        update_inv($p);
      }
      $_SESSION['cart'] = array();
      $_SESSION['cartqt'] = 0;
      $_SESSION['quantity'] = array();
      $name = getname();
      include 'view/purchaced.php';
    } elseif (valid_order() == false) {
      include 'view/toomany.php';
    }
    break;

  // case for when the user click on thier cart
  case 'cart':
    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    include 'view/cart.php';
    break;
  // case for when the user click on thier account
  case 'account':
    if ($_SESSION['is_valid'] == false) {
      include 'view/login.php';
    } else {
      $orders = get_orders();
      include 'view/account.php';
    }
    break;

  // case for when they click on the dtails of thier order
  case 'details':
    $odnum = filter_input(INPUT_POST, 'odnum');
    $order = get_order($odnum);
    $items = get_items($odnum);
    include 'view/details.php';
    break;

  // case for when the new user click on regester
  case 'reg':
    $message = null;
    include 'view/register.php';
    break;

  // case for when the user submits thier form for regestering
  case 'submit':
    $fname = filter_input(INPUT_POST, 'fname');
    $lname = filter_input(INPUT_POST, 'lname');
    $username = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'pass');
    $confirmpass = filter_input(INPUT_POST, 'confirmpass');
    $add = filter_input(INPUT_POST, 'add');
    $town = filter_input(INPUT_POST, 'town');
    $state = filter_input(INPUT_POST, 'state');
    if ($pass != $confirmpass) {
      $message = "Passwords do not match";
      include 'view/register.php';
    }
    if (valid_user($username) == false) {
      $message = "Please pick a different Username. That one has been taken.";
      include 'view/register.php';
    }
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    add_user($username, $fname, $lname, $add, $town, $state);
    add_user_pass($username, $hash);
    include 'view/login.php';
    break;

  // case for the admin home page
  case 'adminhome':
    include 'view/admin.php';
    break;

  // case of the admin orders page
  // gets all orders from database and displays them
  case 'adminorders':
    $orders = get_all_orders();
    include 'view/admin_orders.php';
    break;

  // case for when admin click on details button
  // gets order details to dispaly to user
  case 'admindetails':
    $odnum = filter_input(INPUT_POST, 'odnum');
    $order = get_order($odnum);
    $info = get_info($order[0]['cusername']);
    $items = get_items($odnum);
    include 'view/admin_details.php';
    break;

  // case for when the admin updates the status of the order
  case 'updatestatus':
    $status = filter_input(INPUT_POST, 'status');
    $odnum = filter_input(INPUT_POST, 'odnum');
    updatestatus($odnum, $status);
    $order = get_order($odnum);
    $items = get_items($odnum);
    include 'view/admin_details.php';
    break;

  // case for when employee wants to add product
  case 'addproduct':
    $pnum = filter_input(INPUT_POST, 'pnum');
    $brand = filter_input(INPUT_POST, 'brand');
    $name = filter_input(INPUT_POST, 'name');
    $price = filter_input(INPUT_POST, 'price');
    $stocknum = filter_input(INPUT_POST, 'stocknum');
    $desc = filter_input(INPUT_POST, 'desc');
    $imgurl = filter_input(INPUT_POST, 'imgurl');
    $cat = filter_input(INPUT_POST, 'cat');

    if (product_exist($pnum) == false) {
      $add_message = 'Product Added';
      insert_product(
        $pnum,
        $brand,
        $name,
        $price,
        $stocknum,
        $desc,
        $imgurl,
        $cat
      );
    } else {
      $add_message = 'Product Number already exist';
    }

    include 'view/addproducts.php';
    break;

  case 'addproductpage':
    include 'view/addproducts.php';
    break;
}
?>