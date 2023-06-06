<?php

include('../config/config.php');
$item_no = $_POST['item_no'];

$sql = "SELECT * FROM `items_db` WHERE `Item_No` = '$item_no'";

$result = mysqli_query($connect, $sql);
$data;



if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
    $data = json_encode($row);
    }
    echo $data;
}
