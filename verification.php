<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Sign Up
    </title>

    <?php 
        include "references.php"; 
        include "require.php";
    ?>
</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li>Verify User</li>
                    </ul>

                </div>
                
                <div class="col-md-3">
                    <!-- CUSTOMER MENU -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Account</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <?php echo "<a href='profile.php?id=". $_SESSION['username'] ."'><i class='fa fa-list'></i>My profile</a>"; ?>
                                </li>
                                <li>
                                    <a href="editProfile.php"><i class="fa fa-heart"></i> Edit Profile</a>
                                </li>
                                <li class="active">
                                    <a href="#"><i class="fa fa-user"></i> Edit Account</a>
                                </li>
                                <li>
                                    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Verify User</h1>

                        <p class="lead">Please login again to view this page</p>

                        <hr>

                        <form action="" name="login" method="post">
                            <div class="form-group">
                                <label for="email">Username</label>
                                <input class="form-control" type="text" id="user" name="user" required="required" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" id="pass" name="pass" required="required" placeholder="Password">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="Login" name="submit_login"><i class="fa fa-sign-in"></i> Log in</button>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="ForgotPass" name="forgot_pass"><i class="fa fa-sign-in"></i> Forgotten Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

<?php 
    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // If login form has been filled out:
            if(isset($_POST['submit_login'])) {

                $username = $_POST['user'];
                $password = $_POST['pass'];

                // Try to find user account with details entered
                $retrieve = $gamesdb->prepare("SELECT u.Pass, u.Verified, p.ProName FROM Users u, Profiles p WHERE u.Uname = ? AND u.Uname = p.Uname");
                $retrieve->execute([$username]);

                if ($retrieve->rowCount() == 1) {
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $hash = $row['Pass'];
                    $pname = $row['ProName'];

                    // Compare passwords
                    //if (password_verify($password, $hash)) {
                    if ($password == $hash) {

                        $_SESSION['verified'] = true;

                        // Take user to account page
                        echo "<script type='text/javascript'>location.href = 'editAccount.php';</script>";
                            
                    } else {echo "<script type='text/javascript'>alert('Password Incorrect. ' . (5 - $attempts) . 'Please Try Again.')</script>";}

                } else {echo "<script type='text/javascript'>alert('Username Incorrect. Please Try Again.')</script>";}
            }  
        }
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>
</div>
 <!-- /#all -->
<?php include "footer.php"; ?>
    
</body>
</html>