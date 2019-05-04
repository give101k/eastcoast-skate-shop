<!DOCTYPE html>
<html>
  <head>
    <title>Auto Parts Direct</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <script type="text/javascript" src="javascript/products.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php?action=home">Auto Part Direct</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=home">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="index.php?action=products">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=cart">Cart <i class="fas fa-shopping-cart"></i>
          <span class="label label-primary">
            <?php echo $_SESSION['cartqt']; ?>
          </span>
        </a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="index.php">
        <input type="hidden" name="action" value="logout">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Logout</button>
      </form>
    </div>
  </nav>
  <main class="container">
    <div class="card" id="crd">
      <div class="list-group">
        <?php foreach ($part_cat as $cat): ?>
          <a 
            href="?action=display&cat=<?php echo $cat[
              'category'
            ]; ?>&carid=<?php echo $carid[0]['car_id']; ?>" 
            class="list-group-item list-group-item-action"><?php echo $cat[
              'category'
            ]; ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </main>
</body>
</html>