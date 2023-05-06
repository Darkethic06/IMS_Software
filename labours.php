<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
require_once('includes/header.php');
require_once('includes/navbar.php');
require_once('config/config.php');
// require_once('functions.php');

$labour_exists = false;



// $labourCode = createLabourId();

if (isset($_POST['createLabour'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact = $_POST['phone'];
    $pan = $_POST['pan'];
    $voter = $_POST['voter_card'];
    $aadhar = $_POST['aadhar'];
    $ac_name = $_POST['ac_name'];
    $ac_number = $_POST['ac_number'];
    $bank_name = $_POST['bank_name'];
    $branch = $_POST['bank_branch'];
    $ifsc = $_POST['ifsc'];
    $status = $_POST['labour_status'];
    $type = $_POST['labour_type'];

    $sql_id = "SELECT * FROM `labour_db` ORDER BY `labour_code` DESC LIMIT 1";

    $result_id = mysqli_query($connect, $sql_id);

    $row_id = mysqli_fetch_row($result_id);
    $last_id =  $row_id[1];

    $labourCode = $last_id +1;

    $check_labour = "SELECT * FROM `labour_db` WHERE `labour_code` = '$labourCode'";
    $check_labour_result = mysqli_query($connect, $check_labour);

    $labourExistRows = mysqli_num_rows($check_labour_result);
    if ($labourExistRows > 0) {
        $labour_exists = true;
    } else {

        $create_labour = "INSERT INTO `labour_db`(`labour_code`, `labour_name`, `address`, `contact`, `pan_no`, `voter_card`, `aadhar_no`, `ac_name`, `ac_number`, `bank_name`, `branch_name`, `ifsc`, `status`, `labour_type`) VALUES ('$labourCode','$name','$address','$contact','$pan','$voter','$aadhar','$ac_name','$ac_number','$bank_name','$branch','$ifsc','$status','$type')";
        mysqli_query($connect, $create_labour);
    }
}



?>

<div class="modal fade" id="labourprofile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Labour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="modal-body">
                    <div class="row">
                        
                        <div class="mb-3 col-md-8">
                            <label class="form-label">Labour Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Labour Name">
                        </div>
                        <div class="mb-3 col-md-8">
                            <label class="form-label">Labour Phone</label>
                            <input type="tel" name="phone" class="form-control" placeholder="Labour Phone">
                        </div>
                        <div class="mb-3  col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="labour_status">
                                <option value="1"selected>Active</option>
                                <option value="0" >Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Address">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">PAN No.</label>
                            <input type="text" name="pan" class="form-control" placeholder="PAN No.">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Voter Card</label>
                            <input type="text" name="voter_card" class="form-control" placeholder="Voter Card">
                        </div>
                        <div class="mb-3 col-md-8">
                            <label class="form-label">Aadhar No.</label>
                            <input type="text" name="aadhar" class="form-control" placeholder="Aadhar No.">
                        </div>
                        <div class="mb-3  col-md-4">
                            <label class="form-label">Labour Type</label>
                            <select class="form-select" name="labour_type">
                                <option value="Cutter">Cutter</option>
                                <option value="Skiver">Skiver</option>
                                <option value="Fabroicator">Fabroicator</option>
                                <option value="Checker">Checker</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">A/C Holder Name</label>
                            <input type="text" name="ac_name" class="form-control" placeholder="A/C Holder Name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">A/C Number</label>
                            <input type="text" name="ac_number" class="form-control" placeholder="A/C Number">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="Bank Name">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Branch</label>
                            <input type="text" name="bank_branch" class="form-control" placeholder="Branch">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label class="form-label">IFSC Code</label>
                            <input type="text" name="ifsc" class="form-control" placeholder="IFSC">
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="createLabour" class="btn btn-primary">Save</button>
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
            <h6 class="m-0 font-weight-bold text-primary">Labour Profile
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#labourprofile">
                    Add Labour
                </button>
            </h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <?php
                if ($labour_exists == true) {
                    echo '<h6 class="text-center" style="color:red;">Labour already registered</h>';
                }
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th> Labour Code </th>
                            <th>Labour Name</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Pan No</th>
                            <th>Voter Card No</th>
                            <th>Aadhar No</th>
                            <th>Labour Type</th>
                            <th>Status</th>
                            <th colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $fetch_query = "SELECT * FROM `labour_db`";
                        $fetch_result = mysqli_query($connect, $fetch_query);

                        while ($row =  mysqli_fetch_array($fetch_result)) {
                            echo "<tr>";
                            echo "<td>" . $row['labour_code'] . "</td>";
                            echo "<td>" . $row['labour_name'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['contact'] . "</td>";
                            echo "<td>" . $row['pan_no'] . "</td>";
                            echo "<td>" . $row['voter_card'] . "</td>";
                            echo "<td>" . $row['aadhar_no'] . "</td>";
                            echo "<td>" . $row['labour_type'] . "</td>";
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