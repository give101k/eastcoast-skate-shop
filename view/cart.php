<!DOCTYPE html>
<html>
  <head>
    <title>Auto Parts Direct</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" type="text/css" href="css/cart.css">
    <script type="text/javascript" src="javascript/cart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
      <a class="navbar-brand" href="index.php?action=home">Auto Part Direct</a>
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
          <li class="nav-item active">
            <a class="nav-link" href="index.php?action=home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?action=products">Products</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="index.php">
          <input type="hidden" name="action" value="logout" />
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">
            Logout
          </button>
        </form>
      </div>
    </nav>
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="page-header">
              <h1>Your Shopping Cart</h1>
            </div>
          </div>
        </div>
        <?php foreach($prod as $pd): ?>
          <div class="row prod-row">
            <div class="col">
              <img class="cart-img" src="<?php echo $pd['img_url'];?>" alt="">
            </div>
            <div class="col">
              <h3><?php echo $pd['brand'].' '.$pd['name'];?></h3>
            </div>
            <div class="col">
            <h3><?php echo '$'.number_format($pd['price'],2);?></h3>
            </div>
            <div class="col">
              <form action="." method="post">
                <input type="hidden" name="action" value="cartupdate">
                <input type="hidden" name="pnum" value="<?php echo $pd['part_number'];?>">
                <input type="number"  name="updateqt" class="form-control" value="<?php echo $_SESSION['quantiy'][$pd['part_number']] ?>">
                <input type="submit" class="btn btn-primary" id="updatebt" value="update">
              </form>
            </div>
            <div class="col">
              <h3>
              <?php echo '$'.number_format(($pd['price'] * $_SESSION['quantiy'][$pd['part_number']]), 2); ?>
              </h3>
              
            </div>
          </div>
        <?php endforeach; ?>
      </div>
  </body>
</html>
