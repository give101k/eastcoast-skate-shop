<?php
include '../model/data_func.php';
$make = strval($_GET['make']);
$year = intval($_GET['year']);
$model = get_car_model($year, $make);
?>
<label for="">Model:</label>
<select name="model" id="" class="form-control" onchange="showEngine(<?php echo $year; ?>, '<?php echo strval(
  $make
); ?>', this.value)">
  <option value="">Model:</option>
  <?php foreach ($model as $md): ?>
  <option value="<?php echo $md['model']; ?>">
    <?php echo $md['model']; ?>
  </option>
  <?php endforeach; ?>
</select>