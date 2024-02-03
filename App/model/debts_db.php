<?php

include('connection.php');

$debtor_name = '';
$debt_desc = "";
$debt_amount = "";
$debt_date = "";
$id = 0;
$edit_state = false;




if (isset($_POST['save'])) {
    $debt_desc = $_POST['debt_desc'];
    $debt_amount = $_POST['debt_amount'];

    $debt_date = $_POST['debt_date'];
    $debtor_id = mysqli_real_escape_string($db, $_POST['Debtor']);



    $debtors_query = "SELECT * FROM DEBTORS WHERE DEBTOR_ID= '$debtor_id'";
    $debtors = mysqli_query($db, $debtors_query);

    if (mysqli_num_rows($debtors) < 1) {

        $new_debtor = "INSERT INTO DEBTORS(DEBTOR_ID) VALUES('$debtor_id ')";
        mysqli_query($db, $new_debtor);
    }

    $debtors_query = "SELECT * FROM DEBTORS WHERE DEBTOR_ID= '$debtor_id '";
    $debtors = mysqli_query($db, $debtors_query);
    if (mysqli_num_rows($debtors) > 0) {

        while ($row = mysqli_fetch_assoc($debtors)) {
            $debtor_id = (int)$row["DEBTOR_ID"];
        }
    }

    $existing_pay_query = "SELECT DEBT_UPDATE_ID,DEBT_UPDATE_BAL FROM DEBT_UPDATES 
    JOIN DEBTS ON DEBT_UPDATES.DEBT_UPDATE_DEBTOR_ID=DEBTS.DEBT_DEBTOR_ID 
    WHERE DEBT_UPDATE_DEBTOR_ID= $debtor_id";

    $existing_pay = mysqli_query($db, $existing_pay_query);



    if (mysqli_num_rows($existing_pay) > 0) {

        while ($row = mysqli_fetch_assoc($existing_pay)) {
            $bal = $row["DEBT_UPDATE_BAL"];
            $update_id = $row["DEBT_UPDATE_ID"];
        }
        $debt_bal = $bal + $debt_amount;

        $update_query = "UPDATE DEBT_UPDATES SET DEBT_UPDATE_BAL='$debt_bal'  WHERE DEBT_UPDATE_ID =$update_id";
        mysqli_query($db, $update_query);

        header('location:../views/main.php#debts');
    }




    $debt_query = "INSERT INTO DEBTS(DEBT_DESC,DEBT_AMOUNT,DEBT_DEBTOR_ID,DEBT_DATE) VALUES ('$debt_desc','$debt_amount','$debtor_id','$debt_date')";
    mysqli_query($db, $debt_query);
    $debt_update_query;
    header('location:../views/main.php#debts');
};

if (isset($_POST['update'])) {
    $debt_desc = mysqli_real_escape_string($db, $_POST['debt_desc']);

    $debt_amount = mysqli_real_escape_string($db, $_POST['debt_amount']);
    $debtor_id = mysqli_real_escape_string($db, $_POST['Debtor']);
    $debt_id = mysqli_real_escape_string($db, $_POST['debt_id']);


    mysqli_query($db, "UPDATE DEBTS SET DEBT_DESC='$debt_desc', DEBT_AMOUNT='$debt_amount', DEBT_DEBTOR_ID=$debtor_id WHERE DEBT_ID=$debt_id");
    header('location:../views/main.php#debts');
}

function new_debt($debtor_id, $db, $payment, $debt_paid_date)
{
    $total_debt = 0;
    $existing_debts_query = "SELECT DEBT_AMOUNT FROM DEBTS 
    WHERE DEBT_DEBTOR_ID= $debtor_id";

    $existing_debt = mysqli_query($db, $existing_debts_query);



    if (mysqli_num_rows($existing_debt) > 0) {



        while ($row = mysqli_fetch_assoc($existing_debt)) {


            $total_debt += $row["DEBT_AMOUNT"];
        }
        $debt_bal = $total_debt - $payment;


        $update_query = "INSERT INTO DEBT_UPDATES(DEBT_UPDATE_TOTAL_DEBT,DEBT_UPDATE_PAID_AMOUNT,DEBT_UPDATE_BAL,DEBT_UPDATE_DEBTOR_ID,DEBT_UPDATE_DATE)
     VALUES ('$total_debt','$payment','$debt_bal','$debtor_id','$debt_paid_date')";
        mysqli_query($db, $update_query);
        if ($debt_bal == 0) {
            mysqli_query($db, "DELETE  FROM DEBTS WHERE DEBT_DEBTOR_ID=$debtor_id");
        }
    }
}
if (isset($_POST['paid_debt'])) {

    $payment = $_POST['paid_amount'];
    $debtor_id = $_POST['Debtor'];
    $debt_paid_date = $_POST['debt_date'];

    $payment_history_query = "SELECT DEBT_UPDATE_BAL FROM DEBT_UPDATES 
    JOIN DEBTS ON DEBT_UPDATES.DEBT_UPDATE_DEBTOR_ID=DEBTS.DEBT_DEBTOR_ID 
    WHERE DEBT_UPDATE_DEBTOR_ID= $debtor_id";

    $payment_history = mysqli_query($db, $payment_history_query);



    if (mysqli_num_rows($payment_history) > 0) {



        while ($row = mysqli_fetch_assoc($payment_history)) {
            $bal = $row["DEBT_UPDATE_BAL"];
        }
        if ($bal != 0) {

            $debt_bal = $bal - $payment;
            if ($debt_bal >= 0) {
            $update_query = "INSERT INTO DEBT_UPDATES(DEBT_UPDATE_TOTAL_DEBT,DEBT_UPDATE_PAID_AMOUNT,DEBT_UPDATE_BAL,DEBT_UPDATE_DEBTOR_ID,DEBT_UPDATE_DATE)
         VALUES ('$bal','$payment','$debt_bal','$debtor_id','$debt_paid_date')";
            mysqli_query($db, $update_query);
            if ($debt_bal == 0) {
                mysqli_query($db, "DELETE  FROM DEBTS WHERE DEBT_DEBTOR_ID=$debtor_id");
            }}
        } else {
            new_debt($debtor_id, $db, $payment, $debt_paid_date);
        }



        header('location:../views/main.php#debts');
    } else {

        new_debt($debtor_id, $db, $payment, $debt_paid_date);

        header('location:../views/main.php#debts');
    }
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE  FROM DEBTS WHERE DEBT_ID=$id");
    header('location:../views/main.php#debts');
}

if (isset($_POST['debtor_save'])) {

    $debtor_name = $_POST['debtor'];


    $query = "INSERT INTO DEBTORS(DEBTOR_NAME) VALUES ('$debtor_name')";
    mysqli_query($db, $query);
    header('location:../views/main.php#debts');
};
if (isset($_POST['debtor_update'])) {
    $debtor_name = $_POST['debtor'];
    $debtor_id = mysqli_real_escape_string($db, $_POST['Debtor']);

    mysqli_query($db, "UPDATE DEBTORS SET DEBTOR_NAME='$debtor_name'WHERE DEBTOR_ID= $debtor_id");
    header('location:../views/main.php#debts');
}
if (isset($_POST['debtor_del'])) {
    $debtor_id = mysqli_real_escape_string($db, $_POST['Debtor']);

    mysqli_query($db, "DELETE FROM DEBTORS WHERE DEBTOR_ID= $debtor_id");
    header('location:../views/main.php#debts');
}

$debt = "SELECT * FROM DEBTS JOIN DEBTORS ON DEBTS.DEBT_DEBTOR_ID=DEBTORS.DEBTOR_ID";
$results = mysqli_query($db, $debt);
