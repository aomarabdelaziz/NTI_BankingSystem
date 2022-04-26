<?php

$id = $_GET['id'];
$type = $_GET['type'];

require '../../helpers/functions.php';
require '../../helpers/checklogin.php';

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

    $op = doQuery("update tickets set status = 'refused' where id = $id ");
    $_SESSION['Message'] = 'Ticket is Refused';

    header("location: ../index.php");
}



