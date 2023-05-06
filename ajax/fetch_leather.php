<?php

include('../config/config.php');
$leather_no = $_POST['leather_no'];

$sql = "SELECT * FROM `items_db` WHERE `Item_No` = '$leather_no'";

$result = mysqli_query($connect, $sql);
$data;



if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
    $data = json_encode($row);
    }
    echo $data;
}
