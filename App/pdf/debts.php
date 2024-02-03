<?php
     require '../FPDF/fpdf.php';
     
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->setTextColor(252, 3, 3);
        $pdf->Cell(200,20,'DEBT HISTORY',0,1,'C');
        $pdf->setLeftMargin(5);
        $pdf->setTextColor(0, 0, 0);

        $pdf->SetFont('Arial','',11);
        $pdf->Cell(10,10,"Date:",0,0,'C');
        $pdf->Cell(20,10,date("j-n-Y"),0,1,'C');
        // table column
        $pdf->Cell(10,10,'No',1,0,'C');
        $pdf->Cell(40,10,'DEBTOR',1,0,'C');
        $pdf->Cell(40,10,'TOTAL',1,0,'C');
        $pdf->Cell(40,10,'PAID AMOUNT',1,0,'C');
        $pdf->Cell(40,10,'BALANCE',1,0,'C');
        $pdf->Cell(30,10,'PAID DATE',1,1,'C');
        
        // table rows
        $pdf->SetFont('Arial','',11);
        $con = new PDO('mysql:host=localhost;dbname=b_inventory','root','');
        $query ="SELECT * FROM DEBT_UPDATES JOIN DEBTORS ON DEBT_UPDATES .DEBT_UPDATE_DEBTOR_ID=DEBTORS.DEBTOR_ID 
        ORDER BY DEBT_UPDATE_DATE ASC";
        $result = $con->prepare($query);
        $result->execute();
        if($result->rowCount()!=0)
        {
                         $i=0;
            while($credit = $result->fetch())
            {
              $pdf->Cell(10,10,++$i,1,0,'C');
              $pdf->Cell(40,10,$credit['DEBTOR_NAME'],1,0,'C');
              $pdf->Cell(40,10,$credit['DEBT_UPDATE_TOTAL_DEBT'],1,0,'C');
              $pdf->Cell(40,10,$credit['DEBT_UPDATE_PAID_AMOUNT'],1,0,'C');  
              $pdf->Cell(40,10,$credit['DEBT_UPDATE_BAL'],1,0,'C');             
              $pdf->Cell(30,10,$credit['DEBT_UPDATE_DATE'],1,1,'C');
              
            }

        }
        $pdf->SetTitle('Debts Record');
         $pdf->Output();
