<?php

require '../helpers/functions.php';
require '../helpers/checklogin.php';


$Id = $_SESSION['user']['id'];

$opUser = doQuery("select * from users where role = 'user'");
$totalUsers = mysqli_num_rows($opUser);


$opTran = doQuery('select * from transactions');
$totalTransactions = mysqli_num_rows($opTran);


$opPendingTickets= doQuery("select * from tickets where status = 'pending'");
$totalPendingTickets = mysqli_num_rows($opPendingTickets);

$opRefusedTickets= doQuery("select * from tickets where status = 'refused'");
$totalRefusedTickets = mysqli_num_rows($opRefusedTickets);

$allTranascations = doQuery("select * from transactions");



function getEmailById($id){
    $op = doQuery("Select email from users where id = $id");
    return mysqli_fetch_assoc($op)['email'];
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
    <title>Online Banking - Admin Dashboard</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

</head>
<body class="sb-nav-fixed">
<?php include '../layouts/navBar.php' ?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <?php include '../layouts/sideNav.php' ?>
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

                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Total Users</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#"><?php echo $totalUsers  ?></a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Transcations</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#"><?php echo $totalTransactions ?></a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Pending Tickets</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#"><?php echo $totalPendingTickets ?></a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Refused Tickets</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="#"><?php echo $totalRefusedTickets ?></a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                Messages();
                ?>
                <div class="card mb-4">

                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Transactions Log
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="50px">ID</th>
                                    <th>Type</th>
                                    <th>Recipient</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <!-- if Status = pending admin can control transction else he wouldnt-->
                                <?php
                                while($raw = mysqli_fetch_assoc($allTranascations))
                                {
                                    if($raw['status'] == 'pending'){

                                        ?>
                                    <tr>
                                        <?php
                                        $email = getEmailById($raw['user_receiver_id']);
                                        
                                        ?>
                                        <td><?php echo $raw['id'];?></td>
                                        <td><?php echo ucfirst($raw['type']); ?></td>
                                        <td><?php echo ($email == $_SESSION['user']['email'] ? 'You' : $email) ?></td>
                                        <td><?php echo ucfirst($raw['status']);?></td>
                                        <td><?php echo $raw['amount'];?>$</td>
                                        <td><?php echo $raw['reason'];?></td>
                                        <td> 
                                            <a href='accept.php?id=<?php echo $raw['id'];?>&type=<?php echo $raw['type'] ?>' class='btn btn-success m-r-1em'>Accept</a>
                                            <a href='refuse.php?id=<?php echo $raw['id'];?>&type=<?php echo $raw['type'] ?>'class='btn btn-danger m-r-1em'>Refuse</a>
                                        </td>
                                    </tr>
                                    <?php
                                }else{
                                    ?>
                                    <tr>
                                    <?php
                                    $email = getEmailById($raw['user_receiver_id']);
                                    
                                    ?>
                                    <td><?php echo $raw['id'];?></td>
                                    <td><?php echo ucfirst($raw['type']); ?></td>
                                    <td><?php echo ($email == $_SESSION['user']['email'] ? 'You' : $email) ?></td>
                                    <td><?php echo ucfirst($raw['status']);?></td>
                                    <td><?php echo $raw['amount'];?>$</td>
                                    <td><?php echo $raw['reason'];?></td>
                                    <td>No Action Avaliable</td>
                                </tr>
                                <?php
                            }
                            }
                               

                                ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <?php include '../layouts/footer.php' ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../assets/demo/chart-area-demo.js"></script>
<script src="../assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="../assets/demo/datatables-demo.js"></script>
</body>
</html>
