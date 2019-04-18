<?php
include('../model/data_func.php');
$make = strval($_GET['make']);
$year = intval($_GET['year']);
$model = strval($_GET['model']);
$engine = get_car_engine($year, $make, $model);
var_dump($engine);
?>