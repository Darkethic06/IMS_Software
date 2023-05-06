<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
require_once('includes/header.php');
require_once('includes/navbar.php');
require_once('config/config.php');
$supplierExists = false;

if (isset($_POST['addSupplier'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $vat = $_POST['vat'];
    $pan = $_POST['pan'];
    $gst = $_POST['gst'];
    $state_code = $_POST['state_code'];
    $email = $_POST['email'];
    $website = $_POST['website'];
    $con_person = $_POST['con_person'];
    $remarks = $_POST['remarks'];
    $status = $_POST['status'];


    $check_supplier = "SELECT * FROM `supplier_db` WHERE `supplier_code` = '$supplier_code'";
    $check_supplier_result = mysqli_query($connect, $check_supplier);

    $supplierExistRows = mysqli_num_rows($check_supplier_result);
    if ($supplierExistRows > 0) {
        $supplierExists = true;
    } else {
        $create_supplier = "INSERT INTO `supplier_db`(`supplier_code`, `name`, `phone`, `address`, `vat`, `pan`, `gst`, `state_code`, `email`, `web`, `con_person`, `remarks`, `status`) VALUES ('$supplier_code','$name','$phone','$address','$vat','$pan','$gst','$state_code','$email','$website','$con_person','$remarks','$status')";
        mysqli_query($connect, $create_supplier);
    }
}
?>
<div class="modal fade" id="addadminprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Supllier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="modal-body">
                    <div class="row">

                        <div class="form-group col-md-4">
                            <label> Supplier Code</label>
                            <input type="text" class="form-control" value="001">
                        </div>
                        <div class="form-group col-md-8">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Phone">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Phone</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Phone">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Address">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Vat No.</label>
                            <input type="text" name="vat" class="form-control" placeholder="Vat No.">
                        </div>
                        <div class="form-group col-md-6">
                            <label>PAN No.</label>
                            <input type="text" name="pan" class="form-control" placeholder="PAN No.">
                        </div>
                        <div class="form-group col-md-8">
                            <label>GSTIN No.</label>
                            <input type="text" name="gst" class="form-control" placeholder="GSTIN No.">
                        </div>
                        <div class="form-group col-md-4">
                            <label>State Code</label>
                            <input type="text" name="state_code" class="form-control" placeholder="State Code">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Website</label>
                            <input type="text" name="website" class="form-control" placeholder="Website">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Contact Person</label>
                            <input type="text" name="con_person" class="form-control" placeholder="Contact Person">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Remarks</label>
                            <input type="text" name="remarks" class="form-control" placeholder="Remarks">
                        </div>
                        <div class="form-group  col-md-4">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option value="1" class="form-control" selected>Active</option>
                                <option value="0" class="form-control">Inactive</option>
                            </select>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addSupplier" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<br><br>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Suppliers
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addadminprofile">
                    Add Supplier
                </button>
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <?php
                if ($supplierExists == true) {
                    echo '<h6 class="text-center" style="color:red;">Phone already registered</h>';
                }
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Supplier Code</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Vat</th>
                            <th>PAN No.</th>
                            <th>GSTIN No.</th>
                            <th>State</th>
                            <th>Email</th>
                            <!-- <th>Website</th>
                            <th>Contact Person</th>
                            <th>Remarks</th> -->
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $fetch_query = "SELECT * FROM `supplier_db`";
                        $fetch_result = mysqli_query($connect, $fetch_query);

                        while ($row =  mysqli_fetch_array($fetch_result)) {
                            echo "<tr>";
                            echo "<td>" . $row['supplier_code'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['phone'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['vat'] . "</td>";
                            echo "<td>" . $row['pan'] . "</td>";
                            echo "<td>" . $row['gst'] . "</td>";
                            echo "<td>" . $row['state_code'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";


                            if ($row['status'] == 0) {
                                echo '<td><form action" method="post">
                            <input type="hidden" name="edit_id" value="">
                            <button  type="submit" name="edit_btn" class="btn btn-success">Activate</button>
                        </form></td>';
                            } else {
                                echo '<td><form action" method="post">
                            <input type="hidden" name="edit_id" value="">
                            <button  type="submit" name="edit_btn" class="btn btn-success">Deactivate</button>
                        </form></td>';
                            }

                            echo '<td><form action" method="post">
                <input type="hidden" name="edit_id" value="">
                <button  type="submit" name="edit_btn" class="btn btn-success"><ion-icon name="create-outline"></ion-icon></button>
            </form></td>';
                                echo '<td>
            <form action="" method="post">
                <input type="hidden" name="delete_id" value="">
                <button type="submit" name="delete_btn" class="btn btn-danger"><ion-icon name="trash-outline"></ion-icon></button>
            </form>
        </td>';
                            echo "</tr>";
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>



<?php
require_once('includes/footer.php');

?>