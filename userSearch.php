<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Smoke Games - User Search
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
                            <?php echo "<li><a href='search.php?searchvalue=$search'>Main Search</a></li>"; ?>
                            <li>User Search</li>
                        </ul>
                    </div>
                </div>

                <div class="container">
                    <div class="col-md-12">
                        <?php echo "<h2>Search Results For '$search' In Users</h2>"; ?>
                    </div>
                </div>

                <div class="container">
                        <?php
                            try{
                                include "config.php";

                                // SQL Query to return 5 user profiles linked to the search value
                                $retrieve = $gamesdb->prepare("SELECT * FROM Profiles WHERE ProName LIKE ?");
                                $retrieve->execute(['%'.$search.'%']);
                                
                                if ($retrieve->rowCount() > 0) {
                                    echo "<div class='product-slider'>";

                                    foreach ($retrieve as $row) {
                                        $uname = $row["UID"];
                                        $pname = $row["ProName"];
                                        $img = $row["ProPic"];
                                        
                                        echo "<div class='item'><div class='product'><div class='flip-container'>";
                                        echo "<div class='flipper'><div class='front'>";
                                        echo "<a href='profile?id=$uid'><img src='images/userProfiles/$img' class='img-responsive'></a></div>";
                                        echo "<div class='back'><a href='profile?id=$uid'><img src='images/userProfiles/$img' alt='' class='img-responsive'></a></div></div></div>";
                                        echo "<a href='profile?id=$uid' class='invisible'><img src='images/userProfiles/$img' class='img-responsive'></a>";
                                        echo "<div class='text'><h3><a href='profile?id=$uid''>$pname</a></h3>";
                                        echo "</div></div></div>";
                                    }
                                    echo "</div>";

                                } else { echo "<h2>-- No results --</h2>";}

                            }catch(PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
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