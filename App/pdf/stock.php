<?php
     require '../FPDF/fpdf.php';
     
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->setTextColor(252, 3, 3);
        $pdf->Cell(200,20,'STOCK',0,1,'C');
        $pdf->setLeftMargin(5);
        $pdf->setTextColor(0, 0, 0);

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(10,10,"Date:",0,0,'C');
        $pdf->Cell(20,10,date("j-n-Y"),0,1,'C');
        // table column
        
        $pdf->Cell(10,10,'No',1,0,'C');
        $pdf->Cell(25,10,'PRODUCT',1,0,'C');
        $pdf->Cell(25,10,'ADDED',1,0,'C'); 
        $pdf->Cell(25,10,'TOTAL',1,0,'C');               
        $pdf->Cell(25,10,'WASTE',1,0,'C');
        $pdf->Cell(25,10,'BAL',1,0,'C');
        $pdf->Cell(25,10,'SOLD',1,0,'C');
        $pdf->Cell(30,10,'DATE',1,1,'C');
        
        // table rows
        $pdf->SetFont('Arial','',12);
        $con = new PDO('mysql:host=localhost;dbname=b_inventory','root','');
        $query ="SELECT * FROM STOCK JOIN PRODUCTS ON STOCK.STOCK_PRODUCT_ID=PRODUCTS.PRODUCT_ID 
        ORDER BY STOCK_DATE DESC";
        $result = $con->prepare($query);
        $result->execute();
        if($result->rowCount()!=0)
        {
                         $i=0;
             while($stock = $result->fetch())
            {
              $pdf->Cell(10,10,++$i,1,0,'C');
             
              $pdf->Cell(25,10,$stock['PRODUCT_NAME'],1,0,'C');
              $pdf->Cell(25,10,$stock['STOCK_ADDED'],1,0,'C');
              $pdf->Cell(25,10,$stock['STOCK_TOTAL'],1,0,'C');
              $pdf->Cell(25,10,$stock['STOCK_WASTE'],1,0,'C');
              $pdf->Cell(25,10,$stock['STOCK_BAL'],1,0,'C');              
              $pdf->Cell(25,10,$stock['STOCK_SOLD'],1,0,'C');
              $pdf->Cell(30,10,$stock['STOCK_DATE'],1,1,'C');
              
            }


        }
        $pdf->SetTitle('Stock Record');
         $pdf->Output();
