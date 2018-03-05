<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    include "config.php";
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
                            <img src="images/BannerImages/Ghost.jpg" alt="" class="img-responsive">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="images/BannerImages/mathopoly.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="images/BannerImages/Bounce.jpg" alt="">
                        </div>
                        <div class="item">
                            <img class="img-responsive" src="images/BannerImages/DragRacer.jpg" alt="">
                        </div>
                    </div>
                    <!-- /#main-slider -->
                </div>
            </div>

            <!-- *** ADVANTAGES HOMEPAGE ***
 _________________________________________________________ -->
            <div id="advantages">

                <div class="container">
                    <div class="same-height-row">
                        <div class="col-sm-4">
                            <div class="box same-height clickable">
                                <div class="icon"><i class="fa fa-heart"></i>
                                </div>

                                <h3><a href="#">We love our players!</a></h3>
                                <p>To give something back, we will be offering exclusive access to brand new games for our users! Sign up now!</p>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="box same-height clickable">
                                <div class="icon"><i class="fa fa-tags"></i>
                                </div>

                                <h3><a href="#">Exclusive games!</a></h3>
                                <p>dab.dab.dab.dab.</p>
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
                    <!-- /.row -->

                </div>
                <!-- /.container -->

            </div>
            <!-- /#advantages -->

            <!-- *** ADVANTAGES END *** -->

            <!-- *** HOT PRODUCT SLIDESHOW ***
 _________________________________________________________ -->
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

                        $retrieve = "SELECT * FROM Games ORDER BY Gname ASC;";
                        $result = mysqli_query($gamesdb, $retrieve);
                        if (mysqli_num_rows($result) > 0) {
                           while ($row = mysqli_fetch_assoc($result)) {
                               $id = $row["GameID"];
                               $name = $row["Gname"];
                               $img = $row["Gimg1"];
                               //Need to create "flip" / similar versions of each image.
                               //$img = $row["Alternate Image...."];
                               
                               // Display an image of the game above the name, user clicking on this takes them to another page with more info about the game
                                echo "<div class='item'>";
                                    echo "<div class='product'>";
                                        echo "<div class='flip-container'>";
                                            echo "<div class='flipper'>";
                                                echo "<div class='front'>";
                                                    echo "<a href='detail.php?id=$id'>";
                                                        echo "<img src='$img' alt='' class='img-responsive'>";
                                                    echo "</a></div>";
                                                echo "<div class='back'>";
                                                    echo "<a href='detail.php?id=$id'>";
                                                        echo "<img src='$img' alt='' class='img-responsive'>";
                                                    echo "</a></div></div></div>";
                                        echo "<a href='detail.php?id=$id' class='invisible'>";
                                            echo "<img src='$img' alt='' class='img-responsive'>";
                                        echo "</a>";
                                        echo "<div class='text'>";
                        
                                            echo "<h3><a href='detail.php?id=$id'>$name</a></h3>";
                                            echo "<p class='price'>PLAY!</p>";
                                        echo "</div>";
                                        //<!-- /.text -->
                                    echo "</div>";
                                    //<!-- /.product -->
                                echo "</div>";
                           }
                           echo "</div></div>";
                        } 
                        else { echo "No results"; }

                        ?>
                
                    <!-- Add this in the Product DIV if desired... -->
                    <!--
                    <div class="ribbon new">
                        <div class="theribbon">NEW</div>
                        <div class="ribbon-background"></div>
                    </div>
                    -->
                                <!-- /.ribbon -->
                            </div>
                            <!-- /.product -->
                        </div>

                    </div>
                    <!-- /.product-slider -->
                </div>
                <!-- /.container -->

            </div>
            <!-- /#hot -->

            <!-- *** HOT END *** --> 

            <!-- *** BLOG HOMEPAGE ***
 _________________________________________________________ -->

            <div class="box text-center" data-animate="fadeInUp">
                <div class="container">
                    <div class="col-md-12">
                        <h3 class="text-uppercase">From our blog</h3>

                        <p class="lead">What's new in the world of fashion? <a href="blog.html">Check our blog!</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="container">

                <div class="col-md-12" data-animate="fadeInUp">

                    <div id="blog-homepage" class="row">
                        <div class="col-sm-6">
                            <div class="post">
                                <h4><a href="post.html">Fashion now</a></h4>
                                <p class="author-category">By <a href="#">John Slim</a> in <a href="">Fashion and style</a>
                                </p>
                                <hr>
                                <p class="intro">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean
                                    ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                <p class="read-more"><a href="post.html" class="btn btn-primary">Continue reading</a>
                                </p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="post">
                                <h4><a href="post.html">Who is who - example blog post</a></h4>
                                <p class="author-category">By <a href="#">John Slim</a> in <a href="">About Minimal</a>
                                </p>
                                <hr>
                                <p class="intro">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean
                                    ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                <p class="read-more"><a href="post.html" class="btn btn-primary">Continue reading</a>
                                </p>
                            </div>

                        </div>

                    </div>
                    <!-- /#blog-homepage -->
                </div>
            </div>
            <!-- /.container -->

            <!-- *** BLOG HOMEPAGE END *** -->


        </div>
        <!-- /#content -->
    <?php include "footer.php"; ?>
</body>

</html>