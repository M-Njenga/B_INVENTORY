<?php
include('connection.php');

$expense_desc="";
$expense_amount="";
$expense_date="";

$id=0;
$edit_state=false;



if(isset($_POST['save'])){

    $expense_desc=$_POST['expense_desc'];
    $expense_amount=$_POST['expense_amount'];
    $expense_date=$_POST['expense_date'];
    
    $query="INSERT INTO EXPENSES(EXPENSE_DESC,EXPENSE_AMOUNT,EXPENSE_DATE) VALUES ('$expense_desc','$expense_amount','$expense_date')";
    mysqli_query($db,$query);
    header('location:../views/main.php#expenses');

    };

if(isset($_POST['update'])){

    $expense_desc = mysqli_real_escape_string($db, $_POST['expense_desc']);
    $expense_amount=mysqli_real_escape_string($db,$_POST['expense_amount']);
    $expense_date=mysqli_real_escape_string($db,$_POST['expense_date']);

    $id=mysqli_real_escape_string($db,$_POST['expense_id']);

    mysqli_query($db, "UPDATE EXPENSES SET EXPENSE_DESC='$expense_desc', EXPENSE_AMOUNT='$expense_amount', EXPENSE_DATE='$expense_date' WHERE EXPENSE_ID=$id");
    header('location:../views/main.php#expenses');
   
}
if(isset($_GET['del'])){
    $id=$_GET['del'];
    mysqli_query($db,"DELETE FROM EXPENSES WHERE EXPENSE_ID=$id");
    header('location:../views/main.php#expenses');
    
}
if(isset($_POST['search'])){
    $specific_date=$_POST['specific_date'];
    $expenses=mysqli_query($db,"SELECT * FROM EXPENSES WHERE EXPENSE_DATE='$specific_date'");
    header('location:../views/main.php#expenses');
    
}


$expenses="SELECT * FROM EXPENSES ORDER BY EXPENSE_DATE ASC";
$results=mysqli_query($db,$expenses);
?>
