<?php

$id = $_GET['id'];


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

    $op = doQuery("update tickets set status = 'completed' where id = $id ");
    $_SESSION['Message'] = 'Ticket is Accepted';

    header("location: ../index.php");
  
}



