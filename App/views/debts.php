<link rel="stylesheet" href="\B_INVENTORY\style.css">
<?php include('../model/debts_db.php');

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($db, "SELECT * FROM  DEBTS  JOIN DEBTORS ON DEBTS.DEBT_DEBTOR_ID= DEBTORS.DEBTOR_ID WHERE DEBT_ID=$id ");
    $record = mysqli_fetch_array($rec);

    $debtor_name = $record['DEBTOR_NAME'];
    $debt_desc = $record['DEBT_DESC'];
    $debt_amount = $record['DEBT_AMOUNT'];
    $debt_date = $record['DEBT_DATE'];
    $id = $record['DEBT_ID'];
}
?>

<table>
    <thead>
        <tr>
            <th>DEBTOR</th>
            <th>DESCRIPTION</th>
            <th>AMOUNT</th>
            <th>DATE</th>
            <th colspan="2">Action</th>
        </tr>
    <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['DEBTOR_NAME']; ?></td>
                <td><?php echo $row['DEBT_DESC']; ?></td>
                <td><?php echo $row['DEBT_AMOUNT']; ?></td>
                <td><?php echo $row['DEBT_DATE']; ?></td>
                <td>
                    <a class="edit_btn" href="debts.php?edit=<?php echo $row['DEBT_ID']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a class="del_btn" href="../model/debts_db.php?del=<?php echo $row['DEBT_ID']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
    </thead>
</table>
<form class="form" method="post" action="../model/debts_db.php" autocomplete="off">
    <div>
        <label>Select an existing debtor</label>
        <select name="Debtor">

            <?php
            $sql = "SELECT * FROM DEBTORS";
            $all_debtors = mysqli_query($db, $sql);
            while ($debtor = mysqli_fetch_array(
                $all_debtors,
                MYSQLI_ASSOC
            )) :;
            ?>

                <option value="<?php echo $debtor["DEBTOR_ID"];

                                ?>">
                    <?php echo $debtor["DEBTOR_NAME"];

                    ?>
                </option>
            <?php
            endwhile;

            ?>
        </select>
        <input type="text " placeholder="Debtor Manipulation" name="debtor">

        <button type="submit" name="debtor_save" class="add_btn"><i class="fa fa-plus" aria-hidden="true"></i></button>

        <button type="submit" name="debtor_update" class="edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></button>

        <button type="submit" name="debtor_del" class="del_btn"><i class="fa fa-trash" aria-hidden="true"></i></button>
        <a href="../views/main.php#debts_update"> Paid debts </a>
    </div>
    <input type="hidden" name="debt_id" value="<?php echo $id; ?>">


    <div class="input-group">
        <label>Description</label>
        <input class="input" type="text " name="debt_desc" value="<?php echo $debt_desc; ?>">
    </div>
    <div class="input-group">
        <label>Amount</label>
        <input class="input" type="text " name="debt_amount" value="<?php echo $debt_amount; ?>">
    </div>
    <div class="input-group">
        <label>Date</label>
        <input class="input" type="date" name="debt_date" value="<?php echo $debt_date; ?>">
    </div>
    <div class="input-group">

        <?php if ($edit_state == false) : ?>
            <button type="submit" name="save" class="btn">Save</button>
        <?php else : ?>
            <button type="submit" name="update" class="btn">Update</button>
        <?php endif ?>

    </div>
</form>