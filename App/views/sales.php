<link rel="stylesheet" href="\B_INVENTORY\style.css">

<?php include('../model/sales_db.php');


if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($db, "SELECT * FROM REVENUE WHERE REVENUE_ID=$id");
    $record = mysqli_fetch_array($rec);

    $cash = $record['REVENUE_CASH'];
    $mpesa = $record['REVENUE_MPESA'];
    $sales_date = $record['REVENUE_DATE'];
    $id = $record['REVENUE_ID'];
}
?>

<table>
    <thead>
        <tr>

            <th>PRODUCT</th>
            <th>CASH</th>
            <th>MPESA</th>
            <th>GROSS </th>

            <th colspan="2">ACTION</th>
        </tr>
    <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>

            <tr>
                <td><?php echo $row['PRODUCT_NAME']; ?></td>
                <td><?php echo $row['REVENUE_CASH']; ?></td>
                <td><?php echo $row['REVENUE_MPESA']; ?></td>
                <td><?php echo ($row['STOCK_SOLD'] * $row['PRODUCT_PRICE']); ?></td>
                <td>
                    <a class="edit_btn" href="sales.php?edit=<?php echo $row['REVENUE_ID']; ?>">Edit</a>
                </td>
                <td>
                    <a class="del_btn" href="../model/sales_db.php?del=<?php echo $row['REVENUE_ID']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
    </thead>
</table>

<div class="output">
    Total Gross Income: <?php echo 'mao'; ?><br>
    Total Net Income: <?php echo 'no'; ?><br>
    Total Revenue: <?php echo 'no'; ?><br>
    Loss: <?php echo 'no'; ?>
</div>

<form class="form" method="post" action="../model/sales_db.php" autocomplete="off">
    <div>
        <label>Choose a product:</label>

        <select name="Product">


            <?php
            $sql = "SELECT STOCK_PRODUCT_ID, PRODUCT_NAME FROM STOCK JOIN PRODUCTS ON STOCK.STOCK_PRODUCT_ID=PRODUCTS.PRODUCT_ID GROUP BY 1";
            $all_products = mysqli_query($db, $sql);
            while ($product = mysqli_fetch_array(
                $all_products,
                MYSQLI_ASSOC
            )) :;
            ?>
                <option value="<?php echo $product["STOCK_PRODUCT_ID"];

                                ?>">
                    <?php echo $product["PRODUCT_NAME"];

                    ?>
                </option>
            <?php
            endwhile;

            ?>
        </select>
    </div>

    <input type="hidden" name="revenue_id" value="<?php echo $id; ?>">

    <div class="input-group">
        <label>Cash</label>
        <input class="input" type="text " required name="cash" value="<?php echo $cash; ?>">
    </div>
    <div class="input-group">
        <label>Mpesa</label>
        <input class="input" type="text " required name="mpesa" value="<?php echo $mpesa; ?>">
    </div>

    <div class="input-group">
        <label>Date</label>
        <input class="input" type="date" required name="date" value="<?php echo $sales_date; ?>">
    </div>
    <div class="input-group">

        <?php if ($edit_state == false) : ?>
            <button type="submit" name="save" class="btn">Save</button>
        <?php else : ?>
            <button type="submit" name="update" class="btn">Update</button>
        <?php endif ?>

        <a class="del_btn" href="sales.php?sales">Process</a>
    </div>
</form>