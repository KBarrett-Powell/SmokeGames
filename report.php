<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Reports
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
                        <li><a href="index.php">Home</a></li>
                        <li>Report A User</li>
                    </ul>

                </div>
                
                <div class="col-md-3">
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Menu</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active">
                                    <a href="#">Contact Information</a>
                                </li>
                                <li>
                                    <a href="report.php">Report A User</a>
                                </li>
                            </ul>     
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Report User</h1>

                        <p class="lead">Please select the user's name, and enter the reason for report</p>

                        <hr>

                        <form action="" name="login" method="post">
                            <div class="form-group">
                                <label for="user">Username</label>
                                <input class="form-control" type="text" id="user" name="user" required="required" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input class="form-control" type="password" id="pass" name="pass" required="required" placeholder="Password">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="Login" name="submit_login"><i class="fa fa-sign-in"></i> Log in</button>
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
        include "config.php";
        
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

<?php include "footer.php"; ?>
    
</body>
</html>