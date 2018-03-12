<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <title>
        Smoke Games - Your Profile
    </title>

    <?php include "references.php";

        try{
            $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
            $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $uname = $_GET['id'];
            // Collecting info on current user
            $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE Uname = ?");
            $retrieve->execute([$uname]);
    
            if ($retrieve->rowCount() == 1) {
                $retrieve = $gamesdb->prepare("SELECT * FROM Profiles WHERE Uname = ?");
                $retrieve->execute([$uname]);

                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $pname = $row['ProName'];
                $desc = $row['PDesc'];
                $img = $row['ProPic'];
                $banner = $row['Banner'];
            
            } else {
                header("Location: 404.html");
                exit;
            }
        
            // Code to add new friend
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST['addfriend'])) {
                    $friendId = $_POST['addfriend'];
                    
                    // Create new friend id for the friendship
                    $retrieve = $gamesdb->prepare("SELECT max(FID) FROM Friends");
                    $retrieve->execute();
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $fid = $row["max(FID)"] + 1;
    
                    $uname1 = $_SESSION['username'];
                    $date = date('Y-m-d');
    
                    $addNew = $gamesdb->prepare("INSERT INTO Friends(FID, UserID1, UserID2, DateEstab) VALUES (?, ?, ?, ?)");
                    $addNew->execute([$fid, $uname1, $friendId, $date]);
    
                    echo "<script type='text/javascript'>alert('Friend Successfully added.')</script>";
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

                <div class="col-sm-12">

                    <ul class="breadcrumb">

                        <li><a href="index.html">Home</a>
                        </li>
                        <li><a href="blog.html">Profile</a>
                        </li>
                        <?php echo "<li>".$_SESSION['username']."</li>"; ?>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <?php
                        if ($uname == $_SESSION['username']){
                            // Links to log out and view account info
                            echo "<div class='panel panel-default sidebar-menu'>";
                            echo "<div class='panel-heading'><h3 class='panel-title'>My Account</h3></div>";
                            echo "<div class='panel-body'><ul class='nav nav-pills nav-stacked'><li class='active'><a href='profile.php?id=$uname'><i class='fa fa-list'></i>My profile</a></li>";
                            echo "<li><a href='editProfile.php'><i class='fa fa-heart'></i> Edit Profile</a></li>";
                            echo "<li><a href='editAccount.php'><i class='fa fa-user'></i> Edit Account</a></li>";
                            echo "<li><a href='logout.php'><i class='fa fa-sign-out'></i> Logout</a></li></ul></div></div>";

                        } else {
                            // Link to add friend
                            echo "<div class='panel panel-default sidebar-menu'>";
                            echo "<div class='panel-heading'><h3 class='panel-title'>Currently Online / Offline</h3></div>";
                            echo "<div class='panel-body'><ul class='nav nav-pills nav-stacked'><li><a href='#'><form method='post'>";
                            echo "<button style='border:none; background-color: transparent;' type='submit' name='addfriend' value='$uname'>Add Friend</button></form></a></li>";
                            echo "<li><a href='blog.html'>Message</a></li></ul></div></div>";
                        }
                    ?>       
                </div>

                <div class="col-sm-9" id="blog-post">

                    <div class="box">

                        <?php echo "<img src='$img' style='width:10%;' alt='User Profile Image Not Found'><h1>$pname</h1>"; ?>
                        
                        <?php echo "<p class='lead'>$desc</p>"; ?>

                        <div id="post-content">

                            <p>
                                <?php echo "<img src='$banner' class='img-responsive' alt='User Banner Image Not Found'>" ?>
                            </p>              

                            <div class="box">

                            <h1>Top Scores</h1>
                                <div class="table-responsive">
                                <?php 
                                    try{
                                        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
                                        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        echo "<table class='table'><tr><th>Game Name</th><th>Score</th></tr>";
                                        
                                        // Retrieving scores connected to current user profile
                                        $retrieve = $gamesdb->prepare("SELECT g.Gname, s.Score FROM Scores s, Games g WHERE s.Uname = ? AND g.GameID = s.GameID");
                                        $retrieve->execute([$uname]);

                                        if ($retrieve->rowCount() > 0) {
                                            foreach ($retrieve as $row) {
                                                $gname = $row['Gname'];
                                                $score = $row['Score'];

                                                echo "<tr><td>$gname</td><td>$score</td></tr>";
                                            }
                                            echo "</table></td>";
                                        } else {
                                            echo "<tr><td colspan='2'>--No Scores Found--</td></tr></table></td>";
                                        }
                                    }catch(PDOException $e) {
                                        echo "Connection failed: " . $e->getMessage();
                                    }
                                    $gamesdb = null;
                                ?>     
                                </div>
                            
                                <div class="box-footer">
                                    <div class="pull-left">
                                        <!-- Incase we want anything on the left side of the table.-->
                                    </div>
                                    <div class="pull-right">
                                        <!--<a href="profile.php" class="btn btn-default">Next Page <i class="fa fa-chevron-right"></i></a>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box">

                            <h1>Friends</h1>
                                <div class="table-responsive">
                                <?php 
                                    try{
                                        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
                                        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        echo "<table class='table'><tr><th colspan='2'>Friends</th></tr>";

                                        $retrieve = $gamesdb->prepare("SELECT u.Uname, p.ProPic FROM Users u JOIN Profiles p ON u.Uname = p.Uname JOIN Friends f ON u.Uname = f.Uname1 WHERE f.Uname2 = ?
                                        UNION SELECT u.Uname, p.ProPic FROM  Users u JOIN Profiles p ON u.Uname = p.Uname JOIN Friends f ON u.Uname = f.Uname2 WHERE f.Uname1 = ?");
                                        $retrieve->execute([$uname, $uname]);
                                        
                                        if ($retrieve->rowCount() > 0) {
                                            foreach ($retrieve as $row) {
                                                $fUser = $row['Uname'];
                                                $fPic = $row['ProPic'];

                                                echo "<tr><td><a href='Profile.php?id=$fUser'><img src='images/$fPic' alt='Could not find' class='userimage'></a></td><td>$fUser</td></tr>";
                                            }
                                            echo "</table></td></tr></table>";
                                        } else {
                                            echo "<tr><td>--No Friends Found--</td></tr></table></td></tr></table>";
                                        }

                                    }catch(PDOException $e) {
                                        echo "Connection failed: " . $e->getMessage();
                                    }
                                    $gamesdb = null;
                                ?>     
                                </div>
                            
                            <div class="box-footer">
                                <div class="pull-left">
                                    <!-- Incase we want anything on the left side of the table.-->
                                </div>
                                <div class="pull-right">
                                    <!--<a href="profile.php" class="btn btn-default">Next Page <i class="fa fa-chevron-right"></i></a>-->
                                </div>
                            </div>
                        </div>                              
                    </div>
                </div>

                        <!-- <div id="comments" data-animate="fadeInUp">
                            <h4>1 comments</h4>


                            <div class="row comment">
                                <div class="col-sm-3 col-md-2 text-center-xs">
                                    <p>
                                        <img src="img/blog-avatar2.jpg" class="img-responsive img-circle" alt="">
                                    </p>
                                </div>
                                <div class="col-sm-9 col-md-10">
                                    <h5>OhHaiMark</h5>
                                    <p class="posted"><i class="fa fa-clock-o"></i> September 23, 2017 at 3:00 am</p>
                                    <p>Lol ur account succs</p>
                                    <p class="reply"><a href="#"><i class="fa fa-reply"></i> Reply</a>
                                    </p>
                                </div>
                            </div> -->
                            <!-- /.comment -->


                        <!-- </div> -->
                        <!-- /#comments -->

                        <!-- <div id="comment-form" data-animate="fadeInUp">

                            <h4>Leave comment</h4>

                            <form>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Name <span class="required">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email <span class="required">*</span>
                                            </label>
                                            <input type="text" class="form-control" id="email">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="comment">Comment <span class="required">*</span>
                                            </label>
                                            <textarea class="form-control" id="comment" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button class="btn btn-primary"><i class="fa fa-comment-o"></i> Post comment</button>
                                    </div>
                                </div>


                            </form>

                        </div> -->
                        <!-- /#comment-form -->
                    <!-- /.box -->
                
                <!-- /#blog-post -->

                                     
                    
                    <!-- <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading"> -->
                            <!-- Integrate system to check if X user ID is online. -->
                            <!-- <h3 class="panel-title">Friends</h3> -->
                        <!-- </div> -->

                        <!-- <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li> -->
                                    <!-- Load 10 friends from database at random. -->
                                <!-- </li>
                            </ul>
                        </div>

                    </div> -->
                    <!-- /.col-md-3 -->
                    
                    

                    <!-- *** EDIT PROFILE MENU END *** -->
                    <!-- 
                    <div class="banner">
                         <a href="#">
                             <img src="img/banner.jpg" alt="sales 2014" class="img-responsive">
                         </a>
                    </div> -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
    </div>
    <!-- /#all -->
    
    <?php include "footer.php"; ?>
</body></html>