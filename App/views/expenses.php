<link rel="stylesheet" href="\B_INVENTORY\style.css">
<?php include('../model/expenses_db.php');


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($db, "SELECT * FROM EXPENSES WHERE EXPENSE_ID=$id");
    $record = mysqli_fetch_array($rec);
    $expense_desc = $record['EXPENSE_DESC'];
    $expense_amount = $record['EXPENSE_AMOUNT'];
    $expense_date = $record['EXPENSE_DATE'];
    $id = $record['EXPENSE_ID'];
}
?>

<table>
    <thead>
        <tr>
            <th>Expense</th>
            <th>Amount</th>
            <th>Date</th>
            
            <th colspan="2">Action</th>
            <th><a href="#users"><i class="fa fa-download"></i></a></th>
        </tr>
    <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['EXPENSE_DESC']; ?></td>
                <td><?php echo $row['EXPENSE_AMOUNT']; ?></td>
                <td><?php echo $row['EXPENSE_DATE']; ?></td>
                <td>
                    <a class="edit_btn" href="expenses.php?edit=<?php echo $row['EXPENSE_ID']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a class="del_btn" href="../model/expenses_db.php?del=<?php echo $row['EXPENSE_ID']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
    </thead>
</table>
<form class="form" method="post" action="../model/expenses_db.php" autocomplete="off">
    <input type="hidden" name="expense_id" value="<?php echo $id; ?>">
    <div class="input-group">
        <label>Expense</label>
        <input class="input" type="text " required name="expense_desc" value="<?php echo $expense_desc; ?>">
    </div>
    <div class="input-group">
        <label>Amount</label>
        <input class="input" type="text " required name="expense_amount" value="<?php echo $expense_amount; ?>">
    </div>
    <div class="input-group">
        <label>Date</label>
        <input class="input" type="date" required name="expense_date" value="<?php echo $expense_date; ?>">
    </div>
    <div class="input-group">

        <?php if ($edit_state == false) : ?>

            <button type="submit" name="save" class="btn">Save</button>
        <?php else : ?>
            <button type="submit" name="update" class="btn">Update</button>
        <?php endif ?>

    </div>
</form>