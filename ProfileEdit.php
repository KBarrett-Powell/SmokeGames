<?php
session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="Styles.css">
</head><body>

<table class=heading><tr><td><img src='images/logo.png' width=100></td>
<h1><td class=title><a href="index.php">Smoke Games</td></h1></a>
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
<tr><td><form class=proeditform onSubmit="" method="post" name="editAcc">
    Username: <input type="text" id="user" name="user"><br>
    First Name: <input type="text" id="fname" name="fname"><br>
    Last Name: <input type="text" id="lname" name="lname"><br>
    Profile Pic: <input type="file" id="propic" name="propic"><br>
    Description: <input type="text" id="desc" name="desc" size="30"><br>
    <button type="cancel">Cancel</button>
    <button type="submit" name="edit_pro">Save Changes</button>
    </form></td><td><form class=deleteform onSubmit="" method="post" name="delAcc">
    <input type="hidden" name="hidDel" value="hidDel">
    <button type="delete" onclick="return confirm('Are you sure?')" name="del_pro">Delete Account</button></td></tr></table>

<?php 
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['edit_pro'])) {
            $user = mysqli_real_escape_string($gamesdb, $_POST['user']);
            $fname = mysqli_real_escape_string($gamesdb, $_POST['fname']);
            $lname = mysqli_real_escape_string($gamesdb, $_POST['lname']);
            $propic = mysqli_real_escape_string($gamesdb, $_POST['propic']);
            $desc = mysqli_real_escape_string($gamesdb, $_POST['desc']);

            $currentid = $_SESSION['id'];

            if ($user != null) {
                $retrieve = "SELECT Uname FROM Users WHERE Uname = '$user'";
                $result = mysqli_query($gamesdb, $retrieve);

                if (mysqli_num_rows($result) == 1) {
                    echo "Username Taken";
                } else {
                    $update = "UPDATE Users SET Uname = '$user' WHERE UserID = '$currentid'";
                    $upres = mysqli_query($gamesdb, $update);
                    if (!$upres) {
                        echo "Couldn't update username. Please try again.";
                    } else {
                        echo "Username updated successfully";
                    }
                }
            }

            if ($fname != null) {
                $update = "UPDATE Users SET Fname = '$fname' WHERE UserID = '$currentid'";
                $result = mysqli_query($gamesdb, $update);
                if (!$result) {
                    echo "Couldn't update name. Please try again.";
                } else {
                    echo "First name updated successfully";
                }
            }

            if ($lname != null) {
                $update = "UPDATE Users SET Lname = '$lname' WHERE UserID = '$currentid'";
                $result = mysqli_query($gamesdb, $update);
                if (!$result) {
                    echo "Couldn't update name. Please try again.";
                } else {
                    echo "Last name updated successfully";
                }
            }

            if ($propic != null) {
                $update = "UPDATE Users SET ProPic = '$propic' WHERE UserID = '$currentid'";
                $result = mysqli_query($gamesdb, $update);
                if (!$result) {
                    echo "Couldn't update picture. Please try again.";
                } else {
                    echo "Profile picture updated successfully";
                }
            }

            if ($desc != null) {
                $update = "UPDATE Users SET PDesc = '$desc' WHERE UserID = '$currentid'";
                $result = mysqli_query($gamesdb, $update);
                if (!$result) {
                    echo "Couldn't update description. Please try again.";
                } else {
                    echo "Description updated successfully";
                }
            }
        } else if (isset($_POST['del_pro'])) {
            $id = $_SESSION['id'];
            $retrieve = "DELETE FROM Users WHERE UserID = '$id'";
            $result = mysqli_query($gamesdb, $retrieve);
            if($result) {
                echo "User deleted successfully.";
                header("Location: Sessions.php");
            } else {
                echo "User not deleted.";
            }
        }
    }
?>
</body></html>