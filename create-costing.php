<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
include('includes/header.php');
include('includes/navbar.php');
include('config/config.php');



if (isset($_POST['saveCosting'])) {

    $leatherNo="";
    $leatherName = "";
    $leatherQty="";
    $leatherUom="";
    $leatherRate="";
    $leatherAmount="";
    $primeCost ="";
    $labouCharge="";
    $packCharge= "";
    $grossCost = "";
    $overheadCost = "";
    $handlingCharges = "";
    $insureCharge = "";
    

}



$id =  $_GET['product_id'];

$fetch_style = "SELECT * FROM `init_style_db` WHERE `product_id` = '$id'";
$Styleresult = mysqli_query($connect, $fetch_style);
while ($styleRow =  mysqli_fetch_assoc($Styleresult)) {

?>



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
                                <option value="<?php
                                                echo $row['Item_No']
                                                ?>" class="form-control"><?php
                                                                            echo $row['Item_Name']
                                                                                . "(" .
                                                                                $row['Item_No']
                                                                                . ")" ?></option>
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


    <!-- -----------------------------------------Select Item Modal----------------------------------------------- -->

    <?php
    for ($j = 1; $j <= 20; $j++) :
    ?>
        <div class="modal fade" id="selectItemModal<?php echo $j; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Leather</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <select class="form-select" id="select_item<?php echo $j; ?>">
                                <option value="NA" disabled selected>Select Item</option>
                                <?php
                                $item_fetch_query = "SELECT * FROM `items_db` WHERE `item_type` IN ('Linning', 'Puller & Zipper', 'Backing', 'Adhesive','Weaving Tape','Fittings','Packing','Thread');";
                                $item_fetch_result = mysqli_query($connect, $item_fetch_query);
                                while ($row =  mysqli_fetch_array($item_fetch_result)) {
                                ?>
                                    <option value="<?php
                                                    echo $row['Item_No']
                                                    ?>" class="form-control"><?php
                                                                                echo $row['Item_Name']
                                                                                    . "(" .
                                                                                    $row['Item_No']
                                                                                    . ")" ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" data-bs-dismiss="modal" onclick="selectItem(<?php echo $j; ?>)">Select</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
    endfor;
    ?>


    <!-- ---------------------------------------------Select Item Modal -------------------------------------------- -->






    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Create Costing
        </h6>
    </div>



    <div class="container">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="row ">
                <div class="mb-3 col-lg-4 col-md-4">
                    <label class="form-label">Style No</label>
                    <input type="text" id="show_style_no" name="style_no" class="form-control" placeholder="Style No" value="<?php echo $styleRow['style_no']; ?>">
                </div>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectLeatherModal"> + Add Leather</button>

            <table class="table table-bordered my-3" id="leatherTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Leather Code</th>
                        <th>Leather Name</th>
                        <th>QTY</th>
                        <th>UOM</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tr>
                    <td><input type='text' class='form-control' placeholder='Leather No' id="leather_no" name="leatherNo"></td>
                    <td><input type='text' class='form-control' placeholder='Leather Name' id="leather_name" name="leatherName"></td>
                    <td><input type='text' class='form-control' id='leather_qty' placeholder='QTY' data-bs-toggle='modal' data-bs-target='#selectLeatherCalc' name="leatherQty"></td>
                    <td><input type='text' class='form-control' placeholder="UOM" id="leather_uom" name="leatherUOM"></td>
                    <td><input type='text' class='form-control' placeholder="Rate" id='leather_rate' name="leatherRate"></td>
                    <td><input type='text' class='form-control' placeholder='Amount' id='leather_amount' value="0" name="leatherAmount"></td>
                </tr>
            </table>
            <div style="overflow-y: scroll; height:300px;" class="">
                <table class="table table-bordered my-5" id="leatherTable" width="100%" cellspacing="0">
                    <tr>
                        <th>Item No</th>
                        <th>Item Name</th>
                        <th>QTY</th>
                        <th>UOM</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                    <?php
                    for ($i = 1; $i <= 20; $i++) :
                    ?>
                        <tr>
                            <td><input type='text' class='form-control' placeholder="Item No" data-bs-toggle="modal" data-bs-target="#selectItemModal<?php echo $i; ?>" id="itemNo<?php echo $i; ?>"></td>
                            <td><input type='text' class='form-control' placeholder="Item Name" id="itemName<?php echo $i; ?>"></td>
                            <!-- <td><input type='text' class='form-control' placeholder="QTY" id="itemQty<?php echo $i; ?>" data-bs-toggle='modal' data-bs-target='#selectItemCalc<?php echo $i; ?>' onclick="modalTo(<?php echo $i; ?>)"></td> -->
                            <td><input type='text' class='form-control' placeholder="QTY" id="itemQty<?php echo $i; ?>"  onclick="modalToggle(<?php echo $i; ?>)"></td>
                            <td><input type='text' class='form-control' placeholder="UOM" id="itemUom<?php echo $i; ?>"></td>
                            <td><input type='text' class='form-control' placeholder="Rate" id="itemRate<?php echo $i; ?>"></td>
                            <td><input type='text' class='form-control' placeholder="Amount" id="itemAmount<?php echo $i; ?>" value="0"></td>
                        </tr>
                    <?php
                    endfor;
                    ?>
                </table>
            </div>

            <div class="d-flex justify-content-end">
                <button class="my-3 btn btn-primary" id="primeCostCalcBtn">Calcutate Prime Cost</button>
            </div>
            <table class="table table-bordered my-5 hide" width="100%" cellspacing="0" id="costSection">
                <tr>
                    <td>Prime Cost</td>
                    <td colspan="3"></td>
                    <td><input type="text" class="form-control" id="prime_cost" value="0"></td>
                </tr>
                <tr>
                    <td>Labour Charges</td>
                    <td colspan="3"></td>
                    <td><input type="text" class="form-control" id="labour_charges" value="<?php echo $styleRow['labourCharges']; ?>"></td>
                </tr>
                <tr>
                    <td>Packaging Charges</td>
                    <td colspan="3"></td>
                    <td><input type="text" class="form-control" id="pack_charges" value="0"></td>
                </tr>
                <tr>
                    <td>Gross Cost</td>
                    <td colspan="2"></td>
                    <td> <button class="btn btn-primary" id="grossCostBtn">Calculate Gross Cost</button> </td>
                    <td><input type="text" class="form-control" id="gross_cost" value="0"></td>
                </tr>

                <tr>
                    <td>Overhead Cost(in %)</td>
                    <td><input type="text" class="form-control" id="overhead_percentage"></td>
                    <td colspan="2">in Value</td>
                    <td><input type="text" class="form-control" id="overhead_value" value="0"></td>
                </tr>
                <tr>
                    <td>Handling Charges(in %)</label></td>
                    <td><input type="text" class="form-control" id="handling_percentage"></td>
                    <td colspan="2">in Value</td>
                    <td><input type="text" class="form-control" id="handling_value" value="0"></td>
                </tr>
                <tr>
                    <td>Insurance Charges(in %)</td>
                    <td><input type="text" class="form-control" id="insure_percentage" onkeyup="calcInsurance()"></td>
                    <td colspan="2">in Value</td>
                    <td><input type="text" class="form-control" id="insure_value" value="0"></td>
                </tr>
                <tr>
                    <td>Bank & Misc. Charges(in %)</td>
                    <td><input type="text" class="form-control" id="bank_percentage" onkeyup="calcBank()"></td>
                    <td colspan="2">in Value</td>
                    <td><input type="text" class="form-control" id="bank_value" value="0"></td>
                </tr>
                <tr>
                    <td>Freight Amount(in %)</td>
                    <td><input type="text" class="form-control" id="freight_percentage" onkeyup="calcFreight()"></td>
                    <td colspan="2">in Value</td>
                    <td><input type="text" class="form-control" id="freight_value" value="0"></td>
                </tr>
                <tr>
                    <td>Add Profit(in %)</td>
                    <td><input type="text" class="form-control" id="profit_percentage" onkeyup="clacProfit()"></td>
                    <td colspan="2">in Value</td>
                    <td><input type="text" class="form-control" id="profit_value" value="0"></td>
                </tr>
                <tr>
                    <td colspan="1"><strong>Net Cost</strong></td>
                    <td><button class="btn btn-primary" id="calcTotalCostBtn">Calculate Net Cost</button></td>
                    <td colspan="2"><strong>Total</strong></td>
                    <td colspan="2"><input type="text" class="form-control" id="netCost" value="0"></td>
                </tr>
                <tr>
                    <td colspan="1"><strong>Price in Conv. Rate</strong></td>
                    <td><select class="form-select" id="convCur" onchange="selectConvCur()">
                            <option value="NA" disabled selected>Select Currency</option>
                            <option value="USD">USD</option>
                            <option value="AUD">AUD</option>
                            <option value="EURO">EURO</option>
                            <option value="SEK">SEK</option>
                        </select></td>
                    <td><input type="text" class="form-control" value="0" id="convRate"></td>
                    <td><button class="btn btn-primary" id="convBtn">Calculate Conv.</button> <span id="slectedConvCur"></span> </td>
                    <td><input type="text" class="form-control" id="convPrice"></td>
                </tr>
            </table>
            <button type="button" class="btn btn-primary my-5" id="save_costing" name="saveCosting">Save Costing</button>
        </form>
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
                    <!-- <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Wastage(%)</label>
                            <input type="text" class="form-control" id="leather_wastage">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Total (In sqft)</label>
                            <input type="text" class="form-control" id="final_leather">
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="selectLeatherBtn" class="btn btn-primary" data-bs-dismiss="modal">Select</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ---------------------------------------------Calculate Item Modal -------------------------------------------- -->




    <?php
    for ($k = 1; $k <= 20; $k++) :
    ?>
        <div class="modal fade" id="selectItemCalc<?php echo $k; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                <th>Length</th>
                                <th>Width</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <td> <input type="text" class="form-control" id="item_length<?php echo $k; ?> showTd" value="1"></td>
                                <td> <input type="text" class="form-control" id="item_width<?php echo $k; ?> showTd" value="1"></td>
                                <td> <input type="text" class="form-control" id="item_qty<?php echo $k; ?>" onkeyup="calculateItem(<?php echo $k; ?>)" value="1"></td>
                                <td> <input type="text" class="form-control" id="item_total<?php echo $k; ?>" value="1"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="calcItemBtn" class="btn btn-primary" data-bs-dismiss="modal" onclick="getItemQty(<?php echo $k; ?>)">Select</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
    endfor;
    ?>

<?php
    for ($l = 1; $l <= 20; $l++) :
    ?>
        <div class="modal fade" id="selectItemCalcP<?php echo $l; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Quantity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tr>
                                
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                            <tr>
                                <input type="hidden" class="form-control" id="item_length<?php echo $k; ?> showTd" value="1" >
                                <input type="hidden" class="form-control" id="item_width<?php echo $k; ?> showTd" value="1">
                                <td> <input type="text" class="form-control" id="item_qty<?php echo $k; ?>" onkeyup="calculateItem(<?php echo $k; ?>)" value="1"></td>
                                <td> <input type="text" class="form-control" id="item_total<?php echo $k; ?>" value="1"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="calcItemBtn" class="btn btn-primary" data-bs-dismiss="modal" onclick="getItemQty(<?php echo $l; ?>)">Select</button>
                    </div>
                </div>
            </div>
        </div>

    <?php
    endfor;
    ?>
    <!-- //////////////////////////////////////////////Scrollable div here ------------------------------>

<?php
}
include('includes/footer.php');
?>