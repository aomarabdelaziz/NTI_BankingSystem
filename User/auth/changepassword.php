<?php
require '../helpers/functions.php';
require '../helpers/checklogin.php';
# Fetch Id Data ....
$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $password = clean($_POST['password']);
    $password_confirmation = clean($_POST['password_confirmation']);

    # Error []
    $errors = [];

    # Validate password
    if (!validate($password, 'required')) {
        $errors['Password'] = "Field Required";
    } elseif (!validate($password, 'min' , 6)) {
        $errors['Password'] = "Field Length must be >= 6 chars";
    }

    # Validate password confirmation
    if (!validate($password_confirmation, 'required')) {
        $errors['Password Confirmation'] = "Field Required";
    } elseif (!validate($password_confirmation, 'min' , 6)) {
        $errors['Password Confirmation'] = "Field Length must be >= 6 chars";
    } elseif (!validate($password_confirmation, 'password_confirmation' , 6 , $password)) {
        $errors['Password Confirmation'] = "The password is not the same";
    }

    # Check Errors ....
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    }
    else {

        $md5Password = md5($password);
        $sql = "update users set password = '$md5Password' where id = $userId";

        $op =  mysqli_query($con, $sql);

        if ($op) {
            $message =  'Password updated';
            # Set Message to Session

            $_SESSION['Message'] = $message;

            header("location: index.php");
        } else {
            echo 'Error Try Again ' . mysqli_error($con);
        }
    }
}