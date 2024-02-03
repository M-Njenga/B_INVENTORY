<?php
require '../FPDF/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->setTextColor(252, 3, 3);
$pdf->Cell(200, 20, 'EXPENSES', 0, 1, 'C');
$pdf->setLeftMargin(30);
$pdf->setTextColor(0, 0, 0);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(10, 10, "Date:", 0, 0, 'C');
$pdf->Cell(20, 10, date("j-n-Y"), 0, 1, 'C');

// table column
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(40, 10, 'DESCRIPTION', 1, 0, 'C');
$pdf->Cell(40, 10, 'AMOUNT', 1, 0, 'C');
$pdf->Cell(40, 10, 'DATE', 1, 1, 'C');

// table rows
$con = new PDO('mysql:host=localhost;dbname=b_inventory', 'root', '');
$query = "SELECT * FROM EXPENSES ORDER BY EXPENSE_DATE ASC";
$result = $con->prepare($query);
$result->execute();
if ($result->rowCount() != 0) {
  $i = 0;
  while ($expense = $result->fetch()) {
    $pdf->Cell(10, 10, ++$i, 1, 0, 'C');
    $pdf->Cell(40, 10, $expense['EXPENSE_DESC'], 1, 0, 'C');
    $pdf->Cell(40, 10, $expense['EXPENSE_AMOUNT'], 1, 0, 'C');
    $pdf->Cell(40, 10, $expense['EXPENSE_DATE'], 1, 1, 'C');
  }
}
$pdf->SetTitle('Expenses Record');
$pdf->Output();
