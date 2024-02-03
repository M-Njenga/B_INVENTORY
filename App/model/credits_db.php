<?php

include('connection.php');

$creditor = '';
$credit_desc = "";
$credit_amount = "";
$credit_date = "";
$id = 0;
$edit_state = false;




if (isset($_POST['save'])) {
    $credit_desc = $_POST['credit_desc'];
    $credit_amount = $_POST['credit_amount'];

    $credit_date = $_POST['credit_date'];
    $creditor_id = mysqli_real_escape_string($db, $_POST['Creditor']);



    $creditors_query = "SELECT * FROM CREDITORS WHERE CREDITOR_ID= '$creditor_id'";
    $creditors = mysqli_query($db, $creditors_query);

    if (mysqli_num_rows($creditors) < 1) {

        $new_creditor = "INSERT INTO CREDITORS(CREDITOR_ID) VALUES('$creditor_id ')";
        mysqli_query($db, $new_creditor);
    }

    $creditors_query = "SELECT * FROM CREDITORS WHERE CREDITOR_ID= '$creditor_id '";
    $creditors = mysqli_query($db, $creditors_query);
    if (mysqli_num_rows($creditors) > 0) {

        while ($row = mysqli_fetch_assoc($creditors)) {
            $creditor_id = (int)$row["CREDITOR_ID"];
        }
    }

    $existing_pay_query = "SELECT CREDIT_UPDATE_ID,CREDIT_UPDATE_BAL FROM CREDIT_UPDATES 
    JOIN CREDITS ON CREDIT_UPDATES.CREDIT_UPDATE_CREDITOR_ID=CREDITS.CREDIT_CREDITOR_ID 
    WHERE CREDIT_UPDATE_CREDITOR_ID= $creditor_id";

    $existing_pay = mysqli_query($db, $existing_pay_query);



    if (mysqli_num_rows($existing_pay) > 0) {

        while ($row = mysqli_fetch_assoc($existing_pay)) {
            $bal = $row["CREDIT_UPDATE_BAL"];
            $update_id = $row["CREDIT_UPDATE_ID"];
        }
        $credit_bal = $bal + $credit_amount;

        $update_query = "UPDATE CREDIT_UPDATES SET CREDIT_UPDATE_BAL='$credit_bal'  WHERE CREDIT_UPDATE_ID =$update_id";
        mysqli_query($db, $update_query);

        header('location:../views/main.php#credits');
    }




    $credit_query = "INSERT INTO CREDITS(CREDIT_DESC,CREDIT_AMOUNT,CREDIT_CREDITOR_ID,CREDIT_DATE) 
    VALUES ('$credit_desc','$credit_amount','$creditor_id','$credit_date')";
    mysqli_query($db, $credit_query);
    $credit_update_query;
    header('location:../views/main.php#credits');
};

if (isset($_POST['update'])) {
    $credit_desc = mysqli_real_escape_string($db, $_POST['credit_desc']);

    $credit_amount = mysqli_real_escape_string($db, $_POST['credit_amount']);
    $creditor_id = mysqli_real_escape_string($db, $_POST['Creditor']);
    $credit_id = mysqli_real_escape_string($db, $_POST['credit_id']);


    mysqli_query($db, "UPDATE CREDITS SET CREDIT_DESC='$credit_desc', 
    CREDIT_AMOUNT='$credit_amount', CREDIT_CREDITOR_ID=$creditor_id WHERE CREDIT_ID=$credit_id");
    header('location:../views/main.php#credits');
}

function new_credit($creditor_id, $db, $payment, $credit_paid_date)
{
    $total_credit = 0;
    $existing_credits_query = "SELECT CREDIT_AMOUNT FROM CREDITS 
    WHERE CREDIT_CREDITOR_ID= $creditor_id";

    $existing_credit = mysqli_query($db, $existing_credits_query);



    if (mysqli_num_rows($existing_credit) > 0) {



        while ($row = mysqli_fetch_assoc($existing_credit)) {


            $total_credit += $row["CREDIT_AMOUNT"];
        }
        $credit_bal = $total_credit - $payment;


        $update_query = "INSERT INTO CREDIT_UPDATES(CREDIT_UPDATE_TOTAL_CREDIT,CREDIT_UPDATE_PAID_AMOUNT,
        CREDIT_UPDATE_BAL,CREDIT_UPDATE_CREDITOR_ID,CREDIT_UPDATE_DATE)
     VALUES ('$total_credit','$payment','$credit_bal','$creditor_id','$credit_paid_date')";
        mysqli_query($db, $update_query);
        if ($credit_bal == 0) {
            mysqli_query($db, "DELETE  FROM CREDITS WHERE CREDITT_CREDITOR_ID=$creditor_id");
        }
    }
}
if (isset($_POST['paid_credit'])) {

    $payment = $_POST['paid_amount'];
    $creditor_id = $_POST['Creditor'];
    $credit_paid_date = $_POST['credit_date'];

    $payment_history_query = "SELECT CREDIT_UPDATE_BAL FROM CREDIT_UPDATES 
    JOIN CREDITS ON CREDIT_UPDATES.CREDIT_UPDATE_CREDITOR_ID=CREDITS.CREDIT_CREDITOR_ID 
    WHERE CREDIT_UPDATE_CREDITOR_ID= $creditor_id";

    $payment_history = mysqli_query($db, $payment_history_query);



    if (mysqli_num_rows($payment_history) > 0) {



        while ($row = mysqli_fetch_assoc($payment_history)) {
            $bal = $row["CREDIT_UPDATE_BAL"];
        }
        if ($bal != 0) {

            $credit_bal = $bal - $payment;
            if ($credit_bal >= 0) {
                $update_query = "INSERT INTO CREDIT_UPDATES(CREDIT_UPDATE_TOTAL_CREDIT,
                CREDIT_UPDATE_PAID_AMOUNT,CREDIT_UPDATE_BAL,CREDIT_UPDATE_CREDITOR_ID,CREDIT_UPDATE_DATE)
                VALUES ('$bal','$payment','$credit_bal','$creditor_id','$credit_paid_date')";
                mysqli_query($db, $update_query);
                if ($credit_bal == 0) {
                    mysqli_query($db, "DELETE  FROM CREDITS WHERE CREDIT_CREDITOR_ID=$creditor_id");
                }
            }
        } else {
            new_credit($creditor_id, $db, $payment, $credit_paid_date);
        }



        header('location:../views/main.php#credits');
    } else {

        new_credit($creditor_id, $db, $payment, $credit_paid_date);
        header('location:../views/main.php#credits');
    }
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE  FROM CREDITS WHERE CREDIT_ID=$id");
    header('location:../views/main.php#credits');
}
if (isset($_POST['creditor_save'])) {

    $creditor_name = $_POST['creditor'];


    $query = "INSERT INTO CREDITORS(CREDITOR_NAME) VALUES ('$creditor_name')";
    mysqli_query($db, $query);
    header('location:../views/main.php#credits');
};
if (isset($_POST['creditor_update'])) {
    $creditor_name = $_POST['creditor'];
    $creditor_id = mysqli_real_escape_string($db, $_POST['Creditor']);
    mysqli_query($db, "UPDATE CREDITORS SET CREDITOR_NAME='$creditor_name'WHERE CREDITOR_ID= $creditor_id");
    header('location:../views/main.php#credits');
}
if (isset($_POST['creditor_del'])) {
    $creditor_id = mysqli_real_escape_string($db, $_POST['Creditor']);

    mysqli_query($db, "DELETE FROM CREDITORS WHERE CREDITOR_ID= $creditor_id");
    header('location:../views/main.php#credits');
}

$credit = "SELECT * FROM CREDITS JOIN CREDITORS ON CREDITS.CREDIT_CREDITOR_ID=CREDITORS.CREDITOR_ID";
$results = mysqli_query($db, $credit);
