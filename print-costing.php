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
$pdf->SetFont('Arial', 'B', 14);

$pdf->Cell(0, 5, 'SIMA MERCHANDISE', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, '71, RAFI AHMED KIDWAI ROAD,', 0, 1, 'C');
$pdf->Cell(0, 5, 'KOLKATA - 700016', 0, 1, 'C');
$pdf->Cell(0, 5, 'GSTIN: 19ABIFS3025Q1ZL Ph. NO.: Email:', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 8, 'COST SHEET', 0, 1, 'C');


$topGap = 38; // Adjust the value as needed

// Move the current position vertically
$pdf->SetY($topGap);

$pdf->SetFont('Arial', '', 10);
$style_no =  $_GET['style_no'];

$fetch_costing = "SELECT * FROM `costing_db` WHERE `id` = '$style_no'";
$costingResult = mysqli_query($connect, $fetch_costing);
$row =  mysqli_fetch_array($costingResult);






$pdf->MultiCell(0, 15, "Style No: " . $row['style_no'] . str_repeat(" ", 15) . "No. of Part: ". $row['noOfPart'] , 1, 'J');


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(25, 6, 'Item Code', 1, 0, 'C');
$pdf->Cell(85, 6, 'Item Name', 1, 0, 'C');
$pdf->Cell(23, 6, 'Quantity', 1, 0, 'C');
$pdf->Cell(17, 6, 'UOM', 1, 0, 'C');
$pdf->Cell(20, 6, 'Rate', 1, 0, 'C');
$pdf->Cell(20, 6, 'Amount', 1, 0, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Ln();
$pdf->Cell(25, 6, $row['leatherNo'], 1, 0, 'L');
$pdf->Cell(85, 6, $row['leatherName'], 1, 0, 'L');
$pdf->Cell(23, 6, $row['leatherQty'], 1, 0, 'L');
$pdf->Cell(17, 6, $row['leatherUom'], 1, 0, 'L');
$pdf->Cell(20, 6, $row['leatherRate'], 1, 0, 'L');
$pdf->Cell(20, 6, $row['leatherAmount'], 1, 0, 'L');
// Table rows
$data = json_decode($row["item_Details"], true);
foreach ($data as $item) {
    $pdf->Ln();
    $pdf->Cell(25, 6, $item['itemNo'], 1, 0, 'L');
    $pdf->Cell(85, 6, $item['itemName'], 1, 0, 'L');
    $pdf->Cell(23, 6, $item['qty'], 1, 0, 'L');
    $pdf->Cell(17, 6, $item['uom'], 1, 0, 'L');
    $pdf->Cell(20, 6, $item['rate'], 1, 0, 'L');
    $pdf->Cell(20, 6, $item['amount'], 1, 0, 'L');
}
$pdf->Ln();
$pdf->Cell(25, 6, "", 1, 0, 'L');

$pdf->Cell(85, 6, "Prime Cost", 1, 0, 'R');
$pdf->Cell(23, 6, "", 1, 0, 'L');
$pdf->Cell(17, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, $row['primeCost'], 1, 0, 'L');


// -------------------------------
$pdf->SetFont('Arial', '', 10);
$pdf->Ln();
$pdf->Cell(25, 6, "", 1, 0, 'L');
$pdf->Cell(85, 6, "Labour Charges", 1, 0, 'R');
$pdf->Cell(23, 6, "", 1, 0, 'L');
$pdf->Cell(17, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, $row['labourCharges'], 1, 0, 'L');


// -------------------------------------------------

$pdf->Ln();
$pdf->Cell(25, 6, "", 1, 0, 'L');
$pdf->Cell(85, 6, "Packaging Charges", 1, 0, 'R');
$pdf->Cell(23, 6, "", 1, 0, 'L');
$pdf->Cell(17, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, $row['packCharges'], 1, 0, 'L');

// --------------------------------------------

$pdf->Ln();
$pdf->Cell(25, 6, "", 1, 0, 'L');
$pdf->Cell(85, 6, "Gross Cost", 1, 0, 'R');
$pdf->Cell(60, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, $row['grossCost'], 1, 0, 'L');


// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Overhead Cost", 1, 0, 'L');
$pdf->Cell(65, 6, "@ ". $row['overPer']. " %", 1, 0, 'R');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "Rs.", 1, 0, 'R');
$pdf->Cell(20, 6, $row['overCost'], 1, 0, 'L');


// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Handling Charges", 1, 0, 'L');
$pdf->Cell(65, 6, "@ ". $row['handlingPer']. " %", 1, 0, 'R');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "Rs.", 1, 0, 'R');
$pdf->Cell(20, 6, $row['handlingCharges'], 1, 0, 'L');


// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Insurance", 1, 0, 'L');
$pdf->Cell(65, 6, "@ ". $row['handlingPer']. " %", 1, 0, 'R');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "Rs.", 1, 0, 'R');
$pdf->Cell(20, 6, $row['handlingCharges'], 1, 0, 'L');


// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Bank & Misc.", 1, 0, 'L');
$pdf->Cell(65, 6, "@ ". $row['handlingPer']. " %", 1, 0, 'R');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "Rs.", 1, 0, 'R');
$pdf->Cell(20, 6, $row['handlingCharges'], 1, 0, 'L');


// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Freight Cost", 1, 0, 'L');
$pdf->Cell(65, 6, "@ ". $row['handlingPer']. " %", 1, 0, 'R');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "Rs.", 1, 0, 'R');
$pdf->Cell(20, 6, $row['handlingCharges'], 1, 0, 'L');


// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Add Profit", 1, 0, 'L');
$pdf->Cell(65, 6, "@ ". $row['handlingPer']. " %", 1, 0, 'R');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, "Rs.", 1, 0, 'R');
$pdf->Cell(20, 6, $row['handlingCharges'], 1, 0, 'L');



// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Net Price", 1, 0, 'L');
$pdf->Cell(105, 6, "", 1, 0, 'R');
$pdf->Cell(20, 6, "Rs.", 1, 0, 'R');
$pdf->Cell(20, 6, $row['netCost'], 1, 0, 'L');



// ------------------------------------------
$pdf->Ln();
$pdf->Cell(45, 6, "Price In Conv. Rate", 1, 0, 'L');
$pdf->Cell(65, 6, "@ Rs.". $row['convRate'], 1, 0, 'R');
$pdf->Cell(40, 6, "", 1, 0, 'L');
$pdf->Cell(20, 6, $row['convCurency'] , 1, 0, 'R');
$pdf->Cell(20, 6, $row['convPrice'], 1, 0, 'L');

// ------------------------------------------


$pdf->Ln();

$current_date = date("H:i:s d-m-Y");
// echo $current_date;

$pdf->Cell(0,10, "Cost Sheet Prepared On " . $current_date, 0, 0, 'L');








$pdf->Output('costsheet' . $row['style_no'] . 'pdf', 'I');
