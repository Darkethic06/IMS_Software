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