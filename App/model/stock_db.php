<?php

include('connection.php');

$stock_added = "";
$stock_waste = "";
$stock_bal = "";
$stock_total = "";
$stock_date = "";
$id = 0;
$edit_state = false;



if (isset($_POST['save'])) {
    $stock_added = $_POST['stock_added'];
    $stock_waste = $_POST['stock_waste'];
    $stock_total = $_POST['stock_total'];
    $stock_bal = $_POST['stock_bal'];
    $stock_date = $_POST['stock_date'];
    $product_id = mysqli_real_escape_string($db, $_POST['Product']);

    $stock_sold = $stock_total - ($stock_bal + $stock_waste);



    $query = "INSERT INTO STOCK(STOCK_ADDED,STOCK_TOTAL,STOCK_WASTE,STOCK_BAL,STOCK_SOLD,STOCK_PRODUCT_ID,STOCK_DATE) VALUES ('$stock_added',' $stock_total','$stock_waste','$stock_bal','$stock_sold','$product_id','$stock_date')";
    mysqli_query($db, $query);
    header('location:../views/main.php#stock');;
};

if (isset($_POST['update'])) {
    $stock_added = mysqli_real_escape_string($db, $_POST['stock_added']);
    $stock_total = mysqli_real_escape_string($db, $_POST['stock_total']);
    $stock_waste = mysqli_real_escape_string($db, $_POST['stock_waste']);
    $stock_bal = mysqli_real_escape_string($db, $_POST['stock_bal']);
    $stock_date = mysqli_real_escape_string($db, $_POST['stock_date']);
    $product_id = mysqli_real_escape_string($db, $_POST['Product']);
    $id = mysqli_real_escape_string($db, $_POST['stock_id']);
    $product_id = mysqli_real_escape_string($db, $_POST['Product']);


    $stock_sold = $stock_total - ($stock_bal + $stock_waste);



    mysqli_query($db, "UPDATE STOCK SET STOCK_ADDED='$stock_added',
    STOCK_TOTAL='$stock_total', STOCK_WASTE='$stock_waste', 
    STOCK_BAL='$stock_bal', STOCK_PRODUCT_ID='$product_id',
    STOCK_SOLD='$stock_sold', STOCK_DATE='$stock_date' 
    WHERE STOCK_ID=$id");
    header('location:../views/main.php#stock');
}
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE FROM STOCK WHERE STOCK_ID=$id");
    header('location:../views/main.php#stock');
}
$todays_stock = "SELECT * FROM STOCK JOIN PRODUCTS ON STOCK.STOCK_PRODUCT_ID=PRODUCTS.PRODUCT_ID ORDER BY STOCK_DATE DESC";
$results = mysqli_query($db, $todays_stock);
