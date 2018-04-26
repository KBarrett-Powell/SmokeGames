<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>
        Smoke Games - Homepage
    </title>

    <?php include "references.php"; ?>

</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">

        <div id="content">

            <div class="container">
                <div class="col-md-12">
                    <div id="main-slider">
                        <div class="item">
                            <img class="img-responsive" src="images/BannerImages/Ghost.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="images/BannerImages/pong.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="images/BannerImages/Bounce.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="images/BannerImages/mathopoly.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <div id="advantages">
                <div class="container">
                    <div class="same-height-row">
                        <div class="col-sm-4">
                            <div class="box same-height clickable">
                                <div class="icon"><i class="fa fa-heart"></i>
                                </div>

                                <h3><a href="#">We love our players!</a></h3>
                                <p>We offer exclusive access to brand new games for our users! Sign up now!</p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="box same-height clickable">
                                <div class="icon"><i class="fa fa-tags"></i>
                                </div>

                                <h3><a href="#">Exclusive games!</a></h3>
                                <p>Explore our amazing game library now!</p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="box same-height clickable">
                                <div class="icon"><i class="fa fa-thumbs-up"></i>
                                </div>

                                <h3><a href="#">Follow us on Social media!</a></h3>
                                <p>Facebook.com/SmokeGames</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="hot">

                <div class="box">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>Trending Games</h2>
                        </div>
                    </div>
                </div>
                
                <div class="container">
                    <div class="product-slider">
                
                        <?php
                            try{
                                include "config.php";

                                $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY Gname ASC");
                                $retrieve->execute();
                                
                                if ($retrieve->rowCount() > 0) {
                                    foreach ($retrieve as $row) {
                                        $id = $row["GameID"];
                                        $name = $row["Gname"];
                                        $img = $row["Gimg1"];
                                        echo "<div class='item'><div class='product'><div class='flip-container'>";
                                        echo "<div class='flipper'><div class='front'>";
                                        echo "<a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div>";
                                        echo "<div class='back'><a href='detail.php?id=$id'><img src='$img' alt='' class='img-responsive'></a></div></div></div>";
                                        echo "<a href='detail.php?id=$id' class='invisible'><img src='$img' alt='' class='img-responsive'></a>";
                                        echo "<div class='text'><h3><a href='detail.php?id=$id'>$name</a></h3><p class='price'>PLAY!</p>";
                                        echo "</div></div></div>";
                                    }
                                    echo "</div></div>";
                                } else { echo "No results";}

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
        </div>
    </div>
<?php include "footer.php"; ?>

</body>
</html>