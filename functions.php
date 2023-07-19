<?php


function isCharged($value)
{
    if ($value == '' || $value == null) {
        return "0";
    } else {
        return $value;
    }
}


function isChecked($value)
{

    if (isset($_REQUEST[$value])) {
        return 1;
    } else {
        return 0;
    }
}

function createBoOrderNo()
{
    include('config/config.php');
    $sql = "SELECT * FROM `buyersorder_db` ORDER BY id DESC LIMIT 1";
    $orderPrefix = "PMBO-";
    $orderMonth = date("M");
    $firstOrder =  $orderPrefix . $orderMonth . "-" . 1;
    $sqlResult = mysqli_query($connect, $sql);

    if (mysqli_num_rows($sqlResult) > 0) {
        $lastRow = mysqli_fetch_assoc($sqlResult);
        $preorderNumber = $lastRow['id'] + 1;
        $orderNumber = $orderPrefix . $orderMonth . "-" . $preorderNumber;
        return $orderNumber;
    } else {
        return $firstOrder;
    }
}



function createPoOrderNo()
{
    include('config/config.php');
    $sql = "SELECT * FROM `purchaseorder_db` ORDER BY id DESC LIMIT 1";
    $orderPrefix = "PMPO-";
    $orderMonth = date("M");
    $firstOrder =  $orderPrefix . $orderMonth . "-" . 1;
    $sqlResult = mysqli_query($connect, $sql);

    if (mysqli_num_rows($sqlResult) > 0) {
        $lastRow = mysqli_fetch_assoc($sqlResult);
        $preorderNumber = $lastRow['id'] + 1;
        $orderNumber = $orderPrefix . $orderMonth . "-" . $preorderNumber;
        return $orderNumber;
    } else {
        return $firstOrder;
    }
}
