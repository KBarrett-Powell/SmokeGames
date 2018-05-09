<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Forgotten Password
    </title>

    <?php 
        include "references.php"; 
        include "requireMail.php";
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
                        <li>Forgotten Password</li>
                    </ul>

                </div>
                
                <div class="col-md-3">

                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Login</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="register.php"><i class="fa fa-user"></i> Register</a>
                                </li>
                                <li class="active">
                                    <a href="#"><i class="fa fa-user"></i> Forgotten Password</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Forgotten Password</h1>

                        <p class="lead">Enter the email linked to your account below, to have a temporary password sent to you.</p>

                        <hr>

                        <form action="forgotPass.php" name="reset" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="text" id="email" name="email" required="required" placeholder="Email Address">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="Reset" name="reset_pass"><i class="fa fa-sign-in"></i> Reset Password</button>
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
            if(isset($_POST['reset_pass'])) {
                $email = $_POST['email'];

                // generate temp pass
                $tempPass = bin2hex(openssl_random_pseudo_bytes(5));
                $SecPass = password_hash($tempPass, PASSWORD_DEFAULT);

                try {
                    // Add header and subject variables to the email
                    $mail->SetFrom('smokegames2018@gmail.com', 'Smoke Games');
                    $mail->AddAddress($email);
                    $mail->Subject  = 'Password Changed!';

                    echo "<script type='text/javascript'>alert('Body.')</script>";
                    // Creating email to send to users on registration
                    $mail->Body     = "Hi ".$_SESSION['username'].",

You asked us to reset your password, your new temporary password is below:
".$tempPass." - You can now use this to log in to your account, after logging in you will be asked to enter a new password for security.";
                    
                    // Sending Email
                    $mail->Send();
                    
                    echo "<script type='text/javascript'>alert('query.')</script>";
                    // Create query to set a temporary password for this account
                    $retrieve = $gamesdb->prepare("UPDATE Users SET Temp = ? WHERE Email = ?");
                    $retrieve->execute([$SecPass, $email]);

                    // Send user success message, and take them to main page
                    echo "<script type='text/javascript'>alert('Successfully Changed Password. An email has been sent to you with your temporary password.'); location.href = 'index.php';</script>";
                
                } catch (phpmailerException $e) {
                    echo "<script type='text/javascript'>alert('Email could not be sent. Please check email address and try again later.')</script>";
                    echo "<script type='text/javascript'>location.href = '404.php'";
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