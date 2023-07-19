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


?>

<!-- ---------------------------------------------Select Buyer Modal -------------------------------------------- -->
<div class="modal fade" id="selectBuyerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Supllier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <select class="form-select" id="selectBuyer">
                        <option value="Select Buyer" disabled selected>Select Supplier</option>
                        <?php
                        $buyer_fetch_query = "SELECT * FROM `supplier_db`;";
                        $buyer_fetch_result = mysqli_query($connect, $buyer_fetch_query);
                        while ($row =  mysqli_fetch_array($buyer_fetch_result)) {
                        ?>
                            <option value="<?php
                                            echo $row['supplier_code']
                                            ?>" class="form-control"><?php
                                                                        echo $row['name']
                                                                            . "(" .
                                                                            $row['supplier_code']
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

<!-- ---------------------------------------------Select Style Modal Start -------------------------------------------- -->

<?php
for ($j = 1; $j <= 20; $j++) :
?>
    <div class="modal fade" id="selectStyleModal<?php echo $j; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Style</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <select class="form-select" id="selectedItem<?php echo $j; ?>">
                            <option value="NA" disabled selected>Select Item</option>
                            <?php
                            $item_fetch_query = "SELECT * FROM `costing_db` ;";
                            $item_fetch_result = mysqli_query($connect, $item_fetch_query);
                            while ($row =  mysqli_fetch_array($item_fetch_result)) {
                            ?>
                                <option value="<?php
                                                echo $row['style_no']
                                                ?>" class="form-control"><?php
                                                                            echo $row['productName']
                                                                                . "(" .
                                                                                $row['style_no']
                                                                                . ")" ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" data-bs-dismiss="modal" onclick="selectProductBo(<?php echo $j; ?>)">Select</button>
                </div>
            </div>
        </div>
    </div>

<?php
endfor;
?>

<!-- ---------------------------------------------Select Style Modal End -------------------------------------------- -->


<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
        Create Purchase Order
    </h6>
</div>



<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectBuyerModal"> + Select Supplier</button>
        <div class="row my-5">
            <div class="mb-3 col-4">
                <input type="text" class="form-control" placeholder="Supplier Name" id="showBuyerName">
            </div>
            <div class="mb-3 col-4">
                <input type="text" class="form-control" placeholder="Supplier Code" id="showBuyerCode">
            </div>
            <div class="mb-3 col-4">
                <input type="text" class="form-control" readonly value="<?php echo createPoOrderNo();  ?>">
            </div>
        </div>

        <div style="overflow-y: scroll; height:500px;" class="">
            <table class="table table-bordered my-5" id="leatherTable" width="100%" cellspacing="0">
                <tr>
                    <th>Style No</th>
                    <th>Style Name</th>
                    <th>QTY</th>
                    <th>UOM</th>
                    <th>Price</th>
                    <th>Total Amount</th>
                </tr>
                <?php
                for ($i = 1; $i <= 20; $i++) :
                ?>
                    <tr>
                        <td><input type='text' class='form-control' placeholder="Style No" data-bs-toggle="modal" data-bs-target="#selectStyleModal<?php echo $i; ?>" id="styleNo<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="Style Name" id="styleName<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="QTY" id="styleQtyBo<?php echo $i; ?>" onkeyup="calcBoAmount(<?php echo $i; ?>)"></td>
                        <td><input type='text' class='form-control' placeholder="UOM" id="styleUom<?php echo $i; ?>" value="PCS" readonly></td>
                        <td><input type='text' class='form-control' placeholder="Rate" id="stylePriceBO<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="Amount" id="styleAmountBo<?php echo $i; ?>" value="0"></td>
                    </tr>
                <?php
                endfor;
                ?>
            </table>
        </div>
        
        <button type="submit" class="btn btn-primary my-5" id="createBoOrder">Create Order</button>
    </form>
</div>




<?php

include('includes/footer.php');
?>