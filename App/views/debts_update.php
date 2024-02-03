<?php include('../model/debts_db.php');?>


<form class="form" method="post" action="../model/debts_db.php" autocomplete="off">
    <div>
    <label >Debtor</label>
        <select name="Debtor">
            
            <?php
            $sql = "SELECT DEBT_DEBTOR_ID, DEBTOR_NAME FROM DEBTS JOIN DEBTORS ON DEBTS.DEBT_DEBTOR_ID= DEBTORS.DEBTOR_ID GROUP BY 1";
            $all_debtors = mysqli_query($db, $sql);
            while ($debtor = mysqli_fetch_array(
                $all_debtors,
                MYSQLI_ASSOC
            )) :;
            ?>
            
                <option value="<?php echo $debtor["DEBT_DEBTOR_ID"];

                                ?>">
                    <?php echo $debtor["DEBTOR_NAME"];

                    ?>
                </option>
            <?php
            endwhile;

            ?>
        </select>
        
    </div>
    
    
  
    <div class="input-group">
        <label>Amount Paid</label>
        <input class="input" type="text " name="paid_amount" >
    </div>
    <div class="input-group">
        <label>Date</label>
        <input class="input" type="date" required name="debt_date" value="<?php echo $debt_date; ?>">
    </div>
    <div class="input-group">

        
            <button type="submit" name="paid_debt" class="btn">Save</button>
       
        
    </div>
</form>

