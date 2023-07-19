<?php

include('../config/config.php');
$style_no = $_POST['styleNo'];

$sql = "SELECT * FROM `costing_db` WHERE `style_no` = '$style_no'";

$result = mysqli_query($connect, $sql);
$data;



if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
    $data = json_encode($row);
    }
    echo $data;
}
