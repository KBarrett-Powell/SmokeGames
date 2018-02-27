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

        if (!(/^([a-zA-Z]{30})$/.test(fname))) {
            errors += "Please make sure their are no symbols or numbers in your First Name"
        }
        if (!(/^([a-zA-Z]{40})$/.test(lname))) {
            errors += "Please make sure their are no symbols or numbers in your Last Name"
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
                echo "<a href='Profile.php?id=".$_SESSION['id']."'>".$_SESSION['username']."</a>";
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
    <input type="number" id="age" name="age" min="6" max="100" value="NULL" style="margin-left:17%; margin-right:15%" placeholder="Age">
    <input type="email" id="email" name="email" placeholder="Email">
    <input type="number" id="phoneno" name="phoneno" maxlength="15" value="NULL" placeholder="Phone Number">
    <input type="password" id="pass1" name="pass1" required="required" placeholder="Password">
    <input type="password" id="pass2" name="pass2" required="required" placeholder="Re-enter Password">

    <input class="button" type="submit" value="Sign Up" name="submit_create"></form></td>

    <td><form class=signinform action="" name="login" method="post">
    <h2>Login</h2>
    <input type="text" id="user" name="user" required="required" placeholder="Username">
    <input type="password" id="pass" name="pass" required="required" placeholder="Password">

    <input class="button" type="submit" value="Login" name="submit_login"></form></div></td></tr></table>

<?php 
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

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
            $plainPass = mysqli_real_escape_string($gamesdb, $_POST['pass1']);
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
                    echo "User Added Successfully";
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
</body></html>