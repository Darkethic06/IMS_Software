<?php
require_once('includes/header.php');
require_once('config/config.php');

$login = false;
$showError = false;
if (isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($connect,$_POST["username"]);
    $password = mysqli_real_escape_string($connect,$_POST["password"]);
    $login_query = "SELECT * FROM `user_db` WHERE `username` = '$username' AND `password` = '$password';";
    $result = mysqli_query($connect, $login_query);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: index.php");
    } else {
        $showError = true;
    }
}
?>

<div class="loginContainer">
    <h2 class="text-center">SIMA INTERNATIONAL</h2>
    <h4 class="text-center mb-5">Inventory Management Software</h4>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Username</label>
            <input type="text" class="form-control" id="email" aria-describedby="emailHelp" name="username" placeholder="Username">
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Password</label>
            <input type="password" class="form-control" id="pass" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="login_btn">Submit</button>
    </form>
    <?php
    if ($showError == true) {
        echo '<h6 class="text-center">Phone or Password does not match</h6>';
    }
    ?>

</div>



<?php
require_once('includes/footer.php');
?>