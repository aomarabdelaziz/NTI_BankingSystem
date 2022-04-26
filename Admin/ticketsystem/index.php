<?php

require '../../helpers/functions.php';
require '../../helpers/checklogin.php';


$Id = $_SESSION['user']['id'];
// $query = "select * from tickets  where status = 'pending'";
$query = "select * from tickets";

$getData = doQuery($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Banking - View Tickets</title>
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
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">My Tickets</li>
                </ol>


                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        Ticket Log
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Transaction ID</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <?php
                                while($raw = mysqli_fetch_assoc($getData))
                                {

                                    ?>
                                    <tr>

                                        <td><?php echo $raw['id'];?></td>
                                        <td><?php echo $raw['transaction_id']; ?></td>
                                        <td><?php echo ucfirst($raw['status']);?></td>
                                        <td>
                                            <?php if($raw['status'] == 'pending'): ?>
                                                <a href='accept.php?id=<?php echo $raw['id'];?>&type=<?php echo $raw['type'] ?>' class='btn btn-success m-r-1em'>Accept</a>
                                                <a href='refuse.php?id=<?php echo $raw['id'];?>&type=<?php echo $raw['type'] ?>'class='btn btn-danger m-r-1em'>Refuse</a>
                                                <?php else:?>
                                               No Action Avaliable
                                        <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <?php include '../../layouts/footer.php' ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/datatables-demo.js"></script>
</body>
</html>
