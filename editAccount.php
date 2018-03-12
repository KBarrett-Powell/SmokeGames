<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Edit Profile
    </title>

    <?php 
        include "references.php"; 
        include "require.php";

        if(!isset($_SESSION['verified']) || $_SESSION['verified'] == false){
            echo "<script type='text/javascript'>location.href = 'verification.php';</script>";
        }
        try{
            $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
            $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE Uname = ?");
            $retrieve->execute([$_SESSION['username']]);
        
            if ($retrieve->rowCount() == 1) {
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $uname = $row['Uname'];
                $email = $row['Email'];
                $age = $row['Age'];
                $phone = $row['Phone'];
                if ($email != null) {
                    $email = substr($email, 0, 3).str_repeat("*", strlen($email) - 3);
                }

            } else {
                echo "<script type='text/javascript'>location.href = '404.html';</script>";
            }

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $gamesdb = null;
    ?>   

</head>

<body>

    <?php include "navigation.php"; ?>
    
    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li>View Account</li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <!-- CUSTOMER MENU -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">My Account</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <?php echo "<a href='profile.php?id=$uname'><i class='fa fa-list'></i>My profile</a>"; ?>
                                </li>
                                <li>
                                    <a href="editProfile.php"><i class="fa fa-heart"></i> Edit Profile</a>
                                </li>
                                <li class="active">
                                    <a href="#"><i class="fa fa-user"></i> Edit Account</a>
                                </li>
                                <li>
                                    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>My account</h1>
                        <p class="lead">View your personal details here.</p>
                        
                        <hr>

                        <h3>Change password</h3>

                        <form onSubmit='' method='post' name='editPass'>
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

                            <div class="col-sm-12 text-center">
                                <button type="submit" value="send" class="btn btn-primary"><i class="fa fa-save"></i> Save new password</button>
                            </div>
                        </form>

                        <!-- FORM FOR EDIT DETAILS. -->
                        <form action="" method="post" name="edit_form">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newuser">Username </label>
                                        <?php echo "<input type='text' class='form-control' id='newuser' placeholder='$uname'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newemail">Email </label>
                                        <?php echo "<input type='text' class='form-control' id='newemail' placeholder='$email'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newage">Age </label>
                                        <?php echo "<input type='text' class='form-control' id='newage' placeholder='$age'>"; ?>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newphone">Phone Number </label>
                                        <?php echo "<input type='text' class='form-control' id='newphone' placeholder='$phone'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- On submit require password to be entered -->
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="edit_acc"><i class="fa fa-save"></i> Save changes</button>
                                    <button type="cancel" class="btn btn-primary"><i class="fa fa-save"></i> Cancel</button>
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

<?php include "footer.php"; 
    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['edit_acc'])) {
                // NEED to make user log in for the rest of this????
                
            }
        }

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>  
</body>
</html>