<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

include('includes/header.php');
include('includes/navbar.php');
include('config/config.php');
$item_exists = false;
if (isset($_POST['createItem'])) {
    $item_type = mysqli_real_escape_string($connect, $_POST['item_type']);
    $item_number = mysqli_real_escape_string($connect, $_POST['item_number']);
    $item_name = mysqli_real_escape_string($connect, $_POST['item_name']);
    $hsn_code = mysqli_real_escape_string($connect, $_POST['hsn_code']);
    $quantity = mysqli_real_escape_string($connect, $_POST['quantity']);
    $rate = mysqli_real_escape_string($connect, $_POST['rate']);
    $uom = mysqli_real_escape_string($connect, $_POST['uom']);
    $amount = $quantity * $rate;
    $specs = mysqli_real_escape_string($connect, $_POST['specs']);


    $check_item = "SELECT * FROM `items_db` WHERE `Item_No` = '$item_number'";
    $check_item_result = mysqli_query($connect, $check_item);

    $itemExistRows = mysqli_num_rows($check_item_result);
    if ($itemExistRows > 0) {
        $item_exists = true;
    } else {
        $item_create_query = "INSERT INTO `items_db`( `Item_No`, `item_type`,`Item_Name`, `Hsn_Code`, `Qnt`, `UOM`, `Rate`, `Amount`, `Specs`) VALUES ('$item_number','$item_type','$item_name','$hsn_code','$quantity','$uom','$rate','$amount','$specs')";
        mysqli_query($connect, $item_create_query);
    }
}

?>

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Leather</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="modal-body">
                    <?php
                    if ($item_exists == true) {
                        echo '<h6 class="alert-danger">Item already has been uploaded</h>';
                    }
                    ?>
                    <div class="row ">
                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label">Item Type</label>
                            <input type="text" name="item_type" class="form-control" value="Leather" readonly>
                        </div>
                        <div class="mb-3 col-md-6 col-12">
                            <label class="form-label">Item Number *</label>
                            <input type="text" name="item_number" class="form-control" placeholder="Item Number" required>
                        </div>
                        <div class="mb-3 col-md-8 col-12">
                            <label class="form-label">Item Name*</label>
                            <input type="text" name="item_name" class="form-control" placeholder="Item Name" required>
                        </div>
                        <div class="mb-3 col-md-4 col-12">
                            <label class="form-label">HSN Code</label>
                            <input type="text" name="hsn_code" class="form-control" placeholder="HSN Code">
                        </div>

                        <div class="mb-3 col-md-4 col-12">
                            <label class="form-label">Quantity*</label>
                            <input type="text" name="quantity" class="form-control" placeholder="Quantity" required>
                        </div>
                        <div class="mb-3 col-md-3 col-12">
                            <label class="form-label">UOM*</label>
                            <input type="text" name="uom" class="form-control" value="SQFT" readonly>
                        </div>
                        <div class="mb-3 col-md-5 col-12">
                            <label class="form-label">Rate*</label>
                            <input type="text" name="rate" class="form-control" placeholder="Rate" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="form-label">Specification</label>
                            <input type="text" name="specs" class="form-control" placeholder="Specification">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="createItem" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Leather Details
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addadminprofile">
                    Add Items
                </button>
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Item Number</th>
                            <th>Item Name</th>
                            <th>HSN Code</th>
                            <th>Quantity</th>
                            <th>UOM</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Specification</th>
                            <th colspan="2">Action</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $item_fetch_query = "SELECT * FROM `items_db` WHERE  `item_type` = 'Leather'";
                        $item_fetch_result = mysqli_query($connect, $item_fetch_query);

                        while ($row =  mysqli_fetch_array($item_fetch_result)) {
                            echo "<tr>";
                            echo "<td>" . $row['Item_No'] . "</td>";
                            echo "<td>" . $row['Item_Name'] . "</td>";
                            echo "<td>" . $row['Hsn_Code'] . "</td>";
                            echo "<td>" . $row['Qnt'] . "</td>";
                            echo "<td>" . $row['UOM'] . "</td>";
                            echo "<td>" . $row['Rate'] . "</td>";
                            echo "<td>" . $row['Amount'] . "</td>";
                            echo "<td>" . $row['Specs'] . "</td>";
                            echo '<td><button type="submit" name="edit_btn" class="btn btn-success"><ion-icon name="create-outline"></ion-icon></button></td>';
                            echo '<td> <button type="submit" name="delete_btn" class="btn btn-danger"><ion-icon name="trash-outline"></ion-icon></button></td>';
                            echo "</tr>";
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>



<!-- ---------------------------Footer here-------------------------------------- -->

<?php
include('includes/footer.php');
?>