<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Smoke Games - Admin
    </title>

    <?php 
        if (!isset($_SESSION['id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
            echo "<script type='text/javascript'>location.href = '404.php';</script>";
        }
        include "references.php"; 
    ?>
</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">
        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li>Admin</li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title"> Admin Section </h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active">
                                    <a href="#"><i class="fa fa-list"></i>Admin Rules</a>
                                </li>
                                <li>
                                    <a href="adminReports.php"><i class="fa fa-user"></i>Manage User Reports</a>
                                </li>
                                <li>
                                    <a href="adminGames.php"><i class="fa fa-play"></i>Upload New Game</a>
                                </li>
                                <!-- <li>
                                    <a href="adminUpdates.php"><i class="fa fa-heart"></i>Update Games</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>

                    <div class="col-md-9">
                        <div class="box">
                            <h1>Rules and Responsibilities</h1>
                            <hr>
                            <h3>What it means to be an admin</h3>
                            <p>You are here to help keep the peace, to make sure all our users are having the best expereince they can. By keeping
                                an eye on bad attitudes, and rude behaviour, and banning users, if that's necessary. Also, uploading new games,
                                to keep the site interesting and up-to-date!
                                By agreeing to being an admin, you agree to not abuse this power, to be responsible, not to attempt to damage our site 
                                in any way, if you break our trust, you would lose your admin privileges, and could face a permanant ban.</p>

                            <h3>Making other users admins</h3>
                            <p>You are allowed to upgrade other users to admin status, however, you cannot update just anyone.
                                By being an admin you agree to only upgrade users you know will uphold our community principles of respect and trust,
                                who won't abuse this power. We keep a track of who upgrades each user, if an issue occurs with someone you gave admin 
                                permissions to, you may be downgraded to a regular user. 
                                It is also your responsibily to warn us of any strange activities, surrounding new admins, and reports on particular users.</p>

                            <h3>Reports</h3>
                            <p>Users of the site will submit reports on users they feel have been abusing the site or other users, it's your responsibility to 
                                follow these up, with either a ban or dismisal. And decide when a ban on a user should be lifted.</p>

                            <h3>Games</h3>
                            <p>You are responsible for adding new games to the site. And updating information on other games as you see fit. </p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
    
</body></html>