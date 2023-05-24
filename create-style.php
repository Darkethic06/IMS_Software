<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
include('includes/header.php');
include('includes/navbar.php');
include('config/config.php');
include('functions.php');

$product_exists = false;
if (isset($_POST['createStyle'])) {
    $product_name = mysqli_real_escape_string($connect, $_POST['product_name']);
    $style_no = mysqli_real_escape_string($connect, $_POST['product_style_no']);
    $color = mysqli_real_escape_string($connect, $_POST['color']);
    $imageName = $_FILES['image']['name'];
    $tmp_imageName = $_FILES['image']['tmp_name'];
    $no_of_part = mysqli_escape_string($connect, $_POST['part']);
    $range_code = $_POST['range_code'];

    $rate_details_array = array(
        'cutting_rate' => isCharged($_POST['cutting_rate']),
        'skiving_rate' => isCharged($_POST['skiving_rate']),
        'splitting_rate' => isCharged($_POST['splitting_rate']),
        'clicking_rate' => isCharged($_POST['clicking_rate']),
        'embossing_rate' => isCharged($_POST['embossing_rate']),
        'lining_cut_rate' => isCharged($_POST['lining_cut_rate']),
        'stiching_rate' => isCharged($_POST['stiching_rate']),
        'finishing_rate' => isCharged($_POST['finishing_rate']),
        'strap_making_rate' => isCharged($_POST['strap_making_rate']),
        'riving_rate' => isCharged($_POST['riving_rate']),
        'embroidery_rate' => isCharged($_POST['embroidery_rate']),
        'adhesive_rate' => isCharged($_POST['adhesive_rate']),
        'reinforce_rate' => isCharged($_POST['reinforce_rate']),
        'design_rate' => isCharged($_POST['design_rate']),
        'cleaning_rate' => isCharged($_POST['cleaning_rate']),
        'stuffing_rate' => isCharged($_POST['stuffing_rate']),
        'fabrication_rate_internal' => isCharged($_POST['fabrication_rate_internal']),
        'fabrication_rate_external' => isCharged($_POST['fabrication_rate_external']),
        'canvas_rate' => isCharged($_POST['canvas_rate']),
        'laser_cutting_rate' => isCharged($_POST['laser_cutting_rate']),
        'printing_rate' => isCharged($_POST['printing_rate']),
        'lining_make_rate' => isCharged($_POST['lining_make_rate']),
        'fitting_lasting_rate' => isCharged($_POST['fitting_lasting_rate']),
        'pasting_rate' => isCharged($_POST['pasting_rate']),
        'spray_finish_rate' => isCharged($_POST['spray_finish_rate']),
        'gulchi_rate' => isCharged($_POST['gulchi_rate']),
        'edge_inking_rate' => isCharged($_POST['edge_inking_rate']),
        'washing_rate' => isCharged($_POST['washing_rate']),
        'assemble_rate' => isCharged($_POST['assemble_rate']),
        'tap_making_rate' => isCharged($_POST['tap_making_rate']),
        'flap_set_internal' => isCharged($_POST['flap_set_internal']),
        'front_lining_rate' => isCharged($_POST['front_lining_rate']),
        'back_lining_rate' => isCharged($_POST['back_lining_rate']),
        'final_cutting_rate' => isCharged($_POST['final_cutting_rate']),
        'drying_rate' => isCharged($_POST['drying_rate']),
        'roto_rate' => isCharged($_POST['roto_rate']),
        'front_part_rate' => isCharged($_POST['front_part_rate']),
        'back_part_rate' => isCharged($_POST['back_part_rate']),
        'gusset_set_rate' => isCharged($_POST['gusset_set_rate']),
        'grip_handle_rate' => isCharged($_POST['grip_handle_rate']),
    );
    $rate_details = json_encode($rate_details_array);
    $total_rate = 0;

    foreach ($rate_details_array as $rate) {
        $total_rate += $rate;
    }

    $labourCharges = $total_rate;
    $applicable_opt_array = array(
        'splitting_check' => isChecked('splitting_check'),
        'stiching_check' => isChecked('stiching_check'),
        'riveting_check' => isChecked('riveting_check'),
        'drying_check' => isChecked('drying_check'),
        'reinforce_check' => isChecked('reinforce_check'),
        'printing_check' => isChecked('printing_check'),
        'edgeInking_check' => isChecked('edgeInking_check'),
        'guesset_check' => isChecked('guesset_check'),
        'flap_set_check' => isChecked('flap_set_check'),
        'canvas_check' => isChecked('canvas_check'),
        'clicking_check' => isChecked('clicking_check'),
        'finishing_check' => isChecked('finishing_check'),
        'fitting_check' => isChecked('fitting_check'),
        'skiving_check' => isChecked('skiving_check'),
        'cleaning_check' => isChecked('cleaning_check'),
        'lining_making_check' => isChecked('lining_making_check'),
        'roto_check' => isChecked('roto_check'),
        'grip_handle' => isChecked('grip_handle'),
        'front_lining_check' => isChecked('front_lining_check'),
        'embossing_check' => isChecked('embossing_check'),
        'design_check' => isChecked('design_check'),
        'spray_check' => isChecked('spray_check'),
        'embroidery_check' => isChecked('embroidery_check'),
        'stuff_check' => isChecked('stuff_check'),
        'pasting_check' => isChecked('pasting_check'),
        'front_part_check' => isChecked('front_part_check'),
        'assemble_check' => isChecked('assemble_check'),
        'back_lining_check' => isChecked('back_lining_check'),
        'lining_check' => isChecked('lining_check'),
        'strap_making_check' => isChecked('strap_making_check'),
        'wasing_check' => isChecked('wasing_check'),
        'adhesive_check' => isChecked('adhesive_check'),
        'laserCut_check' => isChecked('laserCut_check'),
        'ggulchi_check' => isChecked('gulchi_check'),
        'back_part_check' => isChecked('back_part_check'),
        'tag_baking_check' => isChecked('tag_baking_check'),
        'final_cut_check' => isChecked('final_cut_check')

    );
    $applicable_opt = json_encode($applicable_opt_array);


    $check_product = "SELECT * FROM `init_style_db` WHERE `style_no` = '$style_no'";
    $check_product_result = mysqli_query($connect, $check_product);

    $productExistRows = mysqli_num_rows($check_product_result);
    if ($productExistRows > 0) {
        $product_exists = true;
    } else {
        move_uploaded_file($tmp_imageName, 'product_images/' . $imageName);
        $product_create_query = "INSERT INTO `init_style_db`(`product_name`, `style_no`, `preview_image`, `color`,`no_of_part`, `range_code`, `rate_details`, `applicable_operation`, `labourCharges`) VALUES ('$product_name','$style_no','$imageName','$color','$no_of_part','$range_code', '$rate_details','$applicable_opt','$labourCharges')";
        mysqli_query($connect, $product_create_query);
    }
}

?>

<div class="card-header py-3">
    <h3 class="m-0 font-weight-bold text-primary">
        Create Style

    </h3>
</div>

<div class="container border rounded p-3 mb-5">
    <?php
    if ($product_exists == true) {
        echo '<h6 class="text-danger text-center">Product already has been uploaded</h>';
    }
    ?>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-3 col-md-2">
                <label class="form-label">Product Name</label>
                <input type="text" name="product_name" class="form-control" placeholder="Product Name">
            </div>
            <div class="mb-3 col-md-2">
                <label class="form-label">Style No</label>
                <input type="text" name="product_style_no" class="form-control" placeholder="Style No">
            </div>
            <div class="mb-3 col-md-2 col-12">
                <label class="form-label">Color</label>
                <input type="text" name="color" class="form-control" placeholder="Color">
            </div>
            <div class="mb-3 col-md-2 col-12">
                <label class="form-label">Upload Image</label>
                <input type="file" accept=".png, .jpeg, .jpg" name="image" class="form-control">
            </div>
            <div class="mb-3 col-md-2 col-12">
                <label class="form-label">No. of Part</label>
                <input type="text" name="part" class="form-control" placeholder="No. of Part">
            </div>

            <div class="mb-3 col-md-2 col-12">
                <label class="form-label">Range Code</label>
                <input type="text" name="range_code" class="form-control" placeholder="Range Code">
            </div>
        </div>

        <!-- -------------------------------------End of Rate Details-------------- -->
        <h6 class="m-0 font-weight-bold text-primary">
            Applicable Machine Operation
        </h6>

        <div class="row my-3">

            <div class="col-md-3 col-12">
                <table class="table table-bordered">
                    <tr>
                        <td>Splitting</td>
                        <td> <input type="checkbox" name="splitting_check"> </td>
                    </tr>
                    <tr>
                        <td>Stiching</td>
                        <td> <input type="checkbox" name="stiching_check"> </td>
                    </tr>
                    <tr>
                        <td>Riveting</td>
                        <td> <input type="checkbox" name="riveting_check"> </td>
                    </tr>
                    <tr>
                        <td>Drying</td>
                        <td> <input type="checkbox" name="drying_check"> </td>
                    </tr>
                    <tr>
                        <td>Reinforce Cutting</td>
                        <td> <input type="checkbox" name="reinforce_check"> </td>
                    </tr>
                    <tr>
                        <td>Printing</td>
                        <td> <input type="checkbox" name="printing_check"> </td>
                    </tr>
                    <tr>
                        <td>Edge-Inking</td>
                        <td> <input type="checkbox" name="edgeInking_check"> </td>
                    </tr>
                    <tr>
                        <td>Gusset Set Part</td>
                        <td> <input type="checkbox" name="guesset_check"> </td>
                    </tr>
                    <tr>
                        <td>Flap Set</td>
                        <td> <input type="checkbox" name="flap_set_check"> </td>
                    </tr>
                    <tr>
                        <td>Canvas Cutting</td>
                        <td> <input type="checkbox" name="canvas_check"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-3 col-12">
                <table class="table table-bordered">
                    <tr>
                        <td>Clicking</td>
                        <td> <input type="checkbox" name="clicking_check"></td>
                    </tr>
                    <tr>
                        <td>Finishing</td>
                        <td> <input type="checkbox" name="finishing_check"></td>
                    </tr>
                    <tr>
                        <td>Fitting-lasting</td>
                        <td> <input type="checkbox" name="fitting_check"></td>
                    </tr>
                    <tr>
                        <td>Skiving</td>
                        <td> <input type="checkbox" name="skiving_check"></td>
                    </tr>
                    <tr>
                        <td>Cleaning</td>
                        <td> <input type="checkbox" name="cleaning_check"></td>
                    </tr>
                    <tr>
                        <td>Lining Making</td>
                        <td> <input type="checkbox" name="lining_making_check"></td>
                    </tr>
                    <tr>
                        <td>ROTO</td>
                        <td> <input type="checkbox" name="roto_check"></td>
                    </tr>
                    <tr>
                        <td>Grip Handle</td>
                        <td> <input type="checkbox" name="grip_handle"> </td>
                    </tr>
                    <tr>
                        <td>Front Lining</td>
                        <td> <input type="checkbox" name="front_lining_check"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-3 col-12">
                <table class="table table-bordered">
                    <tr>
                        <td>Embossing</td>
                        <td> <input type="checkbox" name="embossing_check"> </td>
                    </tr>
                    <tr>
                        <td>Design</td>
                        <td> <input type="checkbox" name="design_check"></td>
                    </tr>
                    <tr>
                        <td>Spray Finish</td>
                        <td> <input type="checkbox" name="spray_check"></td>
                    </tr>
                    <tr>
                        <td>Embroidery</td>
                        <td> <input type="checkbox" name="embroidery_check"></td>
                    </tr>
                    <tr>
                        <td>Stuffing</td>
                        <td> <input type="checkbox" name="stuff_check"></td>
                    </tr>
                    <tr>
                        <td>Pasting</td>
                        <td> <input type="checkbox" name="pasting_check"></td>
                    </tr>
                    <tr>
                        <td>Front Part</td>
                        <td> <input type="checkbox" name="front_part_check"></td>
                    </tr>
                    <tr>
                        <td>Assembling</td>
                        <td> <input type="checkbox" name="assemble_check"></td>
                    </tr>
                    <tr>
                        <td>Back Lining</td>
                        <td> <input type="checkbox" name="back_lining_check"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-3 col-12">
                <table class="table table-bordered">
                    <tr>
                        <td>Lining Cutting</td>
                        <td> <input type="checkbox" name="lining_check"></td>
                    </tr>
                    <tr>
                        <td>Strap Making</td>
                        <td> <input type="checkbox" name="strap_making_check"></td>
                    </tr>
                    <tr>
                        <td>Washing</td>
                        <td> <input type="checkbox" name="wasing_check"></td>
                    </tr>
                    <tr>
                        <td>Adhesive Spray</td>
                        <td> <input type="checkbox" name="adhesive_check"></td>
                    </tr>
                    <tr>
                        <td>Laser Cut</td>
                        <td> <input type="checkbox" name="laserCut_check"></td>
                    </tr>
                    <tr>
                        <td>Gulchi-Khurpa</td>
                        <td> <input type="checkbox" name="gulchi_check"></td>
                    </tr>
                    <tr>
                        <td>Back Part</td>
                        <td> <input type="checkbox" name="back_part_check"></td>
                    </tr>
                    <tr>
                        <td>Tag Baking</td>
                        <td> <input type="checkbox" name="tag_baking_check"></td>
                    </tr>
                    <tr>
                        <td>Final Cutting</td>
                        <td> <input type="checkbox" name="final_cut_check"></td>
                    </tr>
                </table>
            </div>


        </div>

        <h6 class="m-0 font-weight-bold text-primary">
            Rate Details
        </h6>
        <div class="row my-3">
            <div class="col-md-4 col-12">
                <table class="table table-bordered">
                    <tr>
                        <td> Cutting Rate/Pcs</td>
                        <td>
                            <input type="text" name="cutting_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>
                    <tr>
                        <td>Skiving Rate/Pcs</td>
                        <td><input type="text" name="skiving_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Splitting Rate/Pcs</td>
                        <td>
                            <input type="text" name="splitting_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>
                    <tr>
                        <td>Clicking Rate/Pcs</td>
                        <td>
                            <input type="text" name="clicking_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>
                    <tr>
                        <td>Embossing Rate/Pcs</td>
                        <td><input type="text" name="embossing_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Linning Cutting Rate/Pcs</td>
                        <td><input type="text" name="lining_cut_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Stiching Rate/Pcs</td>
                        <td><input type="text" name="stiching_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Finishing Rate/Pc</td>

                        <td><input type="text" name="finishing_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Strap Making Rate/Pcs</td>

                        <td><input type="text" name="strap_making_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Riving & Eyeleting Rate/Pcs</td>
                        <td><input type="text" name="riving_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Embroidery Rate/Pcs</td>
                        <td><input type="text" name="embroidery_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Adhesive Spray Rate/Pcs</td>
                        <td>
                            <input type="text" name="adhesive_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>
                    <tr>
                        <td>Reinforce Cutting Rate/Pcs</td>
                        <td><input type="text" name="reinforce_rate" class="form-control" placeholder="0.0"></td>
                    </tr>

                    <tr>
                        <td>Design Rate</td>
                        <td><input type="text" name="design_rate" class="form-control" placeholder="0.0"></td>
                    </tr>

                </table>
            </div>
            <!-- ////////////////////////////////////////////////Second Part the Row//////////////////////// -->
            <div class="col-md-4 col-12">
                <table class="table table-bordered">

                    <tr>
                        <td>Cleaning Rate/Pcs</td>
                        <td><input type="text" name="cleaning_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Stuffing Rate/Pcs</td>
                        <td><input type="text" name="stuffing_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Fabrication Rate(Internal)</td>
                        <td><input type="text" name="fabrication_rate_internal" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Fabrication Rate(External)</td>
                        <td><input type="text" name="fabrication_rate_external" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Canvas Cutting Rate/Pcs</td>
                        <td><input type="text" name="canvas_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Laser Cutting Rate/Pcs</td>
                        <td>
                            <input type="text" name="laser_cutting_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>
                    <tr>
                        <td>Printing Rate/Pcs</td>
                        <td><input type="text" name="printing_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Lining Make Rate/Pcs</td>
                        <td>
                            <input type="text" name="lining_make_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>
                    <tr>
                        <td>Fitting-Lasting Rate/Pcs</td>
                        <td>
                            <input type="text" name="fitting_lasting_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>
                    <tr>
                        <td>Pasting Rate/Pcs</td>
                        <td><input type="text" name="pasting_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Spray-Finish Rate/Pcs</td>
                        <td><input type="text" name="spray_finish_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Gulchi-Khurpa Rate/Pcs</td>
                        <td><input type="text" name="gulchi_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Edge-Inking Rate/Pcs</td>
                        <td><input type="text" name="edge_inking_rate" class="form-control" placeholder="0.0"></td>
                    </tr>



                </table>
            </div>
            <!-- ////////////////////////////////////////////////third Part the Row//////////////////////// -->
            <div class="col-md-4 col-12">
                <table class="table table-bordered">
                    <tr>
                        <td>Washing Rate/Pc</td>
                        <td><input type="text" name="washing_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Assembling Rate/Pcs</td>
                        <td><input type="text" name="assemble_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Tag Making Rate/Pcs</td>
                        <td><input type="text" name="tap_making_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Flap Set Rate/Pcs</td>
                        <td><input type="text" name="flap_set_internal" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Front Lining Rate/Pcs</td>
                        <td><input type="text" name="front_lining_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Back Lining Rate/Pcs</td>
                        <td><input type="text" name="back_lining_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Final Cutting Rate/Pcs</td>
                        <td><input type="text" name="final_cutting_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Drying Rate/Pcs</td>
                        <td><input type="text" name="drying_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>ROTO Rate/Pcs</td>
                        <td><input type="text" name="roto_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Front Part Rate/Pcs</td>
                        <td><input type="text" name="front_part_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Back Part Rate/Pcs</td>
                        <td>
                            <input type="text" name="back_part_rate" class="form-control" placeholder="0.0">
                        </td>
                    </tr>

                    <tr>
                        <td>Gusset Set Part Rate/Pcs</td>
                        <td><input type="text" name="gusset_set_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                    <tr>
                        <td>Grip Handle Rate/Pcs</td>
                        <td><input type="text" name="grip_handle_rate" class="form-control" placeholder="0.0"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mb-5">

            <button type="submit" name="createStyle" class="btn btn-primary">Save</button>
        </div>
    </form>
</div>







<?php
include('includes/footer.php');
?>