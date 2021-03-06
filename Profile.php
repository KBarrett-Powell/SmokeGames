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
            $uid = $_GET['id'];

            // Collecting info on current user
            $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE UID = ?");
            $retrieve->execute([$uid]);
    
            if ($retrieve->rowCount() == 1) {
                $retrieve = $gamesdb->prepare("SELECT * FROM Profiles WHERE UID = ?");
                $retrieve->execute([$uid]);

                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $pname = $row['ProName'];
                $desc = $row['PDesc'];
                $img = $row['ProPic'];
                $banner = $row['Banner'];

                $adminret = $gamesdb->prepare("SELECT * FROM Admins WHERE UID = ?");
                $adminret->execute([$uid]);

                if ($adminret->rowCount() == 1) {
                    $isadmin = true;
                } else {
                    $isadmin = false;
                }

                $isLoggedIn = false;
                $sent = false;
                $recieve = false;
                $friends = false;
                
                if (isset($_SESSION['id'])) {
                    $isLoggedIn = true;
                    $requestsent = $gamesdb->prepare("SELECT * FROM Friends WHERE UID1 = ? AND UID2 = ?");
                    $requestsent->execute([$_SESSION['id'], $uid]);
        
                    if ($requestsent->rowCount() == 1) {
                        $row = $requestsent->fetch(PDO::FETCH_ASSOC);
                        $confirm = $row['Confirm'];
                        if ($confirm){
                            $friends = true;
                        } else {
                            $sent = true;
                        }
                    }

                    $requestrecieved = $gamesdb->prepare("SELECT * FROM Friends WHERE UID1 = ? AND UID2 = ?");
                    $requestrecieved->execute([$uid, $_SESSION['id']]);

                    if ($requestrecieved->rowCount() == 1) {
                        $row = $requestrecieved->fetch(PDO::FETCH_ASSOC);
                        $confirm = $row['Confirm'];
                        if ($confirm){
                            $friends = true;
                        } else {
                            $recieve = true;
                        }
                    }
                }
            
            } else {
                echo "<script type='text/javascript'>location.href = '404.php';</script>";
            }
        
            // Checking details entered in comment field alright for database
            function verifyComment() {
                $comment = $_POST['comment'];
                $errors = array();

                // Checking comment doesn't include any tags
                if ($comment != strip_tags($comment)) {
                    array_push($errors, ' Please don\'t use tags in your comment');
                }

                return $errors;
            }

            // Code for buttons in page
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                // If respond to friend request selected :
                if(isset($_POST['addfriend'])) {
                    
                    $addNew = $gamesdb->prepare("UPDATE Friends SET Confirm = 1 WHERE UID1 = ? AND UID2 = ?");
                    $addNew->execute([$uid, $_SESSION['id']]);
    
                    echo "<script type='text/javascript'>alert('Friend Successfully added.'); window.location.href = window.location.href;</script>";

                // If send a friend request selected : 
                } else if(isset($_POST['sendreq'])) {

                    // Create new friend id for the friendship
                    $retrieve = $gamesdb->prepare("SELECT max(FID) FROM Friends");
                    $retrieve->execute();
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $fid = $row["max(FID)"] + 1;
    
                    $date = date('Y-m-d');
    
                    $addNew = $gamesdb->prepare("INSERT INTO Friends(FID, UID1, UID2, Fdate, Confirm) VALUES (?, ?, ?, ?, ?)");
                    $addNew->execute([$fid, $_SESSION['id'], $uid, $date, 0]);
    
                    echo "<script type='text/javascript'>alert('Friend Request Sent Successfully.'); window.location.href = window.location.href;</script>";

                // If make user admin selected :
                } else if(isset($_POST['adminUser'])) {
                    // Create new admin id
                    $retrieve = $gamesdb->prepare("SELECT max(AdminID) FROM Admins");
                    $retrieve->execute();
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $adminid = $row["max(AdminID)"] + 1;

                    // Inserting new admin details into admin table
                    $makeAdmin = $gamesdb->prepare("INSERT INTO Admins(AdminID, UID, Upgrader) VALUES (?, ?, ?)");
                    $makeAdmin->execute([$adminid, $uid, $_SESSION['id']]);

                    echo "<script type='text/javascript'>alert('Successfully made user admin.'); window.location.href = window.location.href;</script>";

                // If comment form submitted :
                } else if(isset($_POST['leaveComment'])) {
                    $cErrors = verifyComment();
                    if (empty($cErrors)) {
                        $comment = $_POST['comment'];
                        
                        // Create new friend id for the friendship
                        $retrieve = $gamesdb->prepare("SELECT max(ComID) FROM Comments");
                        $retrieve->execute();
                        $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                        $cid = $row["max(ComID)"] + 1;
        
                        $date = date('F j, Y, g:i a');
        
                        $addNew = $gamesdb->prepare("INSERT INTO Comments(ComID, OnUID, FromUID, Comment, Cdate) VALUES (?, ?, ?, ?, ?)");
                        $addNew->execute([$cid, $uid, $_SESSION['id'], $comment, $date]);
        
                        echo "<script type='text/javascript'>alert('Commented Successfully.'); window.location.href = window.location.href;</script>";
                    } else {
                        echo "<script type='text/javascript'>alert(". json_encode($cErrors) .");</script>";
                    }
                } else if(isset($_POST['reportU'])) {
                    echo "<script type='text/javascript'>location.href = 'report.php?id=$uid';</script>";
                }
            }
        } catch(PDOException $e) {
            echo "<script type='text/javascript'>location.href = '404.php'";
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
                        <?php echo "<li>$pname</li>"; ?>
                    </ul>

                </div>
                
                <div class="col-md-3">
                    <div class='panel panel-default sidebar-menu'>
                    <?php
                        if (!$isLoggedIn) {
                            // Displaying profile name and report user option
                            echo "<div class='panel-heading'><h3 class='panel-title'>$pname</h3></div><div class='panel-body'>";
                            echo "<ul class='nav nav-pills nav-stacked'>";
                            echo "<li>--You need to be logged into befriend and report users--</li></ul></div></div>";

                        } else if ($uid == $_SESSION['id']){
                            // Links to log out and view account info
                            echo "<div class='panel-heading'><h3 class='panel-title'>My Account</h3></div>";
                            echo "<div class='panel-body'><ul class='nav nav-pills nav-stacked'><li class='active'><a href='#'><i class='fa fa-list'></i>My profile</a></li>";
                            echo "<li><a href='editProfile.php'><i class='fa fa-heart'></i> Edit Profile</a></li>";
                            echo "<li><a href='editAccount.php'><i class='fa fa-user'></i> Edit Account</a></li>";
                            if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                                echo "<li><a href='admin.php'><i class='fa fa-user'></i> Admin</a></li>";
                            }
                            echo "<li><a href='logout.php'><i class='fa fa-sign-out'></i> Logout</a></li></ul></div></div>";

                        } else {
                            // Displaying profile and starting list
                            echo "<div class='panel-heading'><h3 class='panel-title'>$pname</h3></div><div class='panel-body'>";
                            echo "<ul class='nav nav-pills nav-stacked'>";

                            if ($sent) {
                                // Display that request for friendship sent
                                echo "<li style='padding-left: 5%; margin-bottom: 7%;'><i class='fa fa-heart'></i> Friend Request Sent</li>";

                            } else if ($recieve) {
                                // Display that request for friendship recieved
                                echo "<li style='padding-left: 5%; margin-bottom: 2%;'><i class='fa fa-heart'></i> Friend Request Recieved!</li>";
                                echo "<li style='padding-left: 10%; margin-bottom: 7%;'><form method='post'><button style='border:none; background-color: transparent;' type='submit' name='addfriend'>";
                                echo "Add Friend</button></form></li>";

                            } else if ($friends){
                                // Display that user is friends with this user
                                echo "<li style='padding-left: 5%; margin-bottom: 7%;'><i class='fa fa-heart'></i> You're Friends!</li>";

                            } else {
                                // Link to add friend
                                echo "<li style='margin-bottom: 7%;'><form method='post'><button style='border:none; background-color: transparent;' type='submit' name='sendreq'>";
                                echo "<i class='fa fa-heart'></i>Send Friend Request</button></form></li>";
                            }

                            echo "<li style='margin-bottom: 7%;'><form method='post'><button style='border:none; background-color: transparent;' type='submit' name='reportU'>";
                            echo "<i class='fa fa-user'></i> Report User</button></form></li>";

                            if (isset($_SESSION['admin']) && $_SESSION['admin'] == true && $isadmin == false) {
                                echo "<li><form method='post' name='adminUser'>";
                                echo "<button onClick='return confirm('Make this user an admin?')' style='border:none; background-color: transparent;' type='submit' name='adminUser'><i class='fa fa-user'></i> Make User Admin";
                                echo "</button></form></li>";
                            }
                            echo "</ul></div></div>";
                        }
                    ?>       
                </div>

                <div class="col-sm-9" id="blog-post">

                    <div class="box">
                        <p>
                            <?php echo "<img src='images/UserBanners/$banner' width='100%' class='img-responsive' alt='User Banner Image Not Found'>" ?>
                        </p>  

                        <?php echo "<img src='images/UserProfiles/$img' style='width:10%;' alt='User Profile Image Not Found'><h1 style='float:right;margin-right:5%;'>$pname</h1>"; ?>
                        
                        <?php 
                            if ($desc != "")
                                echo "<hr><p class='lead'>$desc</p><hr>"; 
                            else  
                                echo "<hr>";
                        ?>
                        

                        <div id="post-content">
                                        
                            <div class="box">

                            <h1>Top Scores</h1>
                                <div class="table-responsive">
                                <?php 
                                    try{
                                        include "config.php";
                                        echo "<table class='table'><tr><th>Game Name</th><th>Score</th></tr>";
                                        
                                        // Retrieving scores connected to current user profile
                                        $retrieve = $gamesdb->prepare("SELECT g.Gname, s.Score FROM Scores s, Games g WHERE s.UID = ? AND g.GameID = s.GameID ORDER BY s.Score DESC LIMIT 15");
                                        $retrieve->execute([$uid]);

                                        if ($retrieve->rowCount() > 0) {
                                            foreach ($retrieve as $row) {
                                                $gname = $row['Gname'];
                                                $score = $row['Score'];

                                                echo "<tr><td>$gname</td><td>$score</td></tr>";
                                            }
                                            echo "</table>";
                                        } else {
                                            echo "<tr><td colspan='2'>--No Scores Found--</td></tr></table>";
                                        }
                                    }catch(PDOException $e) {
                                        echo "<script type='text/javascript'>location.href = '404.php'";
                                    }
                                    $gamesdb = null;
                                ?>     
                                </div>
                            </div>
                        
                            <div class="box">
                            <h1>Wins / Losses</h1>
                                <div class="table-responsive">
                                <?php 
                                    try{
                                        include "config.php";
                                        echo "<table class='table'><tr><th>Game Name</th><th>Wins</th><th>Losses</th></tr>";

                                        $retrieve = $gamesdb->prepare("SELECT g.Gname, SUM(s.Win = 1) AS Wins, SUM(s.Win = 0) AS Losses FROM Scores s, Games g WHERE s.UID = ? AND g.GameID = s.GameID GROUP BY s.GameID");
                                        $retrieve->execute([$uid]);
                                        
                                        if ($retrieve->rowCount() > 0) {
                                            foreach ($retrieve as $row) {
                                                $gname = $row['Gname'];
                                                $wins = $row['Wins'];
                                                $loss = $row['Losses'];

                                                echo "<tr><td>$gname</td><td>$wins</td><td>$loss</td></tr>";
                                            }
                                            echo "</table>";
                                        } else {
                                            echo "<tr><td>--No Games Found--</td></tr></table>";
                                        }

                                    }catch(PDOException $e) {
                                        echo "<script type='text/javascript'>location.href = '404.php'";
                                    }
                                    $gamesdb = null;
                                ?>     
                                </div>
                            </div>       

                            <div class="box">
                            <h1>Friends</h1>
                                <div class="table-responsive">
                                <?php 
                                    try{
                                        include "config.php";
                                        echo "<table class='table'><tr><th colspan='2'>Friends</th></tr>";

                                        $retrieve = $gamesdb->prepare("SELECT p.UID, p.ProName, p.ProPic FROM Profiles p JOIN Friends f ON p.UID = f.UID1 WHERE f.UID2 = ? AND f.Confirm = 1
                                        UNION SELECT p.UID, p.ProName, p.ProPic FROM Profiles p JOIN Friends f ON p.UID = f.UID2 WHERE f.UID1 = ? AND f.Confirm = 1");
                                        $retrieve->execute([$uid, $uid]);
                                        
                                        if ($retrieve->rowCount() > 0) {
                                            foreach ($retrieve as $row) {
                                                $fUser = $row['UID'];
                                                $fname = $row['ProName'];
                                                $fPic = $row['ProPic'];

                                                echo "<tr><td width='15%'><a href='Profile.php?id=$fUser'><img src='images/userProfiles/$fPic' width='100%' alt='Could not find' class='userimage'></a></td>";
                                                echo "<td><a href='Profile.php?id=$fUser'><h3 style='padding-left:10%; padding-top:2%'>$fname<h3></a></td></tr>";
                                            }
                                            echo "</table>";
                                        } else {
                                            echo "<tr><td>--No Friends Found--</td></tr></table>";
                                        }

                                    }catch(PDOException $e) {
                                        echo "<script type='text/javascript'>location.href = '404.php'";
                                    }
                                    $gamesdb = null;
                                ?>     
                                </div>
                            </div>                            
                            <hr>
                            <div id="comments" data-animate="fadeInUp">
                                <?php 
                                    try{
                                        include "config.php";
                                        $retrieve = $gamesdb->prepare("SELECT c.Comment, c.Cdate, p.ProName, p.ProPic FROM Comments c JOIN Profiles p ON c.FromUID = p.UID WHERE c.OnUID = ?");
                                        $retrieve->execute([$uid]);
                                        
                                        $count = $retrieve->rowCount();
                                        if ($count > 0) {
                                            echo "<h4>".$count." Comments</h4>";

                                            foreach ($retrieve as $row) {
                                                $comment = $row['Comment'];
                                                $dateadd = $row['Cdate'];
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
                                        echo "<script type='text/javascript'>location.href = '404.php'";
                                    }
                                    $gamesdb = null;
                                ?> 
                            </div>

                            <hr>

                            <?php 
                                if (isset($_SESSION['id'])) {
                                    //Form for users to leave comments on someone's profile
                                    echo "<div id='comment-form' data-animate='fadeInUp'>";

                                    echo "<h4>Leave comment</h4>";

                                    echo "<form action='profile.php?id=$uid' method='post'>";
                                    echo "<div class='row'>";
                                    echo "<div class='col-sm-12'>";
                                    echo "<div class='form-group'>";
                                    echo "<label for='comment'>Comment <span class='required'>*</span></label>";
                                    echo "<textarea class='form-control' id='comment' name='comment' rows='4' required='required'></textarea>";
                                    echo "</div></div></div>";
                                    echo "<div class='row'>";
                                    echo "<div class='col-sm-12 text-right'>";
                                    echo "<button class='btn btn-primary' type='submit' name='leaveComment'><i class='fa fa-comment-o'></i> Post comment</button>";
                                    echo "</div></div></form></div>";
                            
                                } else {
                                    echo "<p>--You must be logged in to leave a comment--</p>";
                                }
                            ?>
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </div> 
<?php include "footer.php"; ?>
</body></html>