<?php

include('../config/config.php');
$leather_no = $_POST['leather_no'];

$sql = "SELECT * FROM `items_db` WHERE `Item_No` = '$leather_no'";

$result = mysqli_query($connect, $sql);
$output = "";




if (mysqli_num_rows($result) > 0) {
    $output = "<thead>
<tr>
    <th>Leather Code</th>
    <th>Leather Name</th>
    <th>HSN Code</th>
    <th>QTY</th>
    <th>UOM</th>
    <th>Rate</th>
    <th>Amount</th>
</tr>
</thead>";
    while ($row = mysqli_fetch_array($result)) {
        $output .= "
    <tr>
                        <td><input type='text' class='form-control' value='{$row['Item_No']}'></td>
                        <td><input type='text' class='form-control' value='{$row['Item_Name']}'></td>
                        <td><input type='text' class='form-control' value='{$row['Hsn_Code']}'></td>
                        <td><input type='text' class='form-control' id='leather_qty' placeholder='QTY' data-bs-toggle='modal' data-bs-target='#selectLeatherCalc'></td>
                        <td><input type='text' class='form-control' value='{$row['UOM']}'></td>
                        <td><input type='text' class='form-control' value='{$row['Rate']}' id='rate'></td>
                        <td><input type='text' class='form-control' placeholder='Amount' id='amount'></td>
                    </tr>
    ";
    }
    echo $output;
}
