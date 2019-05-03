<?php
session_start();
require_once("model/database.php");
require_once("model/login_func.php");
require_once('model/data_func.php');

$login_message="";


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
  $action = filter_input(INPUT_GET, 'action');
  if ($action == NULL) {
      $action = 'home';
  }
}

if (!isset($_SESSION['is_valid'])) {
  $action = 'login';
}

switch($action){
  case 'login':
    $user = filter_input(INPUT_POST, 'email');
    $password = filter_input(INPUT_POST, 'password'); 
    if(valid_login($user, $password)){
      $_SESSION['is_valid'] = true;
      $_SESSION['username'] = $user;
      if(usr_type($user) == "admin"){
        include('admin.php');
      } elseif(usr_type($user) == "client"){
        $_SESSION['cart']=array();
        load_cart();
        if(isset($_SESSION['cartqt'])){
          $_SESSION['cartqt'] = array_sum ($_SESSION['quantiy']);
        } else{
          $_SESSION['cartqt'] = 0;
        }
        
        include('view/client.php');
      }else{
        echo "invlaid type";
      }
    } else if ($password !== NULL && !valid_login($user, $password)) {
      $login_message = "Error: Invlaid credential, you must correctly login to view this site";
      include('view/login.php');
    } else{
      include('view/login.php');
    }
    break;

  case 'home':
    include('view/client.php');
    break;

  case 'logout':
    session_unset(); 
    session_destroy(); 
    $login_message = 'You have been logged out.';
    include('view/login.php');
    break;

  case 'products':
    $year = get_car_year();
    include('view/products.php');
    break;

  case 'car':
    $carYear = filter_input(INPUT_POST, 'year');
    $carMake = filter_input(INPUT_POST, 'make');
    $carModel = filter_input(INPUT_POST, 'model');
    $carEngine = filter_input(INPUT_POST, 'engine');
    $car = array('year' => $carYear, 'make' => $carMake, 'model' => $carModel, 'engine' => $carEngine);
    $carid = get_car_id($car);
    $part_cat = get_part_cat($carid[0]['car_id']);
    include('view/car.php');
    break;

  case 'display':
    $cat = filter_input(INPUT_GET, 'cat');
    $id = filter_input(INPUT_GET, 'carid');
    $products = get_products($cat, $id);
    include('view/displayproducts.php');
    break;

  case 'buy':
    $product = filter_input(INPUT_POST, 'product');
    if(in_cart($product) == false){
      array_push($_SESSION['cart'],$product);
      $_SESSION['quantiy'][$product] = 1;
      $_SESSION['cartqt'] = array_sum ($_SESSION['quantiy']);
      update_cart($product);
    }
    for ($i=0; $i < sizeof($_SESSION['cart']) ; $i++) { 
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    include('view/cart.php');
    break;

  case 'cartupdate':
    $qt = filter_input(INPUT_POST, 'updateqt');
    $ptnum = filter_input(INPUT_POST, 'pnum');
    if($qt == 0 && in_array($ptnum, $_SESSION['cart']) == true){
      $key = array_search($ptnum,$_SESSION['cart']);
      array_splice($_SESSION['cart'], $key, $key + 1);
      unset($_SESSION['quantiy'][$ptnum]);
      $_SESSION['cartqt']--;
      remove_item_from_cart($ptnum);
    }
    $_SESSION['quantiy'][$ptnum] = $qt;
    for ($i=0; $i < sizeof($_SESSION['cart']) ; $i++) { 
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    $_SESSION['cartqt'] = array_sum ($_SESSION['quantiy']);
    include('view/cart.php');
    break;

  case 'checkout':
    do {
      $odnum = uniqid();
    } while (ordernum_exist($odnum) == true);
    $subtotal = 0;
    foreach ($prod as $p) {
      $subtotal += $p['price'] * $_SESSION['quantiy'][$p['part_number']];
    }
    $tax = $subtotal * 0.06;
    $total = $subtotal + $tax;
    //intsert_order();
    break;

  case 'cart':
    for ($i=0; $i < sizeof($_SESSION['cart']) ; $i++) { 
      $prod[$i] = get_prod_into($_SESSION['cart'][$i]);
    }
    include('view/cart.php');
}
?>
