<?php
include('model/data_func.php');
$year = get_car_year();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Auto Parts Direct</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php?action=home">Auto Part Direct</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=home">Home</a>
        </li>
        <li class="nav-item active">
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
    <div class="card">
      <form action="">
        <label for="">Year:</label>
        <select name="" id="" class="form-control">
          <?php foreach($year as $yr):?>
          <option><?php echo $yr['year'];?></option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>
  </main>
</body>
</html>