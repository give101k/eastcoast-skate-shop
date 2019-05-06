<!DOCTYPE html>
<html>
<head>
  <title>EastCost Skate Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" type="text/css" href="css/products.css" />
  <script type="text/javascript" src="javascript/prod.js"></script>
  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
    crossorigin="anonymous"
  />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php?action=home">EastCost Skate Shop</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#collapsibleNavbar"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="?action=home">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="?action=products&cat=all">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?action=account">My Account</a>
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
  <div class="fluid-container">
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <a href="?action=products&cat=all">All</a>
      <a href="?action=products&cat=decks">Decks</a>
      <a href="?action=products&cat=trucks">Trucks</a>
      <a href="?action=products&cat=bearings">Bearings</a>
      <a href="?action=products&cat=wheels">Wheels</a>
      <a href="?action=products&cat=acc">Accessories</a>
    </div>
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;Categories</span>
  <div class="card-columns">
    <?php foreach ($products as $pd): ?>
      <div class="card">
        <img src="<?php echo $pd[
          'img_url'
        ]; ?>" alt="" class="card-img-top max">
        <div class="card-body">
          <h4 class="card-title"><?php echo $pd['name']; ?></h4>
          <p class="card-text">
            Brand:
            <?php echo $pd['brand']; ?>
            <br>
            Description:
            <?php echo $pd['description']; ?>
            <br>
            Price: $
            <?php echo $pd['price']; ?>
            <br>
            Number in stock:
            <?php echo $pd['num_stock']; ?>
          </p>
          <form action="." method="post">
            <input type="hidden" name="action" value="buy">
            <input type="hidden" name="product" value="<?php echo $pd[
              'product_number'
            ]; ?>">
            <input type="submit" class="btn btn-primary" value="Buy">
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  </div>
</body>
</html>
