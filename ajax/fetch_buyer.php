<?php

include('../config/config.php');
$buyerId = $_POST['selectBuyerId'];

$sql = "SELECT * FROM `buyer_db` WHERE `buyer_code` = '$buyerId'";

$result = mysqli_query($connect, $sql);
$data;



if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
    $data = json_encode($row);
    }
    echo $data;
}
