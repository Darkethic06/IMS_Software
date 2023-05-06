<?php 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
  }
require_once('includes/header.php');
require_once('includes/navbar.php');
require_once ('config/config.php');
?>
<h1>Dashboard Here</h1>


<?php
require_once('includes/footer.php');
?>