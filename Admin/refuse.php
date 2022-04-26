<?php

$id = $_GET['id'];
$type = $_GET['type'];

require '../helpers/functions.php';
require '../helpers/checklogin.php';

$errors = [];

# Validate phone
if (!validate($id, 'int' , 1)) {
    $errors['mobile'] = "Field Required";
}


# Check Errors ....
if (count($errors) > 0) {
    $_SESSION['Message'] = $errors;

}
else
{
    $op = doQuery("insert into transactions_log (transaction_id , status) values ($id , 'refused')");
    $op = doQuery("select * from transactions where id = $id and type = '$type'");
    $data = mysqli_fetch_assoc($op);
    $op = doQuery("update transactions set status = 'refused' where id = $id ");

    $_SESSION['Message'] = 'Transaction is refused';

    header("location: ../index.php");
}



