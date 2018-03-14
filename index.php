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

            <!-- HOMEPAGE -->
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

            <!-- ADVANTAGES END -->

            <!-- HOT PRODUCT SLIDESHOW -->
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

                                 // This SQL query defines how the items are sorted and what they are filtered by
                                if (isset($_GET['sortwhat']) && isset($_GET['filterby'])) {
                                    $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Category LIKE '%?%' ORDER BY ? ? ");
                                    $retrieve->execute([$_GET['filterby'], $_GET['sortwhat'], $_GET['sorthow']]);
                                } else if (isset($_GET['sortwhat'])) {
                                    $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY ? ?");
                                    $retrieve->execute([$_GET['sortwhat'], $_GET['sorthow']]);
                                } else if (isset($_GET['filterby'])) {
                                    $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Category LIKE '%?%' ORDER BY Gname ASC");
                                    $retrieve->execute([$_GET['filterby']]);
                                } else {    
                                    $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY Gname ASC");
                                    $retrieve->execute();
                                }
                                
                                if ($retrieve->rowCount() > 0) {
                                    foreach ($retrieve as $row) {
                                        $id = $row["GameID"];
                                        $name = $row["Gname"];
                                        $img = $row["Gimg1"];
                                        $flip = $row["Gimg2"];
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

            <!-- <div class="box text-center" data-animate="fadeInUp">
                <div class="container">
                    <div class="col-md-12">
                        <h3 class="text-uppercase">From our blog</h3>

                        <p class="lead">What's new in the world of fashion? <a href="blog.html">Check our blog!</a>
                        </p>
                    </div>
                </div>
            </div> -->
<!--  
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

                    </div> */ -->
                    <!-- /#blog-homepage -->
                <!-- </div>
            </div> -->
            <!-- /.container -->

            <!-- *** BLOG HOMEPAGE END *** -->


        <!-- </div> -->
        <!-- /#content -->
    <?php include "footer.php"; ?>
</body>

</html>