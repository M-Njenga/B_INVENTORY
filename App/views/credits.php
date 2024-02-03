<link rel="stylesheet" href="\B_INVENTORY\style.css">
<?php include('../model/credits_db.php');

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($db, "SELECT * FROM  CREDITS  JOIN CREDITORS 
    ON CREDITS.CREDIT_CREDITOR_ID= CREDITORS.CREDITOR_ID WHERE CREDIT_ID=$id ");
    $record = mysqli_fetch_array($rec);
    
    $creditor_name = $record['CREDITOR_NAME'];
    $credit_desc = $record['CREDIT_DESC'];
    $credit_amount = $record['CREDIT_AMOUNT'];
    $credit_date = $record['CREDIT_DATE'];
    $id = $record['CREDIT_ID'];
    
}
?>

<table>
    <thead>
        <tr>
            <th>CREDITOR</th>
            <th>DESCRIPTION</th>
            <th>AMOUNT</th>
            <th>DATE</th>
            <th colspan="2">Action</th>
        </tr>
    <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['CREDITOR_NAME']; ?></td>
                <td><?php echo $row['CREDIT_DESC']; ?></td>
                <td><?php echo $row['CREDIT_AMOUNT']; ?></td>
                <td><?php echo $row['CREDIT_DATE']; ?></td>
                <td>
                    <a class="edit_btn" href="credits.php?edit=<?php echo $row['CREDIT_ID']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a class="del_btn" href="../model/credits_db.php?del=
                    <?php echo $row['CREDIT_ID']; ?>">
                    <i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
    </thead>
</table>
<form class="form" method="post" action="../model/credits_db.php" autocomplete="off">
    <div>
    <label >Select an existing creditor</label>
        <select name="Creditor">
            
            <?php
            $sql = "SELECT * FROM CREDITORS";
            $all_creditors = mysqli_query($db, $sql);
            while ($creditor = mysqli_fetch_array(
                $all_creditors,
                MYSQLI_ASSOC
            )) :;
            ?>
            
                <option value="<?php echo $creditor["CREDITOR_ID"];

                                ?>">
                    <?php echo $creditor["CREDITOR_NAME"];

                    ?>
                </option>
            <?php
            endwhile;

            ?>
            
        </select>
        <input type="text " placeholder="Creditor" name="creditor">

        <button type="submit" name="creditor_save" class="add_btn"><i class="fa fa-plus" aria-hidden="true"></i></button>

        <button type="submit" name="creditor_update" class="edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></button>

        <button type="submit" name="creditor_del" class="del_btn"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <a href="../views/main.php#credit_update"> Paid credits </a>
    </div>
    <input type="hidden" name="credit_id" value="<?php echo $id; ?>">
    
    
    <div class="input-group">
        <label>Description</label>
        <input class="input" type="text " name="credit_desc" value="<?php echo $credit_desc; ?>">
    </div>
    <div class="input-group">
        <label>Amount</label>
        <input class="input" type="text " name="credit_amount" value="<?php echo $credit_amount; ?>">
    </div>
    <div class="input-group">
        <label>Date</label>
        <input class="input" type="date" name="credit_date" value="<?php echo $credit_date; ?>">
    </div>
    <div class="input-group">

        <?php if ($edit_state == false) : ?>
            <button type="submit" name="save" class="btn">Save</button>
        <?php else : ?>
            <button type="submit" name="update" class="btn">Update</button>
        <?php endif ?>
      
    </div>
</form>
