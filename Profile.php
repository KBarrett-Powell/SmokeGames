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
        Smoke Games - Your Profile
    </title>

    <?php include "references.php"; ?>

    <!-- PHP CODE TO GET USER DATA -->
    <?php
    
        $id = $_GET['id'];
        // collecting info on current user
        $retrieve = "SELECT * FROM Users WHERE UserID = '$id';";
        $result = mysqli_query($gamesdb, $retrieve);
    
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $uname = $row['Uname'];
            $desc = $row['PDesc'];
            $img = $row['ProPic'];
            $banner = $row['PBanner'];
        }
        
    
        //Makes it so that the user can ONLY view the profile they are logged into and not anyone elses.
        if ($id != $_SESSION['id']){
            echo "<script type='text/javascript'>alert('You aren't meant to be here!)</script>";
            header("Location: index.php");
        }
    
    ?>
    
    <!-- PHP CODE TO ADD FRIEND -->
    
    <?php
    
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['addfriend'])) {
                $friendId = $_POST['addfriend'];

                $retrieve = "SELECT max(FID) FROM Friends;";
                $result = mysqli_query($gamesdb, $retrieve);
                $row = mysqli_fetch_assoc($result);
                $fid = $row["max(FID)"] + 1;

                $id1 = $_SESSION['id'];
                $date = date('Y-m-d');

                $addNew = "INSERT INTO Friends(FID, UserID1, UserID2, DateEstab) VALUES ('$fid', '$id1', '$friendId', '$date')";
                $added = mysqli_query($gamesdb, $addNew);

                if ($added) {
                    "<script type='text/javascript'>alert('Friend Successfully added.')</script>";
                } else {
                    "<script type='text/javascript'>alert('Friend couldn't be added, please try again.')</script>";
                }
            }
        }
    
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

                <div class="col-sm-9" id="blog-post">


                    <div class="box">

                        <?php echo "<h1>".$_SESSION['username']."</h1>"; ?>
                        
                        <?php echo "<p class='lead'>$desc</p>"; ?>

                        <div id="post-content">

                            <p>
                                <?php echo "<img src='$banner' class='img-responsive' alt='Example blog post alt'>" ?>
                            </p>

                            <blockquote>
                                <p>USER MOTTO</p>
                            </blockquote>
                            

                         <div class="box">


                            <h1>Games / High Scores</h1>
                                <p class="text-muted">You have X number of games in common.</p>
                                <div class="table-responsive">
                                <?php 
    
                                // retrieving scores connected to the current user, and putting them in the table
                                $retrieve = "SELECT g.Gname, s.Score FROM Scores s, Games g WHERE UserID = '$id' AND g.GameID = s.GameID;";
                                $result = mysqli_query($gamesdb, $retrieve);
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $gname = $row['Gname'];
                                        $score = $row['Score'];
                                        
                                        echo "<table class='table'>";
                                            echo "<thead>";
                                            echo "<tr>";
                                                echo "<th colspan='2'>Game</th>";
                                                echo "<th>Their Score</th>";
                                                echo "<th>Your Score</th>";
                                            echo "</tr>";
                                            echo "</thead>";
                                        echo "<tbody>";
                                            echo "<tr>";
                                                echo "<td>$gname</td>";
                                                echo "<td>";
                                                    echo "<a href='#'>Time Played</a>";
                                                echo "</td>";
                                                echo "<td>$score</td>";
                                                echo "<td>123</td>";
                                            echo "</tr>";
                                        echo "</tbody>";
                                        echo "<tfoot>";
                                            echo "<tr>";
                                                echo "<th colspan='2'>Total</th>";
                                                echo "<th colspan='1'>455</th>";
                                                echo "<th colspan='1'>123</th>";
                                            echo "</tr>";
                                        echo "</tfoot>";
                                    echo "</table>";
                                        
                                    }
                                } 
                                else {
                                    echo "<p>--No Scores Found--</p>";
                                }
                                
    
                                ?>
                                        

                                </div>
                                <!-- /.table-responsive -->
                            
                            <div class="box-footer">
                                <div class="pull-left">
                                    <!-- Incase we want anything on the left side of the table.-->
                                </div>
                                <div class="pull-right">
                                    <a href="profile.php" class="btn btn-default">Next Page <i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>

                    </div>
                    <!-- /.box -->

                            

                        </div>
                        <!-- /#post-content -->

                        <div id="comments" data-animate="fadeInUp">
                            <h4>1 comments</h4>


                            <div class="row comment">
                                <div class="col-sm-3 col-md-2 text-center-xs">
                                    <p>
                                        <img src="img/blog-avatar2.jpg" class="img-responsive img-circle" alt="">
                                    </p>
                                </div>
                                <div class="col-sm-9 col-md-10">
                                    <h5>Julie Alma</h5>
                                    <p class="posted"><i class="fa fa-clock-o"></i> September 23, 2011 at 12:00 am</p>
                                    <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.
                                        Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                                    <p class="reply"><a href="#"><i class="fa fa-reply"></i> Reply</a>
                                    </p>
                                </div>
                            </div>
                            <!-- /.comment -->


                        </div>
                        <!-- /#comments -->

                        <div id="comment-form" data-animate="fadeInUp">

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

                        </div>
                        <!-- /#comment-form -->

                    </div>
                    <!-- /.box -->
                </div>
                <!-- /#blog-post -->

                <div class="col-md-3">
                    <!-- *** EDIT PROFILE MENU ***
 _________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Profile</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                  <li>
                                    <a href="editProfile.php">Update Profile</a>
                                </li>
                                <li>
                                    <a href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    
                    
                    <!-- /.col-md-3 -->
                    
                    
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <!-- Integrate system to check if X user ID is online. -->
                            <h3 class="panel-title">Currently Online / Offline</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li class>
                                    <!-- Need to check if not friends already. -->
                                    <?php echo "<a href='#'><form method='post'><button style='border:none; background-color: transparent;' type='submit' name='addfriend' value='$id'>Add Friend</button></form></a>"; ?>
                                </li>
                                <li>
                                    <a href="blog.html">Message</a>
                                </li>
                                <li>
                                    <a href="blog.html">Games Played</a>
                                </li>
                                <li>
                                    <a href="logout.php">Logout</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /.col-md-3 -->
                    
                    
                    
                    
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <!-- Integrate system to check if X user ID is online. -->
                            <h3 class="panel-title">Friends</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <!-- Load 10 friends from database at random. -->
                                    <a href="#">GET DYNAMICALLY PLS</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /.col-md-3 -->
                    
                    

                    <!-- *** EDIT PROFILE MENU END *** -->

                    <div class="banner">
                        <a href="#">
                            <img src="img/banner.jpg" alt="sales 2014" class="img-responsive">
                        </a>
                    </div>
                </div>


            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

    </div>
    <!-- /#all -->
    
    <?php include "footer.php"; ?>


</body>

</html>