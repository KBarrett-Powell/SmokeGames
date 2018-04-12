<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>

   <title>
        Smoke Games - Profiles
    </title>

    <?php include "references.php";

        try{
            include "config.php";
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
                header("Location: 404.php");
                exit;
            }
        
            // Code to add new friend and leave a comment
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST['addfriend'])) {
                    $friendId = $uname;
                    
                    // Create new friend id for the friendship
                    $retrieve = $gamesdb->prepare("SELECT max(FID) FROM Friends");
                    $retrieve->execute();
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $fid = $row["max(FID)"] + 1;
    
                    $uname1 = $_SESSION['username'];
                    $date = date('Y-m-d');
    
                    $addNew = $gamesdb->prepare("INSERT INTO Friends(FID, Uname1, Uname2, DateAdd) VALUES (?, ?, ?, ?)");
                    $addNew->execute([$fid, $uname1, $friendId, $date]);
    
                    echo "<script type='text/javascript'>alert('Friend Successfully added.')</script>";

                } else if(isset($_POST['leaveComment'])) {
                    $commentee = $uname;
                    $comment = $_POST['comment'];
                    
                    // Create new friend id for the friendship
                    $retrieve = $gamesdb->prepare("SELECT max(ComID) FROM Comments");
                    $retrieve->execute();
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $cid = $row["max(ComID)"] + 1;
    
                    $commenter = $_SESSION['username'];
                    $date = date('F j, Y, g:i a');
    
                    $addNew = $gamesdb->prepare("INSERT INTO Comments(ComID, OnUname, FromUname, Comment, DateAdd) VALUES (?, ?, ?, ?, ?)");
                    $addNew->execute([$cid, $commentee, $commenter, $comment, $date]);
    
                    echo "<script type='text/javascript'>alert('Commented Successfully.')</script>";
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

                        <li><a href="index.php">Home</a></li>
                        <?php echo "<li>".$_SESSION['proname']."</li>"; ?>
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
                            echo "<div class='panel-body'><ul class='nav nav-pills nav-stacked'><li><form method='post'>";
                            echo "<button style='border:none; background-color: transparent;' type='submit' name='addfriend'>Add Friend</button></form></li>";
                            echo "<li><a href='#'>Message</a></li></ul></div></div>";
                        }
                    ?>       
                </div>

                <div class="col-sm-9" id="blog-post">

                    <div class="box">

                        <?php echo "<img src='images/UserProfiles/$img' style='width:10%;' alt='User Profile Image Not Found'><h1>$pname</h1>"; ?>
                        
                        <?php echo "<p class='lead'>$desc</p>"; ?>

                        <div id="post-content">

                            <p>
                                <?php echo "<img src='images/UserBanners/$banner' width='100%' class='img-responsive' alt='User Banner Image Not Found'>" ?>
                            </p>              

                            <div class="box">

                            <h1>Top Scores</h1>
                                <div class="table-responsive">
                                <?php 
                                    try{
                                        include "config.php";
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
                            </div>
                        </div>

                        <div class="box">

                            <h1>Friends</h1>
                                <div class="table-responsive">
                                <?php 
                                    try{
                                        include "config.php";
                                        echo "<table class='table'><tr><th colspan='2'>Friends</th></tr>";

                                        $retrieve = $gamesdb->prepare("SELECT p.Uname, p.ProName, p.ProPic FROM Profiles p JOIN Friends f ON p.Uname = f.Uname1 WHERE f.Uname2 = ?
                                        UNION SELECT p.Uname, p.ProName, p.ProPic FROM Profiles p JOIN Friends f ON p.Uname = f.Uname2 WHERE f.Uname1 = ?");
                                        $retrieve->execute([$uname, $uname]);
                                        
                                        if ($retrieve->rowCount() > 0) {
                                            foreach ($retrieve as $row) {
                                                $fUser = $row['Uname'];
                                                $fname = $row['ProName'];
                                                $fPic = $row['ProPic'];

                                                echo "<tr><td width='15%'><a href='Profile.php?id=$fUser'><img src='images/userProfiles/$fPic' width='100%' alt='Could not find' class='userimage'></a></td>";
                                                echo "<td><a href='Profile.php?id=$fUser'><h3 style='padding-left:10%; padding-top:2%'>$fname<h3></a></td></tr>";
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
                        </div>                              

                        <div id="comments" data-animate="fadeInUp">
                            <?php 
                                try{
                                    include "config.php";
                                    $retrieve = $gamesdb->prepare("SELECT c.Comment, c.DateAdd, p.ProName, p.ProPic FROM Comments c JOIN Profiles p ON c.FromUname = p.Uname WHERE c.OnUname = ?");
                                    $retrieve->execute([$uname]);
                                    
                                    $count = $retrieve->rowCount();
                                    if ($count > 0) {
                                        echo "<h4>".$count." Comments</h4>";

                                        foreach ($retrieve as $row) {
                                            $comment = $row['Comment'];
                                            $dateadd = $row['DateAdd'];
                                            $cname = $row['ProName'];
                                            $cpic = $row['ProPic'];

                                            echo "<div class'row comment'> <div class='col-sm-3 col-md-2 text-center-xs'>";
                                            echo "<p><img src='images/UserProfiles/$cpic' class='img-responsive img-circle' alt=''></p></div>";
                                            echo "<div class='col-sm-9 col-md-10'><h5>$cname</h5><p class='posted'><i class='fa fa-clock-o'></i>$dateadd</p>";
                                            echo "<p>$comment</p></div></div>";
                                        }
                                    } else {
                                        echo "<h4>No Comments</h4>";
                                    }
                                
                                }catch(PDOException $e) {
                                    echo "Connection failed: " . $e->getMessage();
                                }
                                $gamesdb = null;
                            ?> 
                        </div>

                        <div id="comment-form" data-animate="fadeInUp">

                            <h4>Leave comment</h4>

                            <form method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="comment">Comment <span class="required">*</span></label>
                                            <textarea class="form-control" id="comment" name="comment" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button class="btn btn-primary" type="submit" name="leaveComment"><i class="fa fa-comment-o"></i> Post comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
<?php include "footer.php"; ?>
</body></html>