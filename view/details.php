<!DOCTYPE html>
<html>

<head>
  <title>EastCost Skate Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="css/account.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
    <a class="navbar-brand" href="index.php?action=home">EastCost Skate Shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="?action=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?action=products&cat=all">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="?action=account">My Account</a>
        </li>
        <?php if ($_SESSION['is_valid'] == false): ?>
        <li class="nav-item">
          <a class="nav-link" href="?action=reg">Register</a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=cart"> Cart <i class="fas fa-shopping-cart"></i>
            <span class="label label-primary"></span>
            <?php echo $_SESSION['cartqt']; ?>
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="">Contact Us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="index.php">
        <?php if ($_SESSION['is_valid'] == true): ?>
        <input type="hidden" name="action" value="logout" />
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">
          Logout
        </button>
        <?php else: ?>
        <input type="hidden" name="action" value="login" />
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">
          Login
        </button>
        <?php endif; ?>
      </form>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row order">
      <div class="col-sm-12">
        <div class="row">
          <div class="col">
            Order Date:
            <?php
            $date = new DateTime($order[0]['date']);
            echo $date->format('h:i a T m-d-Y');
            ?>
            <br>
            Order Number:
            <?php echo $order[0]['order_number']; ?>
          </div>
          <div class="col text-center">
            Status:
            <?php echo $order[0]['status']; ?>
          </div>
          <div class="col text-right">
            Total price:
            $<?php echo $order[0]['total_price']; ?>
          </div>
        </div>
        <br>
        <?php foreach ($items as $item): ?>
        <hr>
        <div class="row">
          <div class="col">
            Item:
            <?php echo $item['name']; ?>
          </div>
          <div class="col text-center">
            Quantity:
            <?php echo $item['qt']; ?>
          </div>
          <div class="col text-right">
            Price:
            <?php echo $item['price']; ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</body>

</html>