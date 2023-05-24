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
        <h6 class="m-0 font-weight-bold text-primary">
            Product Details
        </h6>
    </div>
    <div class="container-fluid" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-content my-3 col-12">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"><?php echo $row['product_name']; ?></h3>
            </div>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="modal-body">

                    <div class="row ">
                        <div class="form-group col-md-4 col-12">
                            <label>Style Number</label>
                            <input type="text" class="form-control" value="<?php echo $row['style_no']; ?>" name="product_style_no">
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <label>Color</label>
                            <input type="text" name="color" class="form-control" value="<?php echo $row['color']; ?>" placeholder="Color">
                        </div>
                        <div class="form-group col-md-4 col-12">
                            <img src='product_images/<?php echo $row['preview_image']; ?>' height="150px" width="250px" alt="Product Photo">
                        </div>

                    </div>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <span class="p_head">Item Code</span>
                                </th>
                                <th>
                                    <span class="p_head">Item Name</sapn>
                                </th>
                                <th>
                                    <span class="p_head">UOM</sapn>
                                </th>
                                <th>
                                    <span class="p_head">Rate</sapn>
                                </th>
                                <th>
                                    <span class="p_head">Quantity</sapn>
                                </th>
                                <th>
                                    <span class="p_head">Amount</sapn>
                                </th>
                                <th>
                                    <span class="p_head">Specification</sapn>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                <?php
                               
                                
                                ?>
                            <?php echo "</tr>"?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
       
    </div>
<?php } ?>
<?php
include('includes/footer.php');
?>