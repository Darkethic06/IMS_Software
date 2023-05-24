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
      <h6 class="m-0 font-weight-bold text-primary">Our Styles
        <a href="create-style.php" class="btn btn-primary">
          Add Style
        </a>
      </h6>
    </div>

    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Style No</th>
              <th>Color</th>
              <th>Preview Image</th>
              <th colspan="3">Actions</th>
              
            </tr>
          </thead>
          <tbody>

            <?php
            $product_fetch_query = "SELECT * FROM `init_style_db` ";
            $item_fetch_result = mysqli_query($connect, $product_fetch_query);
            while ($row =  mysqli_fetch_array($item_fetch_result)) {
              echo "<tr>";
              echo "<td>" . $row['product_name'] . "</td>";
              echo "<td>" . $row['style_no'] . "</td>";
              echo "<td>" . $row['color'] . "</td>";


            ?>

              <td> <img src='product_images/<?php echo $row['preview_image']; ?>' height="150px" width="250px" alt=""></td>
              <td>
                <a href="<?php echo "view-style.php?product_id=".$row['product_id'] ?>" name="edit_btn" class="btn btn-success">View</a>
              </td>
              <td>
                <form action="" method="post">
                  <input type="hidden" name="delete_id" value="">
                  <button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button>
                </form>
              </td>
              <td><a href="<?php echo "create-costing.php?product_id=".$row['product_id'] ?>" name="costing_btn" class="btn btn-primary">Create Costing</a></td>
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