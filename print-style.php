<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
require('fpdf/fpdf.php');
include('config/config.php');



$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(0, 5, 'SIMA MERCHANDISE', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 5, '71, RAFI AHMED KIDWAI ROAD,', 0, 1, 'C');
$pdf->Cell(0, 5, 'KOLKATA - 700016', 0, 1, 'C');
$pdf->Cell(0, 5, 'GSTIN: 19ABIFS3025Q1ZL Ph. NO.: Email:', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Style Sheet', 0, 1, 'C');


$topGap = 50; // Adjust the value as needed

// Move the current position vertically
$pdf->SetY($topGap);

$pdf->SetFont('Arial', '', 12);
$id =  $_GET['style-id'];

$fetch_details = "SELECT * FROM `init_style_db` WHERE `product_id` = '$id'";
$result = mysqli_query($connect, $fetch_details);
$row =  mysqli_fetch_array($result);


$pdf->MultiCell(0, 20, 'Style Name: ' . $row['product_name'] . str_repeat(' ', 15) . 'Style No: ' . $row['style_no'] . str_repeat(' ', 15) . 'Color: ' . $row['color'] . str_repeat(' ', 15) .
    'No of Part: ' . $row['no_of_part'], 1, 'J');


$pdf->Cell(95, 10, 'Process', 1, 0, 'C');
$pdf->Cell(95, 10, 'Charges', 1, 1, 'C');

// Table rows
$data = json_decode($row["rate_details"], true);
foreach ($data as $key => $value) {
    $rmUnder = ucwords(str_replace("_", " ", $key));
    if ($value != 0) {


        $pdf->Cell(95, 10, $rmUnder, 1, 0, 'L');
        $pdf->Cell(95, 10, $value, 1, 1, 'R');
    }
}
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(95, 10, 'Total Labour Charges', 1, 0, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(95, 10, $row['labourCharges'], 1, 1, 'R');

$rmUnderString = '';
$data = json_decode($row["applicable_operation"], true);
foreach ($data as $key => $value) {
    $rmUnder = ucwords(str_replace("_check", " ", $key));
    if ($value != 0) {
        $rmUnderString .= $rmUnder . ', ';
    }
}

$rmUnderString = rtrim($rmUnderString, ', ');

// Output the string
$pdf->MultiCell(0, 10, "Process Assigned:" ."\n".$rmUnderString, 1, 'J');


$topGap =255; // Adjust the value as needed

// Move the current position vertically
$pdf->SetY($topGap);

$pdf->Cell(0, 5, "For SIMA MERCHANDISE", 0, 1, 'R');
$pdf->Cell(0, 5, "Authorised Signatory", 0, 1, 'R');




$pdf->Output($row['style_no'] . '-style-sheet.pdf', 'I');
