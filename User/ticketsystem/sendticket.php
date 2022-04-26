<?php

require '../../helpers/functions.php';
require '../../helpers/checklogin.php';


# Fetch Id Data ....
$Id = $_SESSION['user']['id'];
$query = "select * from users where id = $Id";
$op = doQuery("select * from transactions where user_sender_id = $Id || user_receiver_id = $Id");



if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    $transaction_id = clean($_POST['transaction_id']);
    $reason = clean($_POST['reason']);


    # Error []
    $errors = [];

    # Validate Reason
    if (!validate($reason, 'required')) {
        $errors['Reason'] = "Field Required";
    } elseif (!validate($reason, 'string' , 50)) {
        $errors['Reason'] = "Reason must be >= 50";
    }


    # Check Errors ....
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    }else {
        $sql = "insert into tickets (user_id,transaction_id,reason) values ($Id,$transaction_id,'$reason')";

        $op = doQuery($sql);
        if ($op) {

            $message = ["success" => "Ticket is in pending"];
            $_SESSION['Message'] = $message;
        }
        else {
            $message = ["Error" => "Try Again"];
            $_SESSION['Message'] = $message;
        }


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
    <title>Online Banking - Send Ticket</title>
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
                <h1 class="mt-4">Send Ticket</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">
                        <?php
                        # Print Messages ....
                        Messages('Dashboard / Send Ticket');
                        ?>

                    </li>
                </ol>

                <div class="row">
                    <div class="col-md-12">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="inputConfirmPassword">Transaction ID</label>
                                        <select  id="country" name="transaction_id" class="form-control">
                                            <?php
                                            while( $row = mysqli_fetch_assoc($op)){
                                                echo "<option value='".$row['id']."'>".$row['id']."</option>";
                                            }
                                            ?>
                                        </select>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputLastName">Reason</label>
                                            <textarea  class="form-control" name="reason" id="" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <button class="form-control btn btn-primary btn-block">Send Ticket</button>

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
