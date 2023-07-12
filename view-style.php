<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

include('includes/header.php');
include('includes/navbar.php');
include('config/config.php');
?>

<?php

$id =  $_GET['product_id'];

$fetch_details = "SELECT * FROM `init_style_db` WHERE `product_id` = '$id'";
$result = mysqli_query($connect, $fetch_details);
while ($row =  mysqli_fetch_array($result)) {


?>
    <div class="card-header py-3">
        <h2 class="m-0 font-weight-bold text-primary">
            Product Details
        </h2>
    </div>
    <div class="container-fluid" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-content my-3 col-12">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><span>Style Name: </span><?php echo $row['product_name']; ?></h3>
            </div>
            <br>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="container">
                    <div class="row ">
                        <div class="col-3 mb-3">
                            <img src='product_images/<?php echo $row['preview_image']; ?>' height="200px" width="200px" alt="Style Image">
                        </div>
                        <div class="col-2 mb-3">
                            <label class="form-label">Style Number</label>
                            <input type="text" class="form-control" value="<?php echo $row['style_no']; ?>" readonly>
                        </div>
                        <div class="col-2 mb-3">
                            <label class="form-label">Color</label>
                            <input type="text" name="color" class="form-control" value="<?php echo $row['color']; ?>" readonly>
                        </div>
                        <div class="col-2 mb-3">
                            <label class="form-label">Number of Part</label>
                            <input type="text" name="color" class="form-control" value="<?php echo $row['no_of_part']; ?>" readonly>
                        </div>
                        <div class="col-2 mb-3">
                            <label class="form-label">Range Code</label>
                            <input type="text" name="color" class="form-control" value="<?php echo $row['range_code']; ?>" readonly>
                        </div>


                        <div class="col-6">


                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            <span class="p_head">Process</span>
                                        </th>
                                        <th>
                                            <span class="p_head">Charges</sapn>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $data = json_decode($row["rate_details"], true);

                                    foreach ($data as $key => $value) {
                                        $rmUnder = str_replace("_", " ", $key);
                                        if ($value != 0) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($rmUnder) . "</td>";
                                            echo "<td>" . $value . "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                    <tr class="text-end">
                                        <td> <strong>Total</strong></td>
                                        <td><input type="text" class="form-control" id="totalLabourCharges" value=" <?php echo $row['labourCharges']; ?>"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>



                        <div class="col-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>
                                            <span class="p_head">Process Assigned</span>
                                        </th>
                                        <th>
                                            <span class="p_head">Action</sapn>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $data = json_decode($row["applicable_operation"], true);
                                    foreach ($data as $key => $value) {
                                        $rmUnder = str_replace("_", " ", $key);
                                        if ($value != 0) {
                                            echo "<tr>";
                                            echo "<td>" . ucwords($rmUnder) . "</td>";
                                            echo "<td><input type='checkbox' checked></td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="print-style.php?style-id=<?php echo $id ?>" class="btn btn-primary" target="_blank">Print Style Sheet PDF</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
<?php } ?>
<?php
include('includes/footer.php');
?>