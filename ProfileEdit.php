<?php
session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="Styles.css">
</head><body>

<table class=heading><tr><td><img src='images/logo.png' width=100></td>
<h1><td class=title><a href="MainPage.php">Smoke Games</td></h1></a>
<td class=links><form id="searchForm" method="POST" action="SearchItems.php">
<span><input type="text" name="searchvalue" class="mainsearch" placeholder="Search..."></span></form></td>
<td><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo "<a href='Profile.php'>".$_SESSION['username']."</a>";
    } else {
    echo "<a href='SignUp.php'>Login / Sign Up</a>";
    }?>
</td></tr></table><br>

<div class='proTitle'><h3>Edit Profile</h3></div><br>

<!-- form for user to change some settings about their profile, includes uploading a file (image), so users can have a profile picture -->
<table class=forms>
<tr><td><form class=proeditform onSubmit="" name="editAcc">
    Username: <input type="text" id="user" name="user"><br>
    First Name: <input type="text" id="fname" name="fname"><br>
    Last Name: <input type="text" id="lname" name="lname"><br>
    Profile Pic: <input type="file" id="propic" name="propic"><br>
    Description: <input type="text" id="desc" name="desc" size="30"><br>
    <button type="cancel">Cancel</button>
    <button type="submit">Save Changes</button>
    </form></td></tr></table>

<?php 
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 
    // CODE - need to implement updating tables with info
?>
</body></html>