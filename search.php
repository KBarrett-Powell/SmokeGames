<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Smoke Games - Search
    </title>

    <?php include "references.php"; ?>
</head>
<body>
    <?php 
        include "navigation.php"; 
        $search = $_GET['searchvalue'];
    ?>
    <div id="all">
        <div id="content">
            <div id="hot">
                <div class="container">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li>Search</li>
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="col-md-12">
                        <?php echo "<h2>Search Results For '$search'</h2>"; ?>
                    </div>
                </div>
                
                <div class="container">
                    <div class="col-md-12">
                        <?php echo "<a href='gamesSearch?searchvalue=$search'<h3>Games -- See All</h3></a>"; ?>
                        <hr>
                    </div>
                </div>

                <div class="container">

                        <?php
                            try{
                                include "config.php";

                                // SQL Query to return 5 games linked to the search value
                                $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE CONCAT_WS(' ', Gname, Description) LIKE ? LIMIT 5");
                                $retrieve->execute(['%'.$search.'%']);
                                
                                if ($retrieve->rowCount() > 0) {
                                    echo "<div class='product-slider'>";

                                    foreach ($retrieve as $row) {
                                        $id = $row["GameID"];
                                        $name = $row["Gname"];
                                        $img = $row["Gimg1"];
                                        echo "<div class='item'><div class='product'><div class='flip-container'>";
                                        echo "<div class='flipper'><div class='front'>";
                                        echo "<a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div>";
                                        echo "<div class='back'><a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div></div></div>";
                                        echo "<a href='detail.php?id=$id' class='invisible'><img src='$img' alt='' class='img-responsive'></a>";
                                        echo "<div class='text'><h3><a href='detail.php?id=$id'>$name</a></h3>";
                                        echo "</div></div></div>";
                                    }

                                    echo "</div>";
                                } else { echo "<p style='margin-left:2%'>-- No results --</p>";}

                            }catch(PDOException $e) {
                                echo "<script type='text/javascript'>location.href = '404.php'";
                            }
                            $gamesdb = null;
                        ?>
                </div>

                <div class="container">
                    <div class="col-md-12">
                        <?php echo "<a href='userSearch?searchvalue=$search'<h3>Users -- See All</h3></a>"; ?>
                        <hr>
                    </div>
                </div>

                <div class="container">
                        <?php
                            try{
                                include "config.php";

                                // SQL Query to return 5 user profiles linked to the search value
                                $retrieve = $gamesdb->prepare("SELECT * FROM Profiles WHERE ProName LIKE ? LIMIT 5");
                                $retrieve->execute(['%'.$search.'%']);
                                
                                if ($retrieve->rowCount() > 0) {
                                    echo "<div class='product-slider'>";

                                    foreach ($retrieve as $row) {
                                        $uid = $row["UID"];
                                        $pname = $row["ProName"];
                                        $img = $row["ProPic"];
                                        
                                        echo "<div class='item'><div class='product'><div class='flip-container'>";
                                        echo "<div class='flipper'><div class='front'>";
                                        echo "<a href='profile.php?id=$uid'><img src='images/userProfiles/$img' class='img-user'></a></div>";
                                        echo "<div class='back'><a href='profile.php?id=$uid'><img src='images/userProfiles/$img' alt='' class='img-user'></a></div></div></div>";
                                        echo "<a href='profile.php?id=$uid' class='invisible'><img src='images/userProfiles/$img' class='img-user'></a>";
                                        echo "<div class='text'><h3><a href='profile.php?id=$uid''>$pname</a></h3>";
                                        echo "</div></div></div>";
                                    }

                                    echo "</div>";
                                } else { echo "<p style='margin-left:2%'>-- No results --</p>";}

                            }catch(PDOException $e) {
                                echo "<script type='text/javascript'>location.href = '404.php'";
                            }
                            $gamesdb = null;
                        ?>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>