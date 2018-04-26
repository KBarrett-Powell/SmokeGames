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
        if (!isset($_SESSION['username']) || !isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
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
                                    <a href="adminGames.php"><i class="fa fa-heart"></i>Manage Games</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="box">
                            <h3>Rules and Responsibilities</h3>

                            <h4>Making other users admins</h4>
                            <p>You are allowed to upgrade other users to admin status, however, you cannot update just anyone.
                            By being an admin you agree to only upgrade users you know will uphold our community principles of respect and trust</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>
    
</body></html>


<?php
    // Creating neat display for reports and upload games forms
    echo "<table width='100%'><col width='50%'><col width='50%'><tr><th>Reports</th><th>Upload Games</th></tr><tr><td style='vertical-align:top'>";
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    echo "<table class=scorestab><tr><th>ID</th><th>Report</th></tr>";
    $retrieve = "SELECT * FROM Reports WHERE Resolved = false;";
    $result = mysqli_query($gamesdb, $retrieve);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['UserID1'];
            $report = $row['Report'];

            echo "<tr><td>$id</td><td>$report</td></tr>";
        }
        echo "</table></td>";
    } else {
        echo "<tr><td colspan='2'>--No Unresolved Reports Found--</td></tr></table></td>";
    }

    echo "</td><td style='padding-top:2%'><form class=proeditform onSubmit='' name='upload'><input type='file' id='newgame' name='newgame'><br>";
    echo "Game ID: <input type='text' id='gameid' name='gameid'><br>";
    echo "Game Name: <input type='text' id='gname' name='gname'><br>";
    echo "Description: <input type='text' id='desc' name='desc'><br>";
    echo "Banner Image: <input type='file' id='img1' name='img1'><br>";
    echo "Small Image: <input type='file' id='img2' name='img2'><br>";
    echo "<input class=button type='submit' value='Upload Game'></form><br></td></tr></table>";


?>