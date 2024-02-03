<?php
require '../FPDF/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->setTextColor(252, 3, 3);
$pdf->Cell(200, 20, 'DAILY REPORT', 0, 1, 'C');
$pdf->setLeftMargin(40);
$pdf->setTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 10, "Date:", 0, 0, 'C');
$pdf->Cell(15, 10, date("j-n-Y"), 0, 1, 'C');



// table rows
$pdf->SetFont('Arial', 'B', 8);
$con = new PDO('mysql:host=localhost;dbname=b_inventory', 'root', '');

if (isset($_GET['sales_id'])) {
  $id = $_GET['sales_id'];



  // table column
  $pdf->Cell(2, 10, 'Expense', 0, 0, 'C');
  $pdf->Cell(40, 10, 'Amount', 0, 1, 'C');


  $query = "SELECT * FROM SALES WHERE SALES_ID='$id'";

  $result = $con->prepare($query);
  $result->execute();

  if ($result->rowCount() != 0) {

    while ($sales = $result->fetch()) {
      $sales_date = $sales['SALES_DATE'];
    }
  }
  $expense_query = "SELECT * FROM EXPENSES WHERE EXPENSE_DATE='$sales_date'";

  $expenses = $con->prepare($expense_query);
  $expenses->execute();

  if ($expenses->rowCount() != 0) {
    $total_expenses = 0;
    while ($expense = $expenses->fetch()) {
      $total_expenses += $expense['EXPENSE_AMOUNT'];
      $pdf->SetFont('Arial', '', 8);

      $pdf->Cell(10, 5, $expense['EXPENSE_DESC'], 0, 0, 'C');
      $pdf->Cell(30, 5, $expense['EXPENSE_AMOUNT'], 0, 1, 'C');
    }
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(10, 5, 'Total Expenses: ', 0, 0, 'C');
    $pdf->Cell(30, 5, $total_expenses, 0, 1, 'C');
  }

  // table column
  $pdf->Cell(2, 10, 'Debt', 0, 0, 'C');
  $pdf->Cell(40, 10, 'Amount', 0, 1, 'C');

  $debt_query = "SELECT * FROM DEBTS WHERE DEBT_DATE='$sales_date'";

  $debts = $con->prepare($debt_query);
  $debts->execute();

  if ($debts->rowCount() != 0) {
    $total_debts = 0;
    while ($debt = $debts->fetch()) {
      $total_debts += $debt['DEBT_AMOUNT'];
      $pdf->SetFont('Arial', '', 8);

      $pdf->Cell(10, 5, $debt['DEBT_DESC'], 0, 0, 'C');
      $pdf->Cell(30, 5, $debt['DEBT_AMOUNT'], 0, 1, 'C');
    }
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(2, 5, 'Total Debts: ', 0, 0, 'C');
    $pdf->Cell(40, 5, $total_debts, 0, 1, 'C');
  }

  // table column
  $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(2, 10, 'Product', 0, 0, 'C');
  $pdf->Cell(40, 10, 'Stock Sold', 0, 1, 'C');
  $stock_query = "SELECT * FROM STOCK JOIN PRODUCTS 
  ON STOCK.STOCK_PRODUCT_ID=PRODUCTS.PRODUCT_ID 
  WHERE STOCK_DATE='$sales_date' ";

  $stock_result = $con->prepare($stock_query);
  $stock_result->execute();
  if ($stock_result->rowCount() != 0) {

    while ($stock = $stock_result->fetch()) {

      $pdf->SetFont('Arial', '', 8);

      $pdf->Cell(10, 5, $stock['PRODUCT_NAME'], 0, 0, 'C');
      $pdf->Cell(30, 5, $stock['STOCK_SOLD'], 0, 1, 'C');

    }
  }
  
  $query = "SELECT * FROM SALES WHERE SALES_ID='$id'";

  $result = $con->prepare($query);
  $result->execute();
  if ($result->rowCount() != 0) {

    while ($sales = $result->fetch()) {

      $pdf->SetFont('Arial', 'B', 8);
      $pdf->setTextColor(252, 3, 3);

      $pdf->Cell(20, 5, 'Gross Income: ', 0, 0, 'C');
      $pdf->Cell(10, 5, $sales['SALES_GROSS'], 0, 1, 'C');

      $pdf->Cell(16, 5, 'Net Income: ', 0, 0, 'C');
      $pdf->Cell(10, 5, $sales['SALES_NET'], 0, 1, 'C');

      $pdf->Cell(15, 5, 'Loss: ', 0, 0, 'C');
      $pdf->Cell(8, 5, $sales['SALES_LOSS'], 0, 1, 'C');

      $pdf->Cell(8, 5, 'Date: ', 0, 0, 'C');
      $pdf->Cell(18, 5, $sales['SALES_DATE'], 0, 1, 'C');
    }
  }
}

$pdf->SetTitle('Sales Record');
$pdf->Output("I", "report.pdf");
