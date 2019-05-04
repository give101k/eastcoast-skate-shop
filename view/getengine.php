<?php
include '../model/data_func.php';
$make = strval($_GET['make']);
$year = intval($_GET['year']);
$model = strval($_GET['model']);
$engine = get_car_engine($year, $make, $model);
?>

<label for="">Engine:</label>
<select name="engine" id="" class="form-control">
  <option value="">Engine:</option>
  <?php foreach ($engine as $eg): ?>
  <option value="<?php echo $eg['engine']; ?>">
    <?php echo $eg['engine']; ?>
  </option>
  <?php endforeach; ?>
</select>
<input type="submit" value="Submit" class="btn btn-lg btn-primary btn-block" id="sub">
