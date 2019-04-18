<?php
include('../model/data_func.php');
$yer = intval($_GET['year']);
$make = get_car_make($yer);
?>
<label for="">Make:</label>
<select name="make" id="" class="form-control" onchange="showModel(<?php echo $yer;?>, this.value)">
  <option value="">Make:</option>
  <?php foreach($make as $mk): ?>
  <option value="<?php echo $mk['make'];?>"><?php echo $mk['make'];?></option>
  <?php endforeach?>
</select>
