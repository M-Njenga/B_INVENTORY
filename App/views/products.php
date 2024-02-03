<link rel="stylesheet" href="\B_INVENTORY\style.css">
<?php include('../model/product_db.php');

 
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;
    $rec = mysqli_query($db, "SELECT * FROM PRODUCTS WHERE PRODUCT_ID=$id");
    $record = mysqli_fetch_array($rec);
    $product_name = $record['PRODUCT_NAME'];
    $product_price = $record['PRODUCT_PRICE'];
    $id = $record['PRODUCT_ID'];
}
?>

<table>
    <thead>
        <tr>
            <th>PRODUCT</th>
            <th>CATEGORY</th>
            <th>PRICE</th>
            <th colspan="2">ACTION</th>
        </tr>
    <tbody>
        <?php while ($row = mysqli_fetch_array($results)) { ?>
            <tr>
                <td><?php echo $row['PRODUCT_NAME']; ?></td>
                <td><?php echo $row['CAT_DESC']; ?></td>
                <td><?php echo $row['PRODUCT_PRICE']; ?></td>
                <td>
                    <a class="edit_btn" href="products.php?edit=<?php echo $row['PRODUCT_ID']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a class="del_btn" href="../model/product_db.php?product_del=<?php echo $row['PRODUCT_ID']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
        <?php } ?>

    </tbody>
    </thead>
</table>
<form class="form" method="post" action="../model/product_db.php" autocomplete="off">
    <div>
        <label>Choose a category:</label>

        <select name="cat">


            <?php
            $sql = "SELECT * FROM CATEGORIES";
            $all_cats = mysqli_query($db, $sql);
            while ($cat = mysqli_fetch_array(
                $all_cats,
                MYSQLI_ASSOC
            )) :;

            ?>
                <option value="<?php echo $cat["CAT_ID"];

                                ?>">
                    <?php echo $cat["CAT_DESC"];

                    ?>
                </option>
            <?php
            endwhile;

            ?>




        </select>
        <input type="text " placeholder="Category Manipulation" name="cat_desc">

        <button type="submit" name="cat_save" class="add_btn"><i class="fa-solid fa-circle-plus"></i></button>

        <button type="submit" name="cat_update" class="edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></button>

        <button type="submit" name="cat_del" class="del_btn"><i class="fa fa-trash" aria-hidden="true"></i></button>

    </div>


    <input type="hidden" name="product_id" value="<?php echo $id; ?>">

    <div class="input-group">
        <label>PRODUCT NAME</label>
        <input class="input" type="text " name="product_name" value="<?php echo $product_name; ?>">
    </div>
    <div class="input-group">
        <label>PRODUCT PRICE</label>
        <input class="input" type="text " name="product_price" value="<?php echo $product_price; ?>">
    </div>
    <div class="input-group">

        <?php if ($edit_state == false) : ?>

            <button type="submit" name="product_save" class="btn">Save</button>
        <?php else : ?>
            <button type="submit" name="product_update" class="btn">Update</button>
        <?php endif ?>

    </div>
</form>