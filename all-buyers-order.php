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

<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">All Order
        <a href="create-bo.php" class="btn btn-primary">
          Add Order
        </a>
      </h6>
    </div>

    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Order No</th>
              <th>Buyer Name</th>
              <th>Buyer Code</th>
              <th>Total Quantity</th>
              <th>Total Amount</th>
              <th>Actions</th>
              
            </tr>
          </thead>
          <tbody>

            <?php
            $boOrder_fetch_query = "SELECT * FROM `buyersorder_db` ";
            $boOrder_fetch_result = mysqli_query($connect, $boOrder_fetch_query);
            while ($row =  mysqli_fetch_array($boOrder_fetch_result)) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . $row['buyersName'] . "</td>";
              echo "<td>" . $row['buyersCode'] . "</td>";
              echo "<td> 100</td>";
              echo "<td> 100</td>";
              
            ?>

              
                  
             <td><a href="<?php echo "view-costing.php?style_no=".$row['style_no'] ?>" name="edit_btn" class="btn btn-success">View</a></td>
              <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="">
                  <button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button>
                </form>
              </td>
              <td><a href="<?php echo "print-costing.php?style_no=".$row['id'] ?>" target="_blank" class="btn btn-primary">Print Costing Sheet</a></td>
              </tr>
            <?php
            }

            ?>

          </tbody>
        </table>

      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php
include('includes/footer.php');
?>