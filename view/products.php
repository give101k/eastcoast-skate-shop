<!DOCTYPE html>
<html>
  <head>
    <title>Auto Parts Direct</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/products.css">
    <script type="text/javascript" src="javascript/products.js"></script>
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
        <li class="nav-item active">
          <a class="nav-link" href="index.php?action=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=products">Products</a>
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
      <form action="." method="post" id="car">
        <input type="hidden" name="action" value="car">
        <label for="">Year:</label>
        <select name="year" id="" class="form-control" onchange="showMake(this.value)">
          <option value="">Year:</option>
          <?php foreach($year as $yr):?>
          <option value="<?php echo $yr['year'];?>"><?php echo $yr['year'];?></option>
          <?php endforeach; ?>
        </select>
        <div id="make"></div>
        <div id="model"></div>
        <div id="engine"></div>
      </form>
    </div>
  </main>
</body>
</html>