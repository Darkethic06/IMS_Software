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
                            <select class="form-select" id="selectedStyle<?php echo $j; ?>">
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
                        <button class="btn btn-primary" data-bs-dismiss="modal" onclick="selectProduct(<?php echo $j; ?>)">Select</button>
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
        Create Order
    </h6>
</div>



<div class="container">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectBuyerModal"> + Select Buyer</button>
        <div class="row my-5">
            <div class="mb-3 col-lg-6 col-md-6">
                <input type="text" class="form-control" placeholder="Buyer Name" id="showBuyerName">
            </div>
            <div class="mb-3 col-lg-6 col-md-6">
                <input type="text" class="form-control" placeholder="Buyer Code" id="showBuyerCode">
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
                        <td><input type='text' class='form-control' placeholder="Style No" data-bs-toggle="modal"
                         data-bs-target="#selectStyleModal<?php echo $i; ?>" id="styleNo<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="Style Name" id="styleName<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="QTY" id="styleQty<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="UOM" id="styleUom<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="Rate" id="styleRate<?php echo $i; ?>"></td>
                        <td><input type='text' class='form-control' placeholder="Amount" id="styleAmount<?php echo $i; ?>" value="0"></td>
                    </tr>
                <?php
                endfor;
                ?>
            </table>
        </div>

        <div class="d-flex justify-content-end">
            <button class="my-3 btn btn-primary" id="calcOrderBtn">Submit</button>
        </div>
        
        <button type="button" class="btn btn-primary my-5" id="saveBuyerOrder">Create Order</button>
</div>




<?php

include('includes/footer.php');
?>