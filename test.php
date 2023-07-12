<?php
include('config/config.php');
$fetch_costing= "SELECT * FROM `init_style_db` WHERE `style_no` = '1650-01-12'";
$costingResult = mysqli_query($connect, $fetch_costing);
$row =  mysqli_fetch_array($costingResult);


$data = json_decode($row["item_Details"], true);
