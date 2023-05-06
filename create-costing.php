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
<!-- =---------------------- -->
<div class="modal fade" id="selectStyleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Style</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Select Style</label>
                    <Select class="form-select" id="style_no">
                        <?php
                        $product_fetch_query = "SELECT * FROM `init_style_db` ";
                        $item_fetch_result = mysqli_query($connect, $product_fetch_query);
                        while ($row =  mysqli_fetch_array($item_fetch_result)) {
                        ?>
                            <option value="<?php echo $row['style_no'] ?>"><?php echo $row['product_name'] . "(" . $row['style_no'] . ")" ?></option>
                        <?php
                        }
                        ?>
                    </Select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button name="selectStyle" id="selectStyle" class="btn btn-primary" onclick="selectStyle()" data-bs-dismiss="modal">Save</button>
            </div>

        </div>
    </div>
</div>


<!-- ------------------------------------------------------------------------------ -->


<div class="modal fade" id="selectLeatherModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Leather</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <select class="form-select" id="select_leather_no">
                        <option value="Select Leather" disabled selected>Select Leather</option>
                        <?php
                        $item_fetch_query = "SELECT * FROM `items_db` WHERE `item_type` = 'Leather';";
                        $item_fetch_result = mysqli_query($connect, $item_fetch_query);
                        while ($row =  mysqli_fetch_array($item_fetch_result)) {
                        ?>
                            <option value="<?php echo $row['Item_No'] ?>" class="form-control"><?php echo $row['Item_Name'] . "(" . $row['Item_No'] . ")" ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="selectLeather" class="btn btn-primary" data-bs-dismiss="modal">Select</button>
            </div>
        </div>
    </div>
</div>

<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
        Create Costing
    </h6>
</div>



<div class="container">
    <h5 class="m-3">Add Details</h5>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="row ">
            <div class="mb-3 col-lg-4 col-md-4">
                <label class="form-label">Style No</label>
                <input type="text" id="show_style_no" name="style_no" class="form-control" placeholder="Style No" data-bs-toggle="modal" data-bs-target="#selectStyleModal">
            </div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectLeatherModal"> + Add Leather</button>

        <table class="table table-bordered m-3" id="leatherTable" width="100%" cellspacing="0">
        </table>
        <div style="overflow-y: scroll; height:300px;">
            <table class="table table-bordered m-3" id="leatherTable" width="100%" cellspacing="0">
                <?php for ($i = 1; $i <= 20; $i++) : ?>
                    <tr>
                        <td><input type='text' class='form-control'></td>
                        <td><input type='text' class='form-control'></td>
                        <td><input type='text' class='form-control'></td>
                        <td><input type='text' class='form-control'></td>
                        <td><input type='text' class='form-control'></td>
                        <td><input type='text' class='form-control'></td>
                        <td><input type='text' class='form-control'></td>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>

        <table class="table table-bordered my-3" width="100%" cellspacing="0">
            <tr>
                <td><label class="form-label">Prime Cost</label></td>
                <td><input type="text" class="form-control" id="prime_cost"></td>
                <td><label class="form-label">Packaging Charges(in %)</label></td>
                <td><input type="text" class="form-control" id="prime_cost_percentage"></td>
                <td><label class="form-label">(in Value)</label></td>
                <td><input type="text" class="form-control" id="prime_cost_value"></td>
            </tr>
            <tr>
                <td><label class="form-label">Labour Charges</label></td>
                <td><input type="text" class="form-control" id="labour_charges"></td>
                <td><label class="form-label">Overhead Cost(in %)</label></td>
                <td><input type="text" class="form-control" id="overhead_percentage"></td>
                <td><label class="form-label">(in Value)</label></td>
                <td><input type="text" class="form-control" id="overhead_in_value"></td>
            </tr>
            <tr>
                <td><label class="form-label">Gross Cost</label></td>
                <td><input type="text" class="form-control" id="gross_cost"></td>
                <td><label class="form-label">Handling Charges(in %)</label></td>
                <td><input type="text" class="form-control" id="handling_percentage"></td>
                <td><label class="form-label">(in Value)</label></td>
                <td><input type="text" class="form-control" id="handling_value"></td>
            </tr>
            <tr>
                <td><label class="form-label">Insurance Charges</label></td>
                <td><input type="text" class="form-control"></td>
                <td><label class="form-label">Bank & Misc. Charges(in %)</label></td>
                <td><input type="text" class="form-control"></td>
                <td><label class="form-label">Freight</label></td>
                <td><input type="text" class="form-control"></td>
            </tr>
            <tr>
                <td><label class="form-label">Add Profit</label></td>
                <td><input type="text" class="form-control"></td>
                <td><strong><label class="form-label">Net Cost</label></strong></td>
                <td colspan="3"><input type="text" class="form-control"></td>
            </tr>
        </table>
        <button type="button" class="btn btn-primary">Save Costing</button>
</div>



<!-- -------------------------Calculate Leather Modal---------------------------- -->

<div class="modal fade" id="selectLeatherCalc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tr>
                        <th>Length(In ft)</th>
                        <th>Width(In ft)</th>
                        <th>No. of Part</th>
                        <th>Area(In sqft)</th>
                    </tr>
                    <tr>
                        <td> <input type="text" class="form-control" id="leather_length"></td>
                        <td> <input type="text" class="form-control" id="leather_width"></td>
                        <td> <input type="text" class="form-control" id="leather_part"></td>
                        <td> <input type="text" class="form-control" id="leather_total"></td>
                    </tr>
                </table>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Wastage(%)</label>
                        <input type="text" class="form-control" id="leather_wastage">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Total (In sqft)</label>
                        <input type="text" class="form-control" id="final_leather">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="selectLeatherBtn" class="btn btn-primary" data-bs-dismiss="modal">Select</button>
            </div>
        </div>
    </div>
</div>



<!-- //////////////////////////////////////////////Scrollable div here -->

<?php
include('includes/footer.php');
?>