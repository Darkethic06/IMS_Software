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

<!-- ---------------------------------------------Select Buyer Modal -------------------------------------------- -->
<div class="modal fade" id="selectBuyerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Leather</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <select class="form-select" id="selectBuyer">
                            <option value="Select Buyer" disabled selected>Select Buyer</option>
                            <?php
                            $buyer_fetch_query = "SELECT * FROM `buyer_db`;";
                            $buyer_fetch_result = mysqli_query($connect, $buyer_fetch_query);
                            while ($row =  mysqli_fetch_array($buyer_fetch_result)) {
                            ?>
                                <option value="<?php
                                                echo $row['buyer_code']
                                                ?>" class="form-control"><?php
                                                                            echo $row['name']
                                                                                . "(" .
                                                                                $row['buyer_code']
                                                                                . ")" ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="selectBuyerBtn" class="btn btn-primary" data-bs-dismiss="modal">Select</button>
                </div>
            </div>
        </div>
    </div>

<!-- ---------------------------------------------Select Buyer Modal End -------------------------------------------- -->




<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
        Create Order
    </h6>
</div>



<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectBuyerModal"> + Select Buyer</button>
        <div class="row my-5">
            <div class="mb-3 col-lg-6 col-md-6">
                <input type="text" class="form-control" placeholder="Buyer Name">
            </div>
            <div class="mb-3 col-lg-6 col-md-6">
                <input type="text" class="form-control" placeholder="Buyer Code">
            </div>
        </div>

        <div style="overflow-y: scroll; height:500px;" class="">
            <table class="table table-bordered my-5" id="leatherTable" width="100%" cellspacing="0">
                <tr>
                    <th>Style No</th>
                    <th>Style Name</th>
                    <th>QTY</th>
                    <th>Rate</th>
                    <th>Total Amount</th>
                </tr>
                <?php
                for ($i = 1; $i <= 20; $i++) :
                ?>
                    <tr>
                        <td><input type='text' class='form-control' placeholder="Item No" data-bs-toggle="modal" data-bs-target="#selectItemModal<?php echo $i; ?>" id="itemNo<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="Item Name" id="itemName<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="QTY" id="itemQty<?php echo $i; ?>" data-bs-toggle='modal' data-bs-target='#selectItemCalc<?php echo $i; ?>'></td>
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
        <button type="button" class="btn btn-primary my-5" id="save_costing">Save Costing</button>
</div>




<?php

include('includes/footer.php');
?>