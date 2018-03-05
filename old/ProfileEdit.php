<?php
session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="Styles.css">
<script language="javascript">
    function user_check() {
        var user = prompt("Please enter your new username", "new user");
        var pass = prompt("Please enter your password to confirm this change", "****")
        <?php

        ?> 

    }
</script></head><body>

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
    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

            if ($email != null) {
                $email = substr($email, 0, 3).str_repeat("*", strlen($email) - 3);
            }

            echo "<table class=forms><tr><td><form class=proeditform onSubmit='' method='post' name='editAcc'>";
            echo "Username: $uname <button name='edit' value='user'>Edit</button><br>";
            echo "First Name: $fname <button name='edit' value='fname'>Edit</button><br>";
            echo "Last Name: $lname <button name='edit' value='lname'>Edit</button><br>";
            echo "Email: $email <button name='edit' value='email'>Edit</button><br>";
            echo "Profile Pic: $img <button name='edit' value='propic'>Edit</button><br>";
            echo "Description: $desc <button name='edit' value='desc'>Edit</button><br>";
            echo "Password: ************* <button name='edit' value='pass'>Change</button><br>";
            echo "<button name='delete' id='delete'>Delete Account</button></td></tr></form>";   
    
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $currentid = $_SESSION['id'];
                if (isset($_POST['edit'])) {
                    if($_POST['edit']=='user') {
                        echo("<script type='text/javascript'> var user = prompt('Enter new username'); </script>");
                        $user = "<script type='text/javascript'> document.write(user); </script>";

                        $retrieve = "SELECT Uname FROM Users WHERE Uname = '$user'";
                        $result = mysqli_query($gamesdb, $retrieve);

                        if (mysqli_num_rows($result) == 1) {
                            echo "<script>alert('Username Taken')</script>";
                        } else if($user.contains("<script>")) {
                            echo "<script>alert('Please don't put code in your username.')</script>";
                        } else {
                            $update = "UPDATE Users SET Uname = '$user' WHERE UserID = '$currentid';";
                            $upres = mysqli_query($gamesdb, $update);
                            if (!$upres) {
                                echo "<script>alert('Couldn't update username. Please try again.')</script>";
                            } else {
                                echo "<script>alert('Username updated successfully')</script>";
                            }
                        }
                    }

                    } else if($_POST['edit']=='fname') {
                        echo("<script type='text/javascript'> var fname = prompt('Enter new first name'); </script>");
                        $fname = "<script type='text/javascript'> document.write(fname); </script>";

                        $update = "UPDATE Users SET Fname = '$fname' WHERE UserID = '$currentid';";
                        $result = mysqli_query($gamesdb, $update);
                        if (!$result) {
                            echo "<script>alert('Couldn't update name. Please try again.')</script>";
                        } else {
                            echo "<script>alert('First name updated successfully')</script>";
                        }

                    } else if($_POST['edit']=='lname') {
                        echo("<script type='text/javascript'> var lname = prompt('Enter new last name'); </script>");
                        $lname = "<script type='text/javascript'> document.write(lname); </script>";

                        $update = "UPDATE Users SET Lname = '$lname' WHERE UserID = '$currentid';";
                        $result = mysqli_query($gamesdb, $update);
                        if (!$result) {
                            echo "<script>alert('Couldn't update name. Please try again.')</script>";
                        } else {
                            echo "<script>alert('Last name updated successfully')<script>";
                        }

                    } else if($_POST['edit']=='email') {
                        echo("<script type='text/javascript'> var email = prompt('Enter new email'); </script>");
                        $email = "<script type='text/javascript'> document.write(email); </script>";

                        $update = "UPDATE Users SET email = '$email' WHERE UserID = '$currentid';";
                        $result = mysqli_query($gamesdb, $update);
                        if (!$result) {
                            echo "<script>alert('Couldn't update name. Please try again.')</script>";
                        } else {
                            echo "<script>alert('Last name updated successfully')</script>";
                        }

                    } else if($_POST['edit']=='propic') {
                        echo("<script type='text/javascript'> var propic = prompt('Upload new profile picture'); </script>");
                        $propic = "<script type='text/javascript'> document.write(propic); </script>";
                        // $target_dir = "images/userProfiles/";
                        // $target_file = $target_dir.basename($_FILES["$propic"]);
                        // $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        // $check = getimagesize($_FILES["$propic"]);

                        if ($check) {
                            $update = "UPDATE Users SET ProPic = '$propic' WHERE UserID = '$currentid';";
                            $result = mysqli_query($gamesdb, $update);
                            // move_uploaded_file($_FILES["$propic"], $target_file);
                            if (!$result) {
                                echo "<script>alert('Couldn't update picture. Please try again.')</script>";
                            } else {
                                echo "<script>alert('Profile picture updated successfully')</script>";
                            }
                        } else {
                            echo "<script>alert('Couldn't update picture. Please make sure you're uploading an image.')</script>";
                        }

                    } else if($_POST['edit']=='desc') {
                        echo("<script type='text/javascript'> var desc = prompt('Enter new description'); </script>");
                        $desc = "<script type='text/javascript'> document.write(desc); </script>";

                        $update = "UPDATE Users SET PDesc = '$desc' WHERE UserID = '$currentid';";
                        $result = mysqli_query($gamesdb, $update);
                        if (!$result) {
                            echo "<script>alert('Couldn't update description. Please try again.')</script>";
                        } else {
                            echo "<script>alert('Description updated successfully')</script>";
                        }
                    }
                }
                if(isset($_POST['del_pro'])) {
                    $id = $_SESSION['id'];
                    $retrieve = "DELETE FROM Users WHERE UserID = '$id';";
                    $result = mysqli_query($gamesdb, $retrieve);

                    $friendDel = "DELETE FROM Friends WHERE UserID1 = '$id' OR UserID2 = '$id';";
                    $fridel = mysqli_query($gamesdb, $friendDel);

                    if($result && $fridel) {
                        echo "<script>alert('User deleted successfully.')</script>";
                        header("Location: Sessions.php");
                    } else {
                        echo "<script>alert('User not deleted.')</script>";
                    }
                }
        }
        
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
</body></html>