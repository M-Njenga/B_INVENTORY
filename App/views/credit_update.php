<?php include('../model/credits_db.php'); ?>


<form class="form"  method="post" action="../model/credits_db.php" autocomplete="off">
    <div>
        <label>Creditor</label>
        <select name="Creditor">

            <?php
            $sql = "SELECT CREDIT_CREDITOR_ID, CREDITOR_NAME FROM CREDITS 
            JOIN CREDITORS ON CREDITS.CREDIT_CREDITOR_ID= CREDITORS.CREDITOR_ID GROUP BY 1";
            $all_creditors = mysqli_query($db, $sql);
            while ($creditor = mysqli_fetch_array(
                $all_creditors,
                MYSQLI_ASSOC
            )) :;
            ?>

                <option value="<?php echo $creditor["CREDIT_CREDITOR_ID"];

                                ?>">
                    <?php echo $creditor["CREDITOR_NAME"];

                    ?>
                </option>
            <?php
            endwhile;

            ?>
        </select>

    </div>



    <div class="input-group">
        <label>Amount Paid</label>
        <input class="input" type="text " name="paid_amount">
    </div>
    <div class="input-group">
        <label>Date</label>
        <input class="input" type="date" required name="credit_date" value="<?php echo $credit_date; ?>">
    </div>
    <div class="input-group">


        <button type="submit" name="paid_credit" class="btn">Save</button>


    </div>
</form>