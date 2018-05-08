<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Smoke Games - Admin User Reports
    </title>

    <?php 
        if (!isset($_SESSION['id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
            echo "<script type='text/javascript'>location.href = '404.php';</script>";
        }
        include "references.php"; 

        try{
            include "config.php";
            
            if($_SERVER["REQUEST_METHOD"] == "POST") {
    
                // If login form has been filled out:
                if(isset($_POST['ban_user'])) {
                    $rid = $_POST['ban_user'];
                    $dateBan = date('Y-m-d');
    
                    // Update report in database
                    $retrieve = $gamesdb->prepare("UPDATE Reports SET Banned = 1 AND DateBan = ? WHERE ReportNum = ?");
                    $retrieve->execute([$dateBan, $rid]);
    
                    echo "<script type='text/javascript'>alert('User Banned Successfully.');</script>";

                } else if(isset($_POST['delReport'])) {
                    $rid = $_POST['delReport'];

                    // Delete report from database
                    $deleteRep = $gamesdb->prepare("DELETE FROM Reports WHERE ReportNum = ?");
                    $deleteRep->execute([$rid]);
                }
            } 
        }catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $gamesdb = null;
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
                                <li>
                                    <a href="admin.php"><i class="fa fa-list"></i>Admin Rules</a>
                                </li>
                                <li class="active">
                                    <a href="#"><i class="fa fa-user"></i>Manage User Reports</a>
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

                        <h1>User Reports & Bans</h1>
                        <p class='lead'>This is where you can view unresolved reports, and user bans. And decide whether to ban a user due to a report, 
                            delete the report, or unban a user</p>
                        <hr>

                        <h3>Unresolved Reports</h3>
                        <div class="table-responsive">
                            <table class='table'>
                            <tr><th>User Reported</th><th>Report</th><th>Reporting User</th><th>Options</th></tr>
                            <?php 
                                try{
                                    include "config.php";

                                    // Retrieve all unresolved reports
                                    $retrieve = $gamesdb->prepare("SELECT * FROM Reports WHERE Banned = 0");
                                    $retrieve->execute();

                                    if ($retrieve->rowCount() > 0) {
                                        // For each report, display the user the report was made on, and the report description
                                        foreach ($retrieve as $row) {
                                            $rid = $row['ReportNum'];
                                            $user = $row['UID1'];
                                            $report = $row['Report'] + $row['Rdesc'];
                                            $user2 = $row['UID2'];

                                            echo "<form method='post'>";
                                            echo "<tr><td>$user</td><td>$report</td><td>$user2</td>";
                                            echo "<td><button class='btn btn-primary' type='submit' name='banUser' value='$rid'>Ban User</button>";
                                            echo "<button class='btn btn-primary' type='submit' name='delReport' value='$rid'>Delete Report</button></td></tr></form>";
                                        }
                                    } else {
                                        // If they're aren't any reports that need admin response:
                                        echo "<td>--No Unresolved Reports--</td>";
                                    }
                                            
                                }catch(PDOException $e) {
                                    echo "Connection failed: " . $e->getMessage();
                                }
                                $gamesdb = null;
                            ?>  
                            </table>
                        </div>
                        
                        <h3>Currently Banned Users</h3>
                        <div class="table-responsive">
                            <table class='table'>
                            <tr><th>User Banned</th><th>Banned For</th><th>Date</th><th>Options</th></tr>
                            <?php 
                                try{
                                    include "config.php";

                                    // Retrieve all reports with a banned user
                                    $retrieve = $gamesdb->prepare("SELECT * FROM Reports WHERE Banned = 1");
                                    $retrieve->execute();

                                    if ($retrieve->rowCount() > 0) {
                                        // For each report, display the user the report was made on, and the report description
                                        foreach ($retrieve as $row) {
                                            $rid = $row['ReportNum'];
                                            $user = $row['UID1'];
                                            $report = $row['Report'] + $row['Rdesc'];
                                            $date = $row['DateBan'];

                                            echo "<form method='post'>";
                                            echo "<tr><td>$user</td><td>$report</td><td>$date</td>";
                                            echo "<td><button class='btn btn-primary' type='submit' name='delReport' value='$rid'>End Ban</button></td></tr></form>";
                                        }
                                    } else {
                                        // If they're aren't any current banned users, display: 
                                        echo "<td>--No Current Banned Users--</td>";
                                    }
                                            
                                }catch(PDOException $e) {
                                    echo "Connection failed: " . $e->getMessage();
                                }
                                $gamesdb = null;
                            ?>  
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
    
</body></html>