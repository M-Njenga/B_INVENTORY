<link rel="stylesheet" href="\B_INVENTORY\style.css">
<?php include('../model/stock_db.php');

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($db, "SELECT * FROM STOCK WHERE STOCK_ID=$id");
    $record = mysqli_fetch_array($rec);
    $stock_added = $record['STOCK_ADDED'];
    $stock_total = $record['STOCK_TOTAL'];
    $stock_waste = $record['STOCK_WASTE'];
    $stock_bal = $record['STOCK_BAL'];
    $stock_date= $record['STOCK_DATE'];
    $id = $record['STOCK_ID'];
    
}
?>

<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Added</th>
            <th>Total</th>
            <th>Waste</th>
            <th>Bal</th>
            <th>Sold</th>
            <th>Date</th>
            <th colspan="2">Action</th>
        </tr>
    <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['PRODUCT_NAME']; ?></td>
                <td><?php echo $row['STOCK_ADDED']; ?></td>
                <td><?php echo $row['STOCK_TOTAL']; ?></td>
                <td><?php echo $row['STOCK_WASTE']; ?></td>
                <td><?php echo $row['STOCK_BAL']; ?></td>
                <td><?php echo $row['STOCK_SOLD']; ?></td>
                <td><?php echo $row['STOCK_DATE']; ?></td>
                <td>
                    <a class="edit_btn" href="stock.php?edit=<?php echo $row['STOCK_ID']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a class="del_btn" href="../model/stock_db.php?del=<?php echo $row['STOCK_ID']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
    </thead>
</table>
<form class="form" method="post" action="../model/stock_db.php" autocomplete="off">
    <div>
        <label>Choose a product:</label>

        <select name="Product">


            <?php
            $sql = "SELECT * FROM PRODUCTS";
            $all_products = mysqli_query($db, $sql);
            while ($product = mysqli_fetch_array(
                $all_products,
                MYSQLI_ASSOC
            )) :;
            ?>
                <option value="<?php echo $product["PRODUCT_ID"];

                                ?>">
                    <?php echo $product["PRODUCT_NAME"];

                    ?>
                </option>
            <?php
            endwhile;

            ?>
        </select>
    </div>
    <input type="hidden" name="stock_id" value="<?php echo $id; ?>">

    <div class="input-group">
        <label>Stock Added</label>
        <input class="input" type="text " required name="stock_added" value="<?php echo $stock_added; ?>">
    </div>
    <div class="input-group">
        <label>Total stock</label>
        <input class="input" type="text " required name="stock_total" value="<?php echo $stock_total; ?>">
    </div>
    <div class="input-group">
        <label>Waste</label>
        <input class="input" type="text " required name="stock_waste" value="<?php echo $stock_waste; ?>">
    </div>
    <div class="input-group">
        <label>Balance</label>
        <input class="input" type="text " required name="stock_bal" value="<?php echo $stock_bal; ?>">
    </div>
    <div class="input-group">
        <label>Date</label>
        <input class="input" type="date" required name="stock_date" value="<?php echo $stock_date; ?>">
    </div>
    <div class="input-group">

        <?php if ($edit_state == false) : ?>
            <button type="submit" name="save" class="btn">Save</button>
        <?php else : ?>
            <button type="submit" name="update" class="btn">Update</button>
        <?php endif ?>

    </div>
</form>