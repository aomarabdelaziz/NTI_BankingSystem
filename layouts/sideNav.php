

<div class="nav">
    <div class="sb-sidenav-menu-heading">Core</div>
    <a class="nav-link" href="<?php echo url('index.php') ?>">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
    </a>
    <div class="sb-sidenav-menu-heading">Interface</div>

    <?php if($_SESSION['user']['role'] != 'admin'): ?>

        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
            Transactions
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
        </a>
        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link" href="<?php echo url('User/transactions/sendmoney.php') ?>">Send Money</a>
                <a class="nav-link" href="<?php echo url('User/transactions/recievemoney.php') ?>">Recieve Money</a>
            </nav>
        </div>
    <?php endif ;?>


    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
        Profile
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
            <a class="nav-link" href="<?php echo url('User/edit.php') ?>">Edit</a>

        </nav>
    </div>

    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTicket" aria-expanded="false" aria-controls="collapsePages">
        <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
        Ticket
        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
    </a>
    <div class="collapse" id="collapseTicket" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
            <?php if($_SESSION['user']['role'] != 'admin'): ?>
                <a class="nav-link" href="<?php echo url('User/ticketsystem/sendticket.php') ?>">Open Ticket</a>
                <a class="nav-link" href="<?php echo url('User/ticketsystem/index.php') ?>">View Tickets</a>
            <?php else:?>
                <a class="nav-link" href="<?php echo url('Admin/ticketsystem/index.php') ?>">View Tickets</a>

            <?php endif;?>

        </nav>
    </div>
    <!--         <div class="sb-sidenav-menu-heading">Addons</div>
             <a class="nav-link" href="charts.html">
                 <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                 Charts
             </a>
             <a class="nav-link" href="tables.html">
                 <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                 Tables
             </a>-->
</div>