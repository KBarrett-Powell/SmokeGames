<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Password Change
    </title>

    <?php 
        include "references.php"; 
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
                        <li>Password Change</li>
                    </ul>

                </div>
                
                <div class="col-md-3">
                    
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Home</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active"><a href="#"><i class="fa fa-user"></i> Change Password</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Change Password</h1>

                        <p class="lead">For security reasons, please, update your password below. Once you do this, you won't be able to login with the temporary password we sent you.</p>

                        <hr>

                        <form action="forceChange.php" method="post">
                            <div class="form-group">
                                <label for="pass1">New Password</label>
                                <input class="form-control" type="password" id="pass1" name="pass1" required="required" placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label for="pass2">Confirm Password</label>
                                <input class="form-control" type="password" id="pass2" name="pass2" required="required" placeholder="Confirm Password">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="Update" name="update_pass"><i class="fa fa-sign-in"></i> Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php 
    try{
        include "config.php";
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // If login form has been filled out:
            if(isset($_POST['update_pass'])) {

                $newpass = $_POST['pass1'];
                $compass = $_POST['pass2'];
                $user = $_SESSION['id'];

                if ($newpass == $compass){
                    $pass = password_hash($newpass, PASSWORD_DEFAULT);

                    // Update password for this user
                    $update = $gamesdb->prepare("UPDATE Users SET Pass = ? WHERE UID = ?");
                    $update->execute([$pass, $user]);

                    // Remove temporary password from database
                    $update = $gamesdb->prepare("UPDATE Users SET Temp = NULL WHERE UID = ?");
                    $update->execute([$user]);

                    $_SESSION['temp_used'] = false;

                    echo "<script type='text/javascript'>alert('Successfully Updated Password.'); location.href = 'index.php';</script>";
                } else {
                    echo "<script type='text/javascript'>alert('Passwords Don't Match.');</script>";
                } 
            }  
        }
    }catch(PDOException $e) {
        echo "<script type='text/javascript'>location.href = '404.php'";
    }
    $gamesdb = null;
?>
</div>

<?php include "footer.php"; ?>
    
</body>
</html>