<?php

require '../../helpers/functions.php';
require '../../helpers/checklogin.php';


# Fetch Id Data ....

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $email = clean($_POST['email']);
    $amount = clean($_POST['amount']);
    $reason = clean($_POST['reason']);
    #transction Data

    #Sender Data
    $senderID = $_SESSION['user']['id'];
    $query = "Select * from users where id = '$senderID'";
    $op = doQuery($query);
    $senderData = mysqli_fetch_assoc($op);
    $senderBalance = $senderData['balance'];

    #Receiver Data
    $query = "Select * from users where email = '$email'";
    $op = doQuery($query);
    $receiverData = mysqli_fetch_assoc($op);
    $receiverID = $receiverData['id'];
    $receiverBalance = $receiverData['balance'];

    # Error []
    $errors = [];


    # Validate Email
    if (!validate($email, 'required')) {
        $errors['Email'] = "Field Required";
    } elseif (!validate($email, 'email')) {
        $errors['Email'] = "Invalid Format";
    } elseif (validate($email, 'email_not_exist')) {
        $errors['Email'] = "Email is not exist";
    } elseif($email == $_SESSION['user']['email']){
        $errors['Email'] = "You Cannot Send Money To Ur Self Choose Different Email";

    }


    # Validate Amount
    if (!validate($amount, 'required')) {
        $errors['Amount'] = "Field Required";
    } elseif (!validate($amount, 'int' , 1)) {
        $errors['Amount'] = "Amount must be >= 1$";
     }else if($amount > $senderBalance){
        $errors['Amount'] = "Your Balance Is Not Enough";
    }

    # Validate Reason
    if (!validate($reason, 'required')) {
        $errors['Reason'] = "Field Required";
    } elseif (!validate($reason, 'string' , 50)) {
        $errors['Reason'] = "Reason must be >= 50";
    }

    # Check Errors ....
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    }
    else
    {
        $receiverID = $receiverData['id'];
        $sql = "insert into transactions (user_sender_id,user_receiver_id,type,amount,reason) values ($senderID,$receiverID,'deposit', $amount,'$reason')";
        $op  = doQuery($sql);

        # U Cannot Get Updated Balance From Session
        // $senderBalance = $_SESSION['user']['balance'];
        if ($op) {         
            $message = ["success" => "Transaction is in pending"];
            
            // #Updating Balance For Sender And Receiver
            // $newReceiverBalance =increaseBalance($receiverBalance,$amount);
            // $newSenderBalance =decreaseBalance($senderBalance,$amount);
            // $decreaseSql = "update users set balance ='$newSenderBalance' where id =$senderID ";
            // $op =doQuery($decreaseSql);
            // $increaseSql = "update users set balance ='$newReceiverBalance' where id =$receiverID ";
            // $op =doQuery($increaseSql);
        } else {
            $message = ["Error" => "Try Again"];
        }
        $_SESSION['Message'] = $message;
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="../../assets/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<?php include '../../layouts/navBar.php' ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <?php include '../../layouts/sideNav.php' ?>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php echo $_SESSION['user']['firstname'] .', ' . $_SESSION['user']['lastname'] ?>
            </div>
        </nav>
    </div>


    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Send Money</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">
                       <?php
                       # Print Messages ....
                       Messages('Dashboard / Send Money');
                       ?>

                    </li>
                </ol>

                <div class="row">
                   <div class="col-md-12">
                       <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                           <div class="form-row">
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label class="small mb-1" for="inputFirstName">Receiver Email</label>
                                       <input name="email" class="form-control py-4" id="inputFirstName" type="email" placeholder="Enter Email" />
                                   </div>
                               </div>
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label class="small mb-1" for="inputLastName">Amount</label>
                                       <input name="amount" class="form-control py-4" id="inputLastName" type="number" placeholder="Enter Amount" />
                                   </div>
                               </div>
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label class="small mb-1" for="inputLastName">Reason</label>
                                       <textarea  class="form-control" name="reason" id="" cols="30" rows="5"></textarea>
                                   </div>
                               </div>
                           </div>
                           <button class="form-control btn btn-primary btn-block">Send Money</button>

                       </form>
                   </div>

                </div>


            </div>
        </main>
        <?php include '../../layouts/footer.php'?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../../assets/demo/chart-area-demo.js"></script>
<script src="../../assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="../../assets/demo/datatables-demo.js"></script>
</body>
</html>
