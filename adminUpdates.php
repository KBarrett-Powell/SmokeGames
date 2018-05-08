<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Smoke Games - Admin Games Update
    </title>

    <?php 
        if (!isset($_SESSION['id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
            echo "<script type='text/javascript'>location.href = '404.php';</script>";
        }
        include "references.php"; 
    ?>
</head>
<body>
    <?php 
        include "navigation.php"; 
    ?>
    <div id="all">
        <div id="content">
            <div id="hot">
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
                                    <li>
                                        <a href="adminReports.php"><i class="fa fa-user"></i>Manage User Reports</a>
                                    </li>
                                    <li>
                                        <a href="adminGames.php"><i class="fa fa-play"></i>Upload New Game</a>
                                    </li>
                                    <li class="active">
                                        <a href="#"><i class="fa fa-heart"></i>Update Games</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="product-slider">

                        <?php
                            try{
                                include "config.php";

                                if ($search !== "") {
                                    // SQL Query to return 5 games linked to the search value
                                    $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE CONCAT_WS(' ', Gname, Description) LIKE ?");
                                    $retrieve->execute(['%'.$search.'%']);
                                    
                                    if ($retrieve->rowCount() > 0) {
                                        foreach ($retrieve as $row) {
                                            $id = $row["GameID"];
                                            $name = $row["Gname"];
                                            $img = $row["Gimg1"];
                                            echo "<div class='item'><div class='product'>";
                                            echo "<input type='image' name='chooseGame' value='$id' src='$img' alt='' class='img-responsive'>";
                                            echo "<h3>$name</h3>";
                                            echo "</div></div>";
                                        }
                                    } else { echo "<p>-- No results --</p>";}
                                } else { echo "<p>--Please Enter Something in the Search Bar.--</p>";}

                            }catch(PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }
                            $gamesdb = null;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "footer.php"; ?>

</body>
</html>