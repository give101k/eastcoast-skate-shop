<?php
date_default_timezone_set('America/New_York');
session_start();
require_once "model/database.php";
require_once "model/login_func.php";
require_once 'model/data_func.php';

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
if (!isset($_SESSION['quantiy'])) {
  $_SESSION['quantiy'] = array();
}

$action = filter_input(INPUT_POST, 'action');
if ($action == null) {
  $action = filter_input(INPUT_GET, 'action');
  if ($action == null) {
    $action = 'home';
  }
}

switch ($action) {
  case 'login':
    $user = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password');
    if (valid_login($user, $password)) {
      $_SESSION['is_valid'] = true;
      $_SESSION['username'] = $user;
      if (usr_type($user) == "admin") {
        include 'admin.php';
      } elseif (usr_type($user) == "client") {
        load_cart();
        if (!empty($_SESSION['cart'])) {
          $_SESSION['cartqt'] = array_sum($_SESSION['quantiy']);
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

  case 'home':
    include 'view/home.php';
    break;

  case 'logout':
    session_unset();
    session_destroy();
    $login_message = 'You have been logged out.';
    include 'view/login.php';
    break;

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

  case 'buy':
    $product = filter_input(INPUT_POST, 'product');
    if (in_cart($product) == false) {
      array_push($_SESSION['cart'], $product);
      $_SESSION['quantiy'][$product] = 1;
      $_SESSION['cartqt'] = array_sum($_SESSION['quantiy']);
      if ($_SESSION['is_valid'] == true) {
        update_cart($product);
      }
    }
    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    include 'view/cart.php';
    break;

  case 'cartupdate':
    $qt = filter_input(INPUT_POST, 'updateqt');
    $ptnum = filter_input(INPUT_POST, 'pnum');
    if ($qt == 0 && in_array($ptnum, $_SESSION['cart']) == true) {
      $key = array_search($ptnum, $_SESSION['cart']);
      array_splice($_SESSION['cart'], $key, $key + 1);
      unset($_SESSION['quantiy'][$ptnum]);
      if ($_SESSION['is_valid'] == true) {
        remove_item_from_cart($ptnum);
      }
    }
    $_SESSION['quantiy'][$ptnum] = $qt;
    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    $_SESSION['cartqt'] = array_sum($_SESSION['quantiy']);
    include 'view/cart.php';
    break;

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
        $subtotal += $p['price'] * $_SESSION['quantiy'][$p['product_number']];
      }
      $tax = $subtotal * 0.06;
      $total = $subtotal + $tax;
      insert_order($odnum, $subtotal, $tax, $total);
      insert_order_products($odnum);
      foreach ($_SESSION['cart'] as $p) {
        update_inv($p);
      }
      $_SESSION['cart'] = array();
      $_SESSION['cartqt'] = 0;
      $_SESSION['quantiy'] = array();
      $name = getname();
      include 'view/purchaced.php';
    } elseif (valid_order() == false) {
      include 'view/toomany.php';
    }
    break;

  case 'cart':
    for ($i = 0; $i < sizeof($_SESSION['cart']); $i++) {
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    include 'view/cart.php';
    break;
  case 'account':
    if ($_SESSION['is_valid'] == false) {
      include 'view/login.php';
    } else {
      $orders = get_orders();
      include 'view/account.php';
    }
    break;
  case 'details':
    $odnum = filter_input(INPUT_POST, 'odnum');
    $order = get_order($odnum);
    $items = get_items($odnum);
    include 'view/details.php';
    break;

  case 'reg':
    include 'view/register.php';
    break;
}
?>
