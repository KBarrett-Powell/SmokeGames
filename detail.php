<?php
        session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  
    <title>
        Smoke Games
    </title>

    <?php include "references.php"; ?>

</head>

<body>

    <?php include "navigation.php"; ?>
    
    <?php
        try{
            include "config.php";

            $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE GameID = ?");
            $retrieve->execute([$_GET['id']]);

            if ($retrieve->rowCount() == 1){
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $id = $row["GameID"];
                $name = $row["Gname"];
                $desc = $row["Description"];
                $img = $row["Gimg1"];
                $squareImg = $row["GimgSquare"];
                $age = $row["AgeRating"];
            } else {
                header("Location: 404.html");
                exit;
            }

        }catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $gamesdb = null;
    ?>
    
    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="#">Home</a>
                        </li>
                        <li><a href="#">Games</a>
                        </li>
                        <li><?php echo $name; ?></li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <!-- MENUS AND FILTERS -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Leaderboards</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked category-menu">
                                <li>
                                    <a href="#">Highest Score: <span class="badge pull-right"></span></a>
                                    <ul>
                                        <li><a href="#">Benedict: 9999</a>
                                        </li>
                                        <li><a href="#">Kailesh: 7777</a>
                                        </li>
                                        <li><a href="#">Kt: 5555</a>
                                        </li>
                                        <li><a href="#">Alan: 4444</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="active">
                                    <a href="#">Highest Hours: <span class="badge pull-right">123</span></a>
                                    <ul>
                                        <li><a href="#">This</a>
                                        </li>
                                        <li><a href="#">whole bit</a>
                                        </li>
                                        <li><a href="#">needs to</a>
                                        </li>
                                        <li><a href="#">be dynamic.</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Rate The Game:  <span class="badge pull-right">4.7</span></a>
                                    <ul>
                                        <li><a href="#">1 Smoke</a>
                                        </li>
                                        <li><a href="#">2 Smoke</a>
                                        </li>
                                        <li><a href="#">3 Smoke</a>
                                        </li>
                                        <li><a href="#">4 Smoke</a>
                                        </li>
                                        <li><a href="#">5 Smoke</a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <!-- MENUS AND FILTERS END -->

                </div>

                <div class="col-md-9">

                    <div class="row" id="productMain">
                        <div class="col-sm-6">
                            <div id="mainImage">
                                <img src="<?php echo $img; ?>" alt="" class="img-responsive">
                            </div>

                            <div class="ribbon sale">
                                <div class="theribbon">SALE</div>
                                <div class="ribbon-background"></div>
                            </div>
                            <!-- /.ribbon -->

                            <div class="ribbon new">
                                <div class="theribbon">NEW</div>
                                <div class="ribbon-background"></div>
                            </div>
                            <!-- /.ribbon -->

                        </div>
                        <div class="col-sm-6">
                            <div class="box">
                                <h1 class="text-center"><?php echo $name; ?></h1>
                                <p class="goToDescription"><a href="#details" class="scroll-to">Scroll to Game Information.</a>
                                </p>
                                <p class="price">Age: <?php echo $age; ?></p>

                                <p class="text-center buttons">
                                    <?php echo "<a href=\"play.php?GameID=\"$_GET['id']class=\"btn btn-primary\"><i class=\"fa fa-shopping-cart\"></i> PLAY GAME</a>";?>
                                </p>


                            </div>

                            <div class="row" id="thumbs">
                                <div class="col-xs-4">
                                    <a href="<?php echo $img; ?>" class="thumb">
                                        <img src="<?php echo $squareImg; ?>" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="<?php echo $img; ?>" class="thumb">
                                        <img src="<?php echo $squareImg; ?>" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="<?php echo $img; ?>" class="thumb">
                                        <img src="<?php echo $squareImg; ?>" alt="" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="box" id="details">
                        <p>
                            <h4>Product details:</h4>
                            <p><?php echo $desc; ?></p>
                            <h4>How to play:</h4>
                            <ul>
                                <li>Make table for this information.</li>
                                <li>in the sql database.</li>
                            </ul>

                            <blockquote>
                                <p><em>Be sure to leave a rating and a review to help us improve our game and our platform.</em>
                                </p>
                            </blockquote>

                            <hr>
                            <div class="social">
                                <h4>Play with your friends!</h4>
                                <p>
                                    <a href="#" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
                                    <a href="#" class="external gplus" data-animate-hover="pulse"><i class="fa fa-google-plus"></i></a>
                                    <a href="#" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
                                    <a href="#" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
                                </p>
                            </div>
                    </div>

                    <!-- CODE FOR THE RECOMMENDED GAMES! -->
                    
                    <div class="col-md-3 col-sm-6">
                        <div class="box same-height">
                            <h3>You may also like these games</h3>
                        </div>
                    </div>
                    
                    <!-- THERE IS AN ERROR IN THE CODE BELOW!! -->
                    
                    <?php
                        try{
                            include "config.php";
                        
                            $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Recommended = 1 ORDER BY Gname ASC");
                            $retrieve->execute();

                            if($retrieve->rowCount() > 0) {
                                foreach($retrieve as $row){
                                    $recid = $row["GameID"];
                                    $recname = $row["Gname"];
                                    $recimg = $row["Gimg1"];

                                    echo "<div class='row same-height-row'>";
                                    echo "<div class='col-md-3 col-sm-6'>";
                                        echo "<div class='product same-height'>";
                                            echo "<div class='flip-container'>";
                                                echo "<div class='flipper'>";
                                                    echo "<div class='front'>";
                                                        echo "<a href='#'>";
                                                            echo "<img src='$recimg' alt='' class='img-responsive'>";
                                                        echo "</a>";
                                                    echo "</div>";
                                                    echo "<div class='back'>";
                                                        echo "<a href='#'";
                                                            echo "<img src='$recimg' alt='' class='img-responsive'>";
                                                        echo "</a>";
                                                    echo "</div>";
                                                echo "</div>";
                                            echo "</div>";
                                            echo "<a href='#' class='invisible'>";
                                                echo "<img src='$recimg' alt='' class='img-responsive'>";
                                            echo "</a>";
                                            echo "<div class='text'>";
                                                echo "<h3>$recname</h3>";
                                                echo "<p class='price'>PLAY NOW!</p>";
                                            echo "</div>";
                                        echo "</div>";
                                        //<!-- /.product -->
                                    echo "</div>";
                                }
                            } else {
                                echo "No results";
                            }
                            echo "</div>";

                        }catch(PDOException $e) {
                            echo "Connection failed: " . $e->getMessage();
                        }
                        $gamesdb = null;                 
                    ?>

                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

    </div>      
    <?php include "footer.php"; ?>
</body>

</html>