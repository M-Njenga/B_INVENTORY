<?php
     require '../FPDF/fpdf.php';
     
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->setTextColor(252, 3, 3);
        $pdf->Cell(200,20,'REVENUE',0,1,'C');
        $pdf->setLeftMargin(40);
        $pdf->setTextColor(0, 0, 0);

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(10,10,"Date:",0,0,'C');
        $pdf->Cell(20,10,date("j-n-Y"),0,1,'C');
        // table column
        
        $pdf->Cell(10,10,'No',1,0,'C');
        $pdf->Cell(25,10,'PRODUCT',1,0,'C');
        $pdf->Cell(25,10,'CASH',1,0,'C'); 
        $pdf->Cell(25,10,'MPESA',1,0,'C');               
        $pdf->Cell(25,10,'GROSS',1,0,'C');
        $pdf->Cell(30,10,'DATE',1,1,'C');
        
        // table rows
        $pdf->SetFont('Arial','',12);
        $con = new PDO('mysql:host=localhost;dbname=b_inventory','root','');
        $query ="SELECT * FROM STOCK
        JOIN REVENUE ON STOCK.STOCK_ID= REVENUE.REVENUE_STOCK_ID JOIN PRODUCTS ON STOCK.STOCK_PRODUCT_ID=PRODUCTS.PRODUCT_ID";
        
        $result = $con->prepare($query);
        $result->execute();
        if($result->rowCount()!=0)
        {
                         $i=0;
             while($revenue = $result->fetch())
            {
              $pdf->Cell(10,10,++$i,1,0,'C');
             
              $pdf->Cell(25,10,$revenue['PRODUCT_NAME'],1,0,'C');
              $pdf->Cell(25,10,$revenue['REVENUE_CASH'],1,0,'C');
              $pdf->Cell(25,10,$revenue['REVENUE_MPESA'],1,0,'C');
                           
              $pdf->Cell(25,10,($revenue['STOCK_SOLD']*$revenue['PRODUCT_PRICE']),1,0,'C');
              $pdf->Cell(30,10,$revenue['REVENUE_DATE'],1,1,'C');
            }
           
        }
        $pdf->SetTitle('Revenue Record');
         $pdf->Output();
