<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Edit Profile
    </title>

    <?php include "references.php"; 

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //Code to update password:
            
            if (!(isset($_SESSION['username']) || $_SESSION['username'] == '')){
                header("location: index.php");
            }

            $getCurrentPass = "SELECT Pass FROM Users WHERE UserID =".$_SESSION['id'];
            
            $result = mysqli_query($gamesdb, $getCurrentPass);
            $row = mysqli_fetch_assoc($result);
            $currentPass = $row['Pass'];
            


            $password0 = mysqli_real_escape_string($gamesdb, $_POST['oldPassword']);
            $password1 = mysqli_real_escape_string($gamesdb, $_POST['newPassword']);
            $password2 = mysqli_real_escape_string($gamesdb, $_POST['confirmPassword']);

            $username = mysqli_real_escape_string($gamesdb, $_SESSION['username']);

            //Check if user confirm password is correct.
            if ($password1 <> $password2){
                echo "<script>alert('Your passwords do not match.')</script>";
            }
            //Check if old password matches the database.
            else if ($currentPass != $password0){
                echo "<script>alert('Old password entered incorrectly.')</script>";
            }
            else if ($currentPass == $password0){
                mysqli_query($gamesdb, "UPDATE Users SET Pass='$password1' WHERE UserID =".$_SESSION['id']);
                echo "You have successfully changed your password.";
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
                        <li>Edit Account / Profile</li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <!-- CUSTOMER MENU -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Customer section</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li class="active">
                                    <a href="profile.php"><i class="fa fa-list"></i>My profile</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-heart"></i> My wishlist</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-user"></i> My account</a>
                                </li>
                                <li>
                                    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /.col-md-3 -->

                    <!-- CUSTOMER MENU END -->
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>My account</h1>
                        <p class="lead">Change your personal details or your password here.</p>
                        <p class="text-muted">Be sure to remember your new password.</p>
                        
                        <!-- FORM FOR CHANGE PASSWORD. -->

                        <h3>Change password</h3>

                        <form onSubmit='' method='post' name='editPass'>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_old">Old password</label>
                                        <input class="form-control" type="password" id="InputPassword1" placeholder="Old Password.." name="oldPassword">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_1">New password</label>
                                        <input class="form-control" type="password" id="InputPassword2" placeholder="New Password..." name="newPassword">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_2">Retype new password</label>
                                        <input class="form-control" type="password" id="InputPassword3" placeholder="Confirm Password" name="confirmPassword">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                            <div class="col-sm-12 text-center">
                                <button type="submit" value="send" class="btn btn-primary"><i class="fa fa-save"></i> Save new password</button>
                            </div>
                        </form>
                        
                        <hr>

                        <!-- FORM FOR EDIT DETAILS. -->
                        
                        <h3>Personal details</h3>
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">First Name</label>
                                        <input type="text" class="form-control" id="firstname">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname">Username</label>
                                        <input type="text" class="form-control" id="lastname">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="company">Last Name</label>
                                        <input type="text" class="form-control" id="company">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="street">Email</label>
                                        <input type="text" class="form-control" id="street">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-sm-6 col-md-2">
                                    <div class="form-group">
                                        <label for="city">Age</label>
                                        <input type="text" class="form-control" id="city">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label for="zip">Phone</label>
                                        <input type="text" class="form-control" id="zip">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="state">Profile Image</label>
                                       <input type="file" class="form-control" id="state">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="state">Banner Image</label>
                                       <input type="file" class="form-control" id="state">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phone">Description</label>
                                        <input type="text" class="form-control" id="phone">
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->


    


    </div>
    <!-- /#all -->

<?php include "footer.php"; ?>
    

</body>

</html>