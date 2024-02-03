<?php
     require '../FPDF/fpdf.php';
     
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->setTextColor(252, 3, 3);
        $pdf->Cell(200,20,'CREDIT HISTORY',0,1,'C');
        $pdf->setLeftMargin(5);
        $pdf->setTextColor(0, 0, 0);

        $pdf->SetFont('Arial','',11);
        $pdf->Cell(10,10,"Date:",0,0,'C');
        $pdf->Cell(20,10,date("j-n-Y"),0,1,'C');
        // table column
        $pdf->Cell(10,10,'No',1,0,'C');
        $pdf->Cell(40,10,'CREDITOR',1,0,'C');
        $pdf->Cell(40,10,'TOTAL',1,0,'C');
        $pdf->Cell(40,10,'PAID AMOUNT',1,0,'C');
        $pdf->Cell(40,10,'BALANCE',1,0,'C');
        $pdf->Cell(30,10,'PAID DATE',1,1,'C');
        
        // table rows
        $pdf->SetFont('Arial','',11);
        $con = new PDO('mysql:host=localhost;dbname=b_inventory','root','');
        $query ="SELECT * FROM CREDIT_UPDATES JOIN CREDITORS ON CREDIT_UPDATES .CREDIT_UPDATE_CREDITOR_ID=CREDITORS.CREDITOR_ID
        ORDER BY CREDIT_UPDATE_DATE ASC";
        $result = $con->prepare($query);
        $result->execute();
        if($result->rowCount()!=0)
        {
                         $i=0;
            while($credit = $result->fetch())
            {
              $pdf->Cell(10,10,++$i,1,0,'C');
              $pdf->Cell(40,10,$credit['CREDITOR_NAME'],1,0,'C');
              $pdf->Cell(40,10,$credit['CREDIT_UPDATE_TOTAL_CREDIT'],1,0,'C');
              $pdf->Cell(40,10,$credit['CREDIT_UPDATE_PAID_AMOUNT'],1,0,'C');  
              $pdf->Cell(40,10,$credit['CREDIT_UPDATE_BAL'],1,0,'C');             
              $pdf->Cell(30,10,$credit['CREDIT_UPDATE_DATE'],1,1,'C');
              
            }

        }
        $pdf->SetTitle('Credits Record');
         $pdf->Output();
