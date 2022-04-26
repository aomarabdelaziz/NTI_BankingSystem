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
    $op = doQuery("insert into transactions_log (transaction_id , status) values ($id , 'completed')");
    $op = doQuery("select * from transactions where id = $id and type = '$type'");
    $data = mysqli_fetch_assoc($op);
    $op = doQuery("update transactions set status = 'completed' where id = $id ");
    if($data['type'] == 'deposit'){
        // echo "deposit Transcitons";
    #Sender Data
    // $senderID = $_SESSION['user']['id'];
    $query = "Select * from transactions where id = $id";
    $getUsersOp =doQuery($query);
    $transactionData = mysqli_fetch_assoc($getUsersOp);
    $senderID=$transactionData['user_sender_id'];
    $query = "Select * from users where id = $senderID";
    $op = doQuery($query);
    $senderData = mysqli_fetch_assoc($op);
    $senderBalance = $senderData['balance'];
    #Receiver Data
    $query = "Select * from transactions where user_sender_id = $senderID";
    $selectTransctionOP = doQuery($query);
    $receiverData = mysqli_fetch_assoc($selectTransctionOP);
    $receiverID = $receiverData['user_receiver_id'];
    $amount =$receiverData['amount'];
    $query = "Select * from users where id = $receiverID";
    $selectReceiverUserOP = doQuery($query);
    $receiverUserData =mysqli_fetch_assoc($selectReceiverUserOP);
    $receiverBalance = $receiverUserData['balance'];
    #Change Balance For Both Users
    $newReceiverBalance =increaseBalance($receiverBalance,$amount);
    $newSenderBalance =decreaseBalance($senderBalance,$amount);
    $decreaseSql = "update users set balance ='$newSenderBalance' where id =$senderID ";
    $opDecrease =doQuery($decreaseSql);
    $increaseSql = "update users set balance ='$newReceiverBalance' where id =$receiverID ";
    $opIncrease =doQuery($increaseSql);
    }else{
    #Receiver who requests money Data
    $query = "Select * from transactions where id = $id";
    $getUsersOp =doQuery($query);
    $transactionData = mysqli_fetch_assoc($getUsersOp);
    $senderID=$transactionData['user_sender_id'];
    $query = "Select * from users where id = $senderID";
    $op = doQuery($query);
    $senderData = mysqli_fetch_assoc($op);
    $senderBalance = $senderData['balance'];
    #Receiver Data
    $query = "Select * from transactions where user_sender_id = $senderID";
    $selectTransctionOP = doQuery($query);
    $receiverData = mysqli_fetch_assoc($selectTransctionOP);
    $receiverID = $receiverData['user_receiver_id'];
    $amount =$receiverData['amount'];
    $query = "Select * from users where id = $receiverID";
    $selectReceiverUserOP = doQuery($query);
    $receiverUserData =mysqli_fetch_assoc($selectReceiverUserOP);
    $receiverBalance = $receiverUserData['balance'];
    #Updating Balance For Sender And Receiver
    $newReceiverBalance =increaseBalance($receiverBalance,$amount);
    $newSenderBalance =decreaseBalance($senderBalance,$amount);
    $decreaseSql = "update users set balance ='$newSenderBalance' where id =$senderID ";
    $op =doQuery($decreaseSql);
    $increaseSql = "update users set balance ='$newReceiverBalance' where id =$receiverID ";
    $op =doQuery($increaseSql);
    }

    $_SESSION['Message'] = 'Transaction is Accepted';

    header("location: ../index.php");
}



