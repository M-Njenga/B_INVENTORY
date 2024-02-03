<?php

include('connection.php');

session_start();
$username = "";
$password = "";
$role = "";
$user_id = 0;
$edit_state = false;



if (isset($_POST['register'])) {

    $username = ucfirst($_POST['username']);
    $password = (password_hash(('1234'), PASSWORD_BCRYPT));
    $role = ($_POST['role']);

    $users = "SELECT*FROM LOGIN WHERE LOGIN_USERNAME='$username' ";
    $users_query = mysqli_query($db, $users);

    if (mysqli_num_rows($users_query) < 1) {

        $user_query = "INSERT INTO LOGIN(LOGIN_USERNAME,LOGIN_ROLE,LOGIN_PASSWORD)
     VALUES ('$username','$role','$password')";
        mysqli_query($db, $user_query);
    } else {

        echo "<script>if(!alert('User already registered')){window.location.href = '/B_inventory/';}</script>";
    }


    header('location:../views/main.php#users');
};
if (isset($_POST['user_update'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);

    $role = mysqli_real_escape_string($db, $_POST['role']);
    $id = mysqli_real_escape_string($db, $_POST['id']);

    mysqli_query($db, "UPDATE LOGIN SET LOGIN_USERNAME='$username', LOGIN_ROLE='$role' WHERE LOGIN_ID=$id");
    header('location:../views/main.php#users');
}
if (isset($_GET['user_del'])) {
    $id = $_GET['user_del'];
    mysqli_query($db, "DELETE FROM LOGIN WHERE LOGIN_ID=$id");
    header('location:../views/main.php#users');
}
if (isset($_GET['password_reset'])) {
    $id = $_GET['password_reset'];
    $password = (password_hash(('1234'), PASSWORD_BCRYPT));
    mysqli_query($db, "UPDATE LOGIN SET LOGIN_PASSWORD='$password' WHERE LOGIN_ID='$id'");
    header('location:../views/main.php#users');
}


if (isset($_POST['pass_update'])) {

    $new_pass = $_POST['new_pass'];
    $pass_confirmation = $_POST['con_pass'];
    $username = $_POST['username'];
    $password = (password_hash(($new_pass), PASSWORD_BCRYPT));


    $uppercase = preg_match('@[A-Z]@', $new_pass);
    $lowercase = preg_match('@[a-z]@', $new_pass);
    $number    = preg_match('@[0-9]@', $new_pass);
    $specialChars = preg_match('@[^\w]@', $new_pass);


    if ($new_pass == $pass_confirmation) {

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($new_pass) < 8) {

            echo "<script>if(!alert('Password should be at least 8 characters in length and should include at least
            one upper case letter, one number, and one special character.'')){window.location.href = '/b_inventory/App/views/change_pass.php';}</script>";
        } else {

            mysqli_query($db, "UPDATE LOGIN SET LOGIN_PASSWORD='$password' WHERE LOGIN_USERNAME='$username'");
            header('location:/b_inventory/');
        }
    } else {

        echo "<script>if(!alert('Password mismatch')){window.location.href = '/b_inventory/App/views/change_pass.php';}</script>";
    }
}


if (isset($_POST['login'])) {

    $secret = '6Lcua_sgAAAAAELSob-BxFmpubPZEITtAXBE0TWW';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret'   =>  $secret,
        'response' => $_POST['g-recaptcha-response'],
    ]));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = curl_exec($ch);

    curl_close($ch);

    $response = @json_decode($data);

    if ($response && $response->success) {
        try {

            $users = "SELECT LOGIN_PASSWORD , LOGIN_ROLE FROM LOGIN WHERE LOGIN_USERNAME='$username' ";
            $user = mysqli_query($db, $users);

            if (mysqli_num_rows($user) > 0) {

                while ($row = mysqli_fetch_assoc($user)) {
                    $user_password = $row['LOGIN_PASSWORD'];
                    $login_role = $row['LOGIN_ROLE'];
                    $_SESSION['role'] = $login_role;
                }


                if (password_verify($password, $user_password)) {

                    if ($password == 1234) {

                        $_SESSION['username'] = ucfirst($username);

                        header('location:/B_inventory/app/views/change_pass.php');
                    } else {

                        $_SESSION['username'] = ucfirst($username);
                        $_SESSION['role'] = $login_role;

                        header('location:/B_inventory/app/views/main.php');
                    }
                } else {
                    echo "<script>if(!alert('Incorrect username or password')){window.location.href = '/B_inventory/';}</script>";
                }
            } else {
                echo "<script>if(!alert('Incorrect username or password')){window.location.href = '/B_inventory/';}</script>";
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    } else {

        echo "<script>if(!alert('Error in Google reCAPTACHA')){window.location.href = '/B_inventory/';}</script>";
    }
};
$users = "SELECT * FROM LOGIN ";
$results = mysqli_query($db, $users);
