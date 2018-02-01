<?php
    session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="Styles.css">

<script language="javascript">
    // code from previous project which will come in use later:

    /*function verifyInput() {
        var cardno = document.getElementById("cardno").value;
        var monthex = document.getElementById("expirm").value;
        var yearex = document.getElementById("expiry").value;
        var namecard = document.getElementById("namecard").value;
        var seccode = document.getElementById("seccode").value;
        var errors = "";

        if (!(/^\d{16}$/.test(cardno))) {
            errors += "Please enter a valid 16-digit Card Number.\n"
        } 
        if (!(/^(1[0-2]|0?[1-9])$/.test(monthex))) {
            errors += "Please enter a valid 2-digit Month.\n"
        }
        if (!(/^(1[7-9]|[2-9]\d)$/.test(yearex))) {
            errors += "Please enter a valid 2-digit Year.\n"
        }
        if (!(/^(\w[\w\s\-]*)$/.test(namecard))) {
            errors += "Please do not leave Name blank.\n"
        }
        if (!(/^\d{3}$/.test(seccode))) {
            errors += "Please enter a valid 3-digit Security Code.\n"
        }

        if (!errors == "") {
            alert(errors); return false;
        } else {
            alert("Thank you, your payment details have been accepted. You will recieve a confirmation email soon.");
            return true;
        }
        
    }
*/
</script></head><body>

<table class=heading><tr><td><img src='images/logo.png' width=100></td>
<h1><td class=title><a href="MainPage.php">Smoke Games</td></h1></a>
<td class=links><form id="searchForm" method="POST" action="SearchItems.php">
<span><input type="text" name="searchvalue" class=mainsearch placeholder="Search..."></span></form></td>
<td><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo "<a href='Profile.php'>".$_SESSION['username']."</a>";
    } else {
    echo "<a href='SignUp.php'>Login / Sign Up</a>";
    }?>
</td></tr></table><br><br>

<!-- creating 2 forms on the page so user can sign up or log in
this first form is to sign up -->
<table class=forms><col width="50%"><col width="50%">
<tr><td><form class=signinform onSubmit="return verifycreate()" name="createAcc">
    <h2>Sign Up</h2>
    <input type="text" id="fname" name="fname" placeholder="First Name">
    <input type="text" id="lname" name="lname" placeholder="Last Name">
    <input type="text" id="user" name="user" placeholder="Username">
    <input type="text" id="age" name="age" placeholder="Age">
    <input type="text" id="email" name="email" placeholder="Email">
    <input type="text" id="phoneno" name="phoneno" placeholder="Phone Number">
    <input type="text" id="pass1" name="pass1" placeholder="Password">
    <input type="text" id="pass2" name="pass2" placeholder="Re-enter Password">
    <input class="button" type="submit" value="Sign Up"></form></td>

    <td><form class=signinform action="" method="post">
    <h2>Login</h2>
    <input type="text" id="user" name="user" placeholder="Username">
    <input type="text" id="pass" name="pass" placeholder="Password">
    <input class="button" type="submit" value="Login"></form></div></td></tr></table>

<?php 
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    // login query
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = mysqli_real_escape_string($gamesdb, $_POST['user']);
        $password = mysqli_real_escape_string($gamesdb, $_POST['pass']);
    
        // search users table for one with matching credentials to those entered by user
        $retrieve = "SELECT * FROM Users WHERE Uname = '$username' AND Pass = '$password'";
        $result = mysqli_query($gamesdb, $retrieve);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $id = $row['UserID'];
            // sort session variables of information about user
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;

            // check if user is an admin
            $retrieve = "SELECT * FROM Admins WHERE UserID = '$id'";
            $result = mysqli_query($gamesdb, $retrieve);
            if (mysqli_num_rows($result) == 1) { $_SESSION['admin'] = true; }

            // return user to main page
            header("Location: MainPage.php");
            exit;
        } else {//Couldn't log you in, please check your username and password are correct
        }
    } else {//error logging in 
    }
?>
</body></html>