<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
require_once('includes/header.php');
require_once('includes/navbar.php');
require_once('config/config.php');
$buyer_exists = false;
if (isset($_POST['createBuyer'])) {
  $code = mysqli_real_escape_string($connect, $_POST['buyer_code']);
  $name = mysqli_real_escape_string($connect, $_POST['name']);



  $check_buyer = "SELECT * FROM `buyer` WHERE `buyer_code` = '$code'";
  $check_buyer_result = mysqli_query($connect, $check_buyer);

  $buyerExistRows = mysqli_num_rows($check_buyer_result);
  if ($buyerExistRows > 0) {
    $buyer_exists = true;
  } else {
    $buyer_create_query = "INSERT INTO `buyer`(`buyer_code`,`name`) VALUES ('$code','$name')";
    mysqli_query($connect, $buyer_create_query);
  }
}
?>



<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Buyer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="modal-body">
          <?php
          if ($buyer_exists == true) {
            echo '<h6 class="alert-danger">Product already has been uploaded</h>';
          }
          ?>
          <div class="form-group">
            <label>Buyer Code</label>
            <input type="text" name="buyer_code" class="form-control" placeholder="Buyer Code">
          </div>
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Buyer Name">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" name="createBuyer" class="btn btn-primary">Save</button>
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
      <h6 class="m-0 font-weight-bold text-primary">All Buyers
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addadminprofile">
          Add Buyer
        </button>
      </h6>
    </div>

    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Buyer Name</th>
              <th>Buyer Code</th>
              <th colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $buyer_fetch_query = "SELECT * FROM `buyer`";
            $buyer_fetch_result = mysqli_query($connect, $buyer_fetch_query);


            while ($row =  mysqli_fetch_array($buyer_fetch_result)) {
              echo "<tr>";
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>" . $row['buyer_code'] . "</td>";
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