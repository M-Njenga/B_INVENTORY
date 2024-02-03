<?php
require '../FPDF/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->setTextColor(252, 3, 3);
$pdf->Cell(200, 20, 'SALES REPORT', 0, 1, 'C');
$pdf->setLeftMargin(20);
$pdf->setTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, "Date:", 0, 0, 'C');
$pdf->Cell(20, 10, date("j-n-Y"), 0, 1, 'C');
// table column

$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(25, 10, 'EXPENSES', 1, 0, 'C');
$pdf->Cell(25, 10, 'DEBTS', 1, 0, 'C');
$pdf->Cell(40, 10, 'GROSS INCOME', 1, 0, 'C');
$pdf->Cell(30, 10, 'NET INCOME', 1, 0, 'C');
$pdf->Cell(25, 10, 'LOSS', 1, 0, 'C');
$pdf->Cell(25, 10, 'DATE', 1, 1, 'C');

// table rows
$pdf->SetFont('Arial', '', 12);
$con = new PDO('mysql:host=localhost;dbname=b_inventory', 'root', '');
$query = "SELECT * FROM SALES ";

$result = $con->prepare($query);
$result->execute();
if ($result->rowCount() != 0) {
  $i = 0;
  while ($sales = $result->fetch()) {
    $pdf->Cell(10, 10, ++$i, 1, 0, 'C');
    $pdf->Cell(25, 10, $sales['SALES_TT_EXPENSES'], 1, 0, 'C');
    $pdf->Cell(25, 10, $sales['SALES_TT_DEBTS'], 1, 0, 'C');
    $pdf->Cell(40, 10, $sales['SALES_GROSS'], 1, 0, 'C');
    $pdf->Cell(30, 10, $sales['SALES_NET'], 1, 0, 'C');
    $pdf->Cell(25, 10, $name, 1, 0, 'C');
    $pdf->Cell(25, 10, $sales['SALES_DATE'], 1, 1, 'C');
  }
  $pdf->SetTitle('Sales Report');
  $pdf->Output();
}
