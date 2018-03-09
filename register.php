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
        function verifyCreate() {
            $uname = $_POST['newuser'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $pass = $_POST['pass1'];
            $repass = $_POST['pass2'];
            $errors = array();

            if (preg_match('/^[a-zA-Z\-]{1,30}$/', $fname) == 0) {
                array_push($errors, ' First name should only be 1 to 30 letters');
            }
            if (preg_match('/^[a-zA-Z\-]{1,40}$/', $fname) == 0) {
                array_push($errors, ' Last name should only be 1 to 40 letters');
            }
            if ($uname != strip_tags($uname)) {
                array_push($errors, ' Please don\'t use tags in your username');
            }
            if ($pass !== $repass) {
                array_push($errors, ' Passwords don\'t match');
            }

            try{
                $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
                $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $find = $gamesdb->prepare("SELECT * FROM Users WHERE Uname = ?");
                $find->execute([$uname]);
                if($find->rowCount()>0){array_push($errors, ' Username taken');}

                $find = $gamesdb->prepare("SELECT * FROM Users WHERE Email = ?");
                $find->execute([$email]);
                if($find->rowCount()>0){array_push($errors, ' An account is already linked to this email');}

            }catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $gamesdb = null;

            if(empty($errors)) {
                return true;
            } else {
                $js_errors = json_encode($errors);
                echo "<script type='text/javascript'>alert(". $js_errors .".toString());</script>";
                return false;
            }
        }
    ?>
</head>

<body>
    <?php include "navigation.php"; ?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="#">Home</a>
                        </li>
                        <li>Sign Up / Log in</li>
                    </ul>

                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h1>Sign Up</h1>

                        <p class="lead">Haven't created an account with us yet?</p>
                        <p>Do it now and gain access to lots of amazing free games!</p>

                        <hr>

                        <form onsubmit="return verifyCreate()" method="post">
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input class="form-control" type="text" id="fname" name="fname" required="required" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input class="form-control" type="text" id="lname" name="lname" required="required" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <label for="name">Username</label>
                                <input class="form-control" type="text" id="newuser" name="newuser" required="required" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="name">Age</label>
                                <input class="form-control" type="number" id="age" name="age" required="required" min="6" max="100" value="NULL" placeholder="Age">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email" required="required" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" id="pass1" name="pass1" required="required" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="password">Re-enter Password</label>
                                <input class="form-control" type="password" id="pass2" name="pass2" required="required" placeholder="Re-enter Password">
                            </div>
                            <div class="form-group">
                                <label for="name">Phone Number</label>
                                <input class="form-control" type="number" id="phoneno" name="phoneno" maxlength="15" value="NULL" placeholder="Phone Number">
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit" value="Sign Up" name="submit_create"><i class="fa fa-user-md"></i> Register</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h1>Login</h1>

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
    if (isset($_SESSION['username'])) {
        header("Location: 404.html");
        exit;
    }
    
    $attempts = 0;
    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        if($_SERVER["REQUEST_METHOD"] == "POST") {

            // If login form has been filled out:
            if(isset($_POST['submit_login'])) {
                $attempts += 1;
                $username = $_POST['user'];
                $password = $_POST['pass'];

                // Try to find user account with details entered
                $retrieve = $gamesdb->prepare("SELECT u.Pass, u.Verified, p.ProName FROM Users u, Profiles p WHERE u.Uname = ? AND u.Uname = p.Uname");
                $retrieve->execute([$username]);

                if ($retrieve->rowCount() == 1) {
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $hash = $row['Pass'];
                    $verf = $row['Verified'];
                    $pname = $row['ProName'];
                    
                    // Check if account verified
                    if ($verf == 1){

                        // Compare passwords
                        //if (password_verify($password, $hash)) {
                        if ($password == $hash) {

                            // Set session variables
                            $_SESSION['username'] = $username;
                            $_SESSION['proname'] = $pname;

                            // Check if user is an admin
                            $retrieve = $gamesdb->prepare("SELECT * FROM Admins WHERE Uname = ?");
                            $retrieve->execute([$username]);
                            
                            if ($retrieve->rowCount() == 1) { 
                                $_SESSION['admin'] = true; 
                            }

                            // Take user to main page
                            echo "<script type='text/javascript'>alert('Successfully Logged In.')</script>";
                            echo "<script type='text/javascript'>location.href = 'index.php';</script>";
                            
                        } else {echo "<script type='text/javascript'>alert('Password Incorrect. ' . (5 - $attempts) . 'Please Try Again.')</script>";}

                    } else {echo "<script type='text/javascript'>alert('Please Verify Account Before Trying To Log In')</script>";}

                } else {echo "<script type='text/javascript'>alert('Username Incorrect. Please Try Again.')</script>";}

                if($attempts > 5){
                    {echo "<script type='text/javascript'>alert('Attempted to login too many times, please try again later.')</script>";}
                }
                
            // If sign up form has been filled out:
            } elseif(isset($_POST['submit_create'])) {
                if(verifyCreate()){
                    $user = $_POST['newuser'];
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $email = $_POST['email'];
                    $age = $_POST['age'];
                    $phone = $_POST['phoneno'];
                    $hash = md5( rand(0,1000) );
                    $pass = $_POST['pass1'];
        +           //$plainPass = $_POST['pass1'];
                    //$pass = password_hash($plainPass, PASSWORD_DEFAULT);

                    // Inserting new user details into the Users and Profiles tables
                    $retrieve = $gamesdb->prepare("INSERT INTO Users (Uname, Fname, Lname, Pass, Email, Age, Phone, ActiveBan, Hashid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $retrieve->execute([$user, $fname, $lname, $pass, $email, $age, $phone, 0, $hash]);

                    $retrievepro = $gamesdb->prepare("INSERT INTO Profiles (Uname, ProName, ProPic, PDesc) VALUES (?, ?, ?, ?)");
                    $retrievepro->execute([$user, $user, 'autopic.png', 'New User']);

                    // Creating email to send to users on registration
                    $message = '
                        Hi '.$user.'
                        Thanks for signing up to Smoke Games!

                        Your account has been created, please verify by clicking the link below:
                        http://www.group.cs.cf.ac.uk/group4/verify.php?email='.$email.'&hash='.$hash.'
                        ';
                        
                    $headers = 'From:smokegames2018@gmail.com' . "\r\n";
                    mail($email, 'Signup | Verification', $message, $headers);

                    // Set session variables
                    $_SESSION['username'] = $user;
                    $_SESSION['proname'] = $user;
                            
                    echo "<script type='text/javascript'>alert('Successfully Created Account. An email has been sent to you, so you can verify your account.')</script>";
                    echo "<script type='text/javascript'>location.href = 'index.php';</script>";
                }
            } elseif(isset($_POST['forgot_pass'])) { 
                echo "<script type='text/javascript'>alert('We will send an email with a temporary password to the email linked to your account')</script>";
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