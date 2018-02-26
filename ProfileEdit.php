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
<td class=links><form id="searchForm" method="GET" action="SearchItems.php">
<span><input type="text" name="searchvalue" class="mainsearch" placeholder="Search..."></span></form></td>
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
</td></tr></table><br>

<div class='proTitle'><h3>Edit Profile</h3></div><br>

<?php 
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    $retrieve = "SELECT * FROM Users WHERE UserID = ".$_SESSION['id'].";";
    $result = mysqli_query($gamesdb, $retrieve);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $uname = $row['Uname'];
        $fname = $row['Fname'];
        $lname = $row['Lname'];
        $email = $row['Email'];
        $desc = $row['PDesc'];
        $img = $row['ProPic'];

        // echo "<table class=forms><tr><td><form class=proeditform onSubmit='' method='post' name='editAcc'>";
        // echo "Username: $uname <input type='text' id='user' name='user'><br>First Name: $fname <input type='text' id='fname' name='fname'><br>";
        // echo "Last Name: $lname <input type='text' id='lname' name='lname'><br>Enail: $email <input type='text' id='email' name='email'><br>";
        // echo "Profile Pic: $img <input type='file' id='propic' name='propic'><br>Description: $desc <input type='text' id='desc' name='desc' size='30'><br>";
        // echo "<button type='cancel'>Cancel</button><button type='submit' name='edit_pro'>Save Changes</button>";
        // echo "</form></td><td><form class=deleteform onSubmit='' method='post' name='delAcc'><button type='delete' onclick='return confirm('Are you sure?')' name='del_pro'>Delete Account</button></td></tr></table>";   
    
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['edit_pro'])) {
                $user = mysqli_real_escape_string($gamesdb, $_POST['user']);
                $fname = mysqli_real_escape_string($gamesdb, $_POST['fname']);
                $lname = mysqli_real_escape_string($gamesdb, $_POST['lname']);
                $propic = $_POST['propic'];
                $desc = mysqli_real_escape_string($gamesdb, $_POST['desc']);

                $currentid = $_SESSION['id'];

                if ($user != null) {
                    $retrieve = "SELECT Uname FROM Users WHERE Uname = '$user'";
                    $result = mysqli_query($gamesdb, $retrieve);

                    if (mysqli_num_rows($result) == 1) {
                        echo "Username Taken";
                    } else if('ur mum') {
                    } else {
                        $update = "UPDATE Users SET Uname = '$user' WHERE UserID = '$currentid';";
                        $upres = mysqli_query($gamesdb, $update);
                        if (!$upres) {
                            echo "Couldn't update username. Please try again.";
                        } else {
                            echo "Username updated successfully";
                        }
                    }
                }

                if ($fname != null) {
                    $update = "UPDATE Users SET Fname = '$fname' WHERE UserID = '$currentid';";
                    $result = mysqli_query($gamesdb, $update);
                    if (!$result) {
                        echo "Couldn't update name. Please try again.";
                    } else {
                        echo "First name updated successfully";
                    }
                }

                if ($lname != null) {
                    $update = "UPDATE Users SET Lname = '$lname' WHERE UserID = '$currentid';";
                    $result = mysqli_query($gamesdb, $update);
                    if (!$result) {
                        echo "Couldn't update name. Please try again.";
                    } else {
                        echo "Last name updated successfully";
                    }
                }

                if ($propic != null) {
                    // $target_dir = "images/userProfiles/";
                    // $target_file = $target_dir.basename($_FILES["$propic"]);
                    // $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    // $check = getimagesize($_FILES["$propic"]);

                    if ($check) {
                        $update = "UPDATE Users SET ProPic = '$propic' WHERE UserID = '$currentid';";
                        $result = mysqli_query($gamesdb, $update);
                        // move_uploaded_file($_FILES["$propic"], $target_file);
                        if (!$result) {
                            echo "Couldn't update picture. Please try again.";
                        } else {
                            echo "Profile picture updated successfully";
                        }
                    } else {
                        echo "Couldn't update picture. Please make sure you're uploading an image.";
                    }
                }

                if ($desc != null) {
                    $update = "UPDATE Users SET PDesc = '$desc' WHERE UserID = '$currentid';";
                    $result = mysqli_query($gamesdb, $update);
                    if (!$result) {
                        echo "Couldn't update description. Please try again.";
                    } else {
                        echo "Description updated successfully";
                    }
                }

            } else if (isset($_POST['del_pro'])) {
                $id = $_SESSION['id'];
                $retrieve = "DELETE FROM Users WHERE UserID = '$id';";
                $result = mysqli_query($gamesdb, $retrieve);

                $friendDel = "DELETE FROM Friends WHERE UserID1 = '$id' OR UserID2 = '$id';";
                $fridel = mysqli_query($gamesdb, $friendDel);
                if($result && $fridel) {
                    echo "User deleted successfully.";
                    header("Location: Sessions.php");
                } else {
                    echo "User not deleted.";
                }
            }
        }
    }
?>
</body></html>