<?php
    session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="Styles.css">

<script language="javascript">
    // code from previous project which will come in use later:

    function verifyCreate() {
        var fname = document.getElementById("fname").value;
        var lname = document.getElementById("lname").value;
        var pass1 = document.getElementById("pass1").value;
        var pass2 = document.getElementById("pass2").value;
        var errors = "";

        if (!(/^([a-zA-Z]{1,30})$/.test(fname))) {
            errors += "Please make sure your first name is between 1 and 30 letters, no symbols or numbers\n"
        }
        if (!(/^([a-zA-Z]{1,40})$/.test(lname))) {
            errors += "Please make sure your last name is between 1 and 40 letters, no symbols or numbers\n"
        }
        //check username unique
        <?php
            try{
                $uname = mysqli_real_escape_string($gamesdb, $_POST['newuser']);

                $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
                $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $find = $gamesdb("SELECT * FROM Users WHERE Uname = ?");
                $find->execute([$uname]);

                if($find->rowCount() > 0) {
                    echo "<script>errors += 'Username not unique\n'</script";
                }

                if($uname != strip_tags($uname)) {
                    "<script>errors += 'Please don't put any tags in your username\n'</script";
                }

            }catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            $gamesdb = null;
        ?>

        if (pass1 != pass2) {
            errors += "Passwords do not match!\n"
        }

        if (!errors == "") {
            alert(errors); 
            return false;
        } else {
            return true;
        }
        
    }
</script></head><body>

<table class=heading><tr><td><img src='images/logo.png' width=100></td>
<h1><td class=title><a href="index.php">Smoke Games</td></h1></a>
<td class=links><form id="searchForm" method="GET" action="SearchItems.php">
<span><input type="text" name="searchvalue" class=mainsearch placeholder="Search..."></span></form></td>
<td><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
             // display a different page in nav bar depending on if user is logged in and what type of user they are
             if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
                  echo "<a href='Admin.php'>Admin</a>";
             } else {
                echo "<a href='Profile.php?id=".$_SESSION['username']."'>".$_SESSION['username']."</a>";
             }
        } else {
            echo "<a href='SignUp.php'>Login / Sign Up</a>";
        }?>
</td></tr></table><br><br>

<!-- creating 2 forms on the page so user can sign up or log in. This first form is to sign up -->
<table class=forms><col width="50%"><col width="50%">
<!-- onSubmit="return verifyCreate()" -->
<tr><td><form class=signinform  onsubmit="return verifyCreate()" method="post">
    <h2>Sign Up</h2>
    <input type="text" id="fname" name="fname" required="required" placeholder="First Name">
    <input type="text" id="lname" name="lname" required="required" placeholder="Last Name">
    <input type="text" id="newuser" name="newuser" required="required" placeholder="Username">
    <input type="number" id="age" name="age" required="required" min="6" max="100" value="NULL" style="margin-left:17%; margin-right:15%" placeholder="Age">
    <input type="email" id="email" name="email" required="required" placeholder="Email">
    <input type="number" id="phoneno" name="phoneno" maxlength="15" value="NULL" placeholder="Phone Number">
    <input type="password" id="pass1" name="pass1" required="required" placeholder="Password">
    <input type="password" id="pass2" name="pass2" required="required" placeholder="Re-enter Password">

    <input class="button" type="submit" value="Sign Up" name="submit_create"></form></td>

    <td><form class=signinform action="" name="login" method="post">
    <h2>Login</h2>
    <input type="text" id="user" name="user" required="required" placeholder="Username">
    <input type="password" id="pass" name="pass" required="required" placeholder="Password">

    <input class="button" type="submit" value="Login" name="submit_login">
    <input class="button" type="submit" value="Forgot" name="forgot_pass"></form></div></td></tr></table>

<?php 
    $attempts = 0;
    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // login query
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['submit_login'])) {
                $attempts += 1;
                $username = mysqli_real_escape_string($gamesdb, $_POST['user']);
                $password = mysqli_real_escape_string($gamesdb, $_POST['pass']);
                
                // search users table for one with matching credentials to those entered by user
                $retrieve = $gamesdb->prepare("SELECT u.Pass, u.Verified, p.ProName FROM Users u, Profiles p WHERE Uname = ?");
                $retrieve->execute([$username]);
                
                if ($retrieve->rowCount() == 1) {
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $hash = $row['Pass'];
                    $verf = $row['Verified'];
                    $pname = $row['ProName'];
                        
                    if ($verf == 1){
                        //if (password_verify($password, $hash)) {
                        if ($password == $hash) {
                            // sort session variables of information about user
                            $_SESSION['username'] = $username;
                            $_SESSION['proname'] = $pname;

                            // check if user is an admin
                            $retrieve = $gamesdb->prepare("SELECT * FROM Admins WHERE Uname = ?");
                            $retrieve->execute([$username]);
                            if ($retrieve->rowCount() == 1) { $_SESSION['admin'] = true; }

                            // return user to main page
                            header("Location: index.php");
                            exit;
                            
                        } else {
                            echo "<script type='text/javascript'>alert('Password Incorrect. Please Try Again.')</script>";
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Please Verify Account Before Trying To Log In')</script>";
                    }
                } else {echo "<script type='text/javascript'>alert('Username Incorrect. Please Try Again.')</script>";}

                if($attempts > 5){
                    {echo "<script type='text/javascript'>alert('Attempted to login too many times, please try again later.')</script>";}
                }
                
            } elseif(isset($_POST['submit_create'])) {
                $fname = mysqli_real_escape_string($gamesdb, $_POST['fname']);
                $lname = mysqli_real_escape_string($gamesdb, $_POST['lname']);
                $user = mysqli_real_escape_string($gamesdb, $_POST['newuser']);
                $age = mysqli_real_escape_string($gamesdb, $_POST['age']);
                $phone = mysqli_real_escape_string($gamesdb, $_POST['phoneno']);
                $email = mysqli_real_escape_string($gamesdb, $_POST['email']);
                $hash = md5( rand(0,1000) );
                $pass = mysqli_real_escape_string($gamesdb, $_POST['pass1']);
                //$plainPass = $_POST['pass1'];
                //$cryptpass = password_hash($plainPass, PASSWORD_DEFAULT);
                //$pass = mysqli_real_escape_string($gamesdb, $cryptpass);

                $nextId = $gamesdb->prepare("SELECT max(UserID) FROM Users");
                $nextId->execute();
                if ($nextId->rowCount() == 1) {
                    $row = $nextId->fetch(PDO::FETCH_ASSOC);
                    $id = $row['max(UserID)'] + 1;

                    //This code works to update the database but doesnt put NULL values in there
                    $insert = $gamesdb->prepare("INSERT INTO Users (UserID, Fname, Lname, Uname, Pass, Email, Age, Phone, ActiveBan, Hashid) 
                    VALUES (?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?, ?)");
                    $insert->exec([$id, $fname, $lname, $user, $pass, $email, $age, $phone, 0, $hash]);

                    $insertpro = $gamesdb->prepare("INSERT INTO Profiles (Uname, ProName, ProPic, PDesc) VALUES (?, ?, ?, ?)");
                    $insertpro = exec([$user, $user, 'autopic.png', 'New User']);

                    $message = '
                        Hi '.$user.'
                        Thanks for signing up to Smoke Games!

                        Your account has been created, please verify by clicking the link below:
                        http://www.group.cs.cf.ac.uk/group4/verify.php?email='.$email.'&hash='.$hash.'
                        ';
                    
                    $headers = 'From:smokegames2018@gmail.com' . "\r\n";
                    mail($email, 'Signup | Verification', $message, $headers);

                    echo "<script>alert('Your account has been created')</script>";
                    // sort session variables of information about user
                    $_SESSION['username'] = $user;
                    $_SESSION['proname'] = $user;
                        
                    header("Location: index.php");
                    exit;
                }
            } elseif(isset($_POST['forgot_pass'])) { 
                echo "<script>alert('We will send an email with a temporary password to the email linked to your account')</script>";

            }
        }
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>
</body></html>