
<?php

include('connection.php');

$cash = "";
$mpesa = "";
$stock_date = "";
$id = 0;
$edit_state = false;



if (isset($_POST['save'])) {
    $cash = $_POST['cash'];
    $mpesa = $_POST['mpesa'];
    $revenue_date = $_POST['date'];

    $product_id = mysqli_real_escape_string($db, $_POST['Product']);

    $stock = "SELECT * FROM STOCK WHERE STOCK_PRODUCT_ID='$product_id ' AND STOCK_DATE='$revenue_date'";
    $result = mysqli_query($db, $stock);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $stock_id = $row['STOCK_ID'];
        }
       
    $query = "INSERT INTO REVENUE(REVENUE_CASH,REVENUE_MPESA,REVENUE_STOCK_ID,REVENUE_DATE)
    VALUES ('$cash','$mpesa','$stock_id','$revenue_date')";
   mysqli_query($db, $query);
   header('location:../views/main.php#sales');
    }else{
        echo "<script>if(!alert('No stock record by that date')){window.location.href = '../views/main.php#sales';}</script>";
     }
    


};
if (isset($_GET['sales'])) {



    $product_sales = "SELECT STOCK_DATE,(STOCK_SOLD*PRODUCT_PRICE) AS GROSS_INCOME, 
    (REVENUE_CASH+REVENUE_MPESA) AS TOTAL_REVENUE FROM PRODUCTS JOIN STOCK ON STOCK.STOCK_PRODUCT_ID=PRODUCTS.PRODUCT_ID
    JOIN REVENUE ON REVENUE.REVENUE_PRODUCT_ID=PRODUCTS.PRODUCT_ID     
    WHERE STOCK_DATE= DATE(NOW()) AND REVENUE_DATE=STOCK_DATE";
    $result = mysqli_query($db, $product_sales);

    if (mysqli_num_rows($result) > 0) {
        $gross = 0;
        $total_revenue = 0;
        while ($row = mysqli_fetch_assoc($result)) {

            $gross += (int)$row["GROSS_INCOME"];

            $total_revenue += $row["TOTAL_REVENUE"];

            $stock_date = $row['STOCK_DATE'];
        }
    }

    $expenses = "SELECT EXPENSE_AMOUNT FROM EXPENSES WHERE EXPENSE_DATE= DATE(NOW())";
    $todays_expenses = mysqli_query($db, $expenses);
    $total_expenses = 0;
    if (mysqli_num_rows($todays_expenses) > 0) {

        while ($row = mysqli_fetch_assoc($todays_expenses)) {

            $total_expenses += $row["EXPENSE_AMOUNT"];
        }
    }

    $credits = "SELECT DEBT_AMOUNT FROM DEBTS WHERE DEBT_DATE= DATE(NOW())";
    $todays_credits = mysqli_query($db, $credits);
    $total_credits = 0;
    if (mysqli_num_rows($todays_credits) > 0) {

        while ($row = mysqli_fetch_assoc($todays_credits)) {

            $total_credits += $row["CREDIT_AMOUNT"];
        }
    }


    $net_income = $gross - ($total_expenses + $total_credits);
    $loss = $net_income - $total_revenue;


    $sales = "INSERT INTO SALES(SALE_GROSS, SALE_NET,SALE_LOSS,SALE_DATE) 
    VALUES ('$gross','$net_income','$loss','$sale_date')";
    mysqli_query($db, $sales);
}


if (isset($_POST['update'])) {
    $cash = mysqli_real_escape_string($db, $_POST['cash']);
    $mpesa = mysqli_real_escape_string($db, $_POST['mpesa']);
    $revenue_date = mysqli_real_escape_string($db, $_POST['date']);

    $id = mysqli_real_escape_string($db, $_POST['revenue_id']);
    $product_id = mysqli_real_escape_string($db, $_POST['Product']);
try{
    $stock = "SELECT * FROM STOCK WHERE STOCK_PRODUCT_ID='$product_id ' AND STOCK_DATE='$revenue_date'";
    $result = mysqli_query($db, $stock);

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $stock_id = $row['STOCK_ID'];
        }
    }


    mysqli_query($db, "UPDATE REVENUE SET REVENUE_CASH='$cash',REVENUE_MPESA='$mpesa',REVENUE_DATE='$revenue_date',REVENUE_STOCK_ID=' $stock_id ' 
    WHERE REVENUE_ID=$id");
    header('location:../views/main.php#sales');
}catch(Exception $e){

    echo "<script>if(!alert('No stock record by that date'))
    {window.location.href = '../views/main.php#sales';}</script>";
    
}
}
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE FROM REVENUE WHERE REVENUE_ID=$id");
    header('location:../views/main.php#sales');
}

$todays_stock = "SELECT * FROM STOCK
JOIN REVENUE ON STOCK.STOCK_ID= REVENUE.REVENUE_STOCK_ID JOIN PRODUCTS ON STOCK.STOCK_PRODUCT_ID=PRODUCTS.PRODUCT_ID";
$results = mysqli_query($db, $todays_stock);
?>
