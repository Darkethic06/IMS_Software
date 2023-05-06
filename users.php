<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("location: login.php");
  exit;
}
require_once('includes/header.php');
require_once('includes/navbar.php');
require_once('config/config.php');

$exists = false;
if (isset($_POST['registerbtn'])) {
  $name = mysqli_real_escape_string($connect, $_POST['name']);
  $phone = mysqli_real_escape_string($connect, $_POST['phone']);
  $password = mysqli_real_escape_string($connect, $_POST['password']);
  $role = mysqli_real_escape_string($connect, $_POST['role']);

  $check_user = "SELECT * FROM `user_db` WHERE `phone` = '$phone'";
  $check_user_result = mysqli_query($connect, $check_user);

  $numExistRows = mysqli_num_rows($check_user_result);
  if ($numExistRows > 0) {
    $exists = true;
  } else {
    $create_query = " INSERT INTO `user_db`(`username`, `phone`, `password`, `role`) VALUES ('$name','$phone','$password','$role')";
    if(mysqli_query($connect, $create_query)){
      echo "<script>alert('User Has been Created')</script>";
    }else{
      echo "<script>alert('Sorry!Couldn't Create a User')</script>";

    }
  }
}
?>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Username" name="name">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" class="form-control" id="phone" placeholder="Phone" name="phone">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          </div>
          <div class="mb-3">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-select">
              <option value="na" disabled selected>Select Role</option>
              <option value="Admin">Admin</option>
              <option value="Staff">Staff</option>
            </select>
          </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="registerbtn">Create User</button>
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
      <h6 class="m-0 font-weight-bold text-primary">Staff Profile
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
          Add Staff Profile
        </button>
      </h6>
    </div>

    <div class="card-body">

      <div class="table-responsive">
        <?php
        if ($exists == true) {
          echo '<h6 class="text-center" style="color:red;">Phone already registered</h>';
        }
        ?>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th> ID </th>
              <th>Name </th>
              <th>Phone Number </th>
              <th>Department</th>
              <th>EDIT </th>
              <th>DELETE </th>
            </tr>
          </thead>
          <tbody>

            <?php
            $fetch_query = "SELECT * FROM `user_db`";
            $fetch_result = mysqli_query($connect, $fetch_query);

            while ($row =  mysqli_fetch_array($fetch_result)) {
              echo "<tr>";
              echo "<td>" . $row['sl_no'] . "</td>";
              echo "<td>" . $row['username'] . "</td>";
              echo "<td>" . $row['phone'] . "</td>";
              echo "<td>" . $row['role'] . "</td>";

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