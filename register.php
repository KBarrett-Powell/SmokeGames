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
        Smoke Games - Sign Up
    </title>

    <?php include "references.php"; ?>

    <script language="javascript">
        // code from previous project which will come in use later:

        function verifyCreate() {
            var fname = document.getElementById("fname").value;
            var lname = document.getElementById("lname").value;
            var pass1 = document.getElementById("pass1").value;
            var pass2 = document.getElementById("pass2").value;
            var errors = "";

            if (!(/^([a-zA-Z]{1,30})$/.test(fname))) {
                errors += "Please make sure their are no symbols or numbers in your First Name. "
            }
            if (!(/^([a-zA-Z]{1,40})$/.test(lname))) {
                errors += "Please make sure their are no symbols or numbers in your Last Name. "
            }
            //check username unique
            if (pass1 != pass2) {
                errors += "Passwords do not match!"
            }
            //tests for email and passwords too

            if (!errors == "") {
                alert(errors); 
                return false;
            } else {
                alert("Your account has been created");
                return true;
            }

        }
    </script>

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
                        <li>New account / Sign in</li>
                    </ul>

                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h1>New account</h1>

                        <p class="lead">Not our registered customer yet?</p>
                        <p>With registration with us new world of fashion, fantastic discounts and much more opens to you! The whole process will not take you more than a minute!</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.html">contact us</a>, our customer service center is working for you 24/7.</p>

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
                                <input class="form-control" type="number" id="age" name="age" min="6" max="100" value="NULL" placeholder="Age">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="Email">
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

                        <p class="lead">Already our customer?</p>
                        <p class="text-muted">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies
                            mi vitae est. Mauris placerat eleifend leo.</p>

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
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

<?php 
    // login query
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['submit_login'])) {
            $username = mysqli_real_escape_string($gamesdb, $_POST['user']);
            $password = mysqli_real_escape_string($gamesdb, $_POST['pass']);
            
            // search users table for one with matching credentials to those entered by user
            $retrieve = "SELECT UserID, Pass FROM Users WHERE Uname = '$username'";
            $result = mysqli_query($gamesdb, $retrieve);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $id = $row['UserID'];
                $hash = $row['Pass'];
                
                //if (password_verify($password, $hash)) {
                if ($password == $hash) {
                    // sort session variables of information about user
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['id'] = $id;

                    // check if user is an admin
                    $retrieve = "SELECT * FROM Admins WHERE UserID = '$id'";
                    $result = mysqli_query($gamesdb, $retrieve);
                    if (mysqli_num_rows($result) == 1) { $_SESSION['admin'] = true; }

                    // return user to main page
                    echo "<script>alert('You are now logged in!')</script>";
                    header("Location: index.php");
                    exit;

                } else {
                    echo "Password Incorrect. Please Try Again.";
                }
            } else {echo "Username Incorrect. Please Try Again.";}
            
        } elseif(isset($_POST['submit_create'])) {
            $fname = mysqli_real_escape_string($gamesdb, $_POST['fname']);
            $lname = mysqli_real_escape_string($gamesdb, $_POST['lname']);
            $user = mysqli_real_escape_string($gamesdb, $_POST['newuser']);
            $age = mysqli_real_escape_string($gamesdb, $_POST['age']);
            $phone = mysqli_real_escape_string($gamesdb, $_POST['phoneno']);
            $email = mysqli_real_escape_string($gamesdb, $_POST['email']);
            $pass = mysqli_real_escape_string($gamesdb, $_POST['pass1']);
+           //$plainPass = mysqli_real_escape_string($gamesdb, $_POST['pass1']);
            //$cryptpass = password_hash($plainPass, PASSWORD_DEFAULT);
            //$pass = mysqli_real_escape_string($gamesdb, $cryptpass);

            $nextId = "SELECT max(UserID) FROM Users";
            $result = mysqli_query($gamesdb, $nextId);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $id = $row['max(UserID)'] + 1;

                //This code works to update the database but doesnt put NULL values in there
                $insert = "INSERT INTO Users (UserID, Fname, Lname, Uname, Pass, Email, Age, Phone, ProPic, PDesc, ActiveBan) 
                VALUES ('$id', '$fname', '$lname', '$user', '$pass',". (($email=='')?"NULL":("'".$email."'")) .",". (($age=='')?"NULL":("'".$age."'")) .", 
                ". (($phone=='')?"NULL":("'".$phone."'")) .", 'autopic.png', 'New User', 0)";
                $added = mysqli_query($gamesdb, $insert);

                if (!$added) {
                    echo "Couldn't enter data: ".mysqli_error($gamesdb);
                } else {
                     echo "<script>alert('Your account has been created')</script>";
                    // sort session variables of information about user
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $user;
                    $_SESSION['id'] = $id;
                    
                    header("Location: index.php");
                    exit;
                }
            }
        }
    } 
?>
    </div>
    <!-- /#all -->

<?php include "footer.php"; ?>
    
</body>

</html>
