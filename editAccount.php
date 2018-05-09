<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        Smoke Games - Edit Account
    </title>

    <?php 
        include "references.php"; 
        include "require.php";

        if(!isset($_SESSION['verified']) || ($_SESSION['verified'] == false && $_SESSION['justFrom'] == 0)){
            echo "<script type='text/javascript'>location.href = 'verification.php';</script>";
        }

        try{
            include "config.php";
            $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE UID = ?");
            $retrieve->execute([$_SESSION['id']]);
        
            if ($retrieve->rowCount() == 1) {
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $uid = $row['UID'];
                $uname = $row['Uname'];
                $email = $row['Email'];
                $age = $row['Age'];
                $phone = $row['Phone'];
                if ($email != null) {
                    $email = substr($email, 0, 3).str_repeat("*", strlen($email) - 3);
                }

            } else {
                echo "<script type='text/javascript'>location.href = '404.php';</script>";
            }

        } catch(PDOException $e) {
            echo "<script type='text/javascript'>location.href = '404.php'";
        }
        $gamesdb = null;

        function verifyAccEdit() {
            $nuser = $_POST['newuser'];
            $nemail = $_POST['newemail'];
            $nage = $_POST['newage'];
            $nphone = $_POST['newphone'];
            $errors = array();

            if ($nage != "") {
                if (preg_match('/^[4-9]|[1-9][0-9]$/', $nage) == 0) {
                    array_push($errors, "Please enter an age between 4 and 99\n");
                }
            }
            if ($nphone != "") {
                if (preg_match('/^[0-9]{11}$/', $nphone) == 0) {
                    array_push($errors, "Please enter an 11 digit phone number, with no special characters\n");
                }
            }
            if ($nuser != "") {
                if ($nuser != strip_tags($nuser)) {
                    array_push($errors, "Please don't use tags in your username\n");
                }
            }
            if ($nemail != "") {
                if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                    array_push($errors, "Please enter a valid email\n");
                }
            }

            try{
                include "config.php";
                if ($nuser != "") {
                    $find = $gamesdb->prepare("SELECT * FROM Users WHERE Uname = ?");
                    $find->execute([$nuser]);
                    if($find->rowCount()>0){array_push($errors, "Username taken\n");}
                }

                if ($nemail != "") {
                    $find = $gamesdb->prepare("SELECT * FROM Users WHERE Email = ?");
                    $find->execute([$nemail]);
                    if($find->rowCount()>0){array_push($errors, "An account is already linked to this email\n");}
                }

            }catch(PDOException $e) {
                echo "<script type='text/javascript'>location.href = '404.php'";
            }
            $gamesdb = null;

            return $errors;
        }

        function verifyPass() {
            $pass = $_POST['Pass1'];
            $repass = $_POST['Pass2'];
            $errors = array();

            if ($pass !== $repass) {
                array_push($errors, "Passwords don't match\n");
            } 
            if (preg_match('~(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])^[a-zA-Z0-9$£\\\'"@-_]{8,40}$~', $pass) == 0) {
                array_push($errors, "Passwords must contain at least one number, one uppercase, and one lowercase letter, and must be between 8-40 characters\n");
            }

            return $errors;
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
                        <li><a href="index.php">Home</a></li>
                        <?php echo "<li><a href='profile.php?id=".$_SESSION['id']."'>Profile</a></li>"?>
                        <li>View Account</li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">My Account</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <?php echo "<a href='profile.php?id=".$_SESSION['id']."'><i class='fa fa-list'></i>My profile</a>"; ?>
                                </li>
                                <li>
                                    <a href="editProfile.php"><i class="fa fa-heart"></i> Edit Profile</a>
                                </li>
                                <li class="active">
                                    <a href="#"><i class="fa fa-user"></i> Edit Account</a>
                                </li>
                                <?php 
                                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
                                        echo "<li><a href='admin.php'><i class='fa fa-user'></i> Admin</a></li>";
                                    }
                                ?>
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

                        <form action='editAccount.php' method='post' name='editPass'>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_1">New password</label>
                                        <input class="form-control" type="password" id="Pass1" placeholder="New Password..." name="Pass1">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_2">Retype new password</label>
                                        <input class="form-control" type="password" id="Pass2" placeholder="Confirm Password..." name="Pass2">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-center">
                                <button type="submit" value="send" name="edit_pass" class="btn btn-primary"><i class="fa fa-save"></i> Save new password</button>
                            </div>
                        </form>

                        <form action="editAccount.php" method="post" name="edit_form">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newuser">Username </label>
                                        <?php echo "<input type='text' class='form-control' id='newuser' name='newuser' placeholder='$uname'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newemail">Email </label>
                                        <?php echo "<input type='text' class='form-control' id='newemail' name='newemail' placeholder='$email'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newage">Age </label>
                                        <?php echo "<input type='text' class='form-control' id='newage' name='newage' placeholder='$age'>"; ?>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newphone">Phone Number </label>
                                        <?php echo "<input type='text' class='form-control' id='newphone' name='newphone' placeholder='$phone'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="edit_acc"><i class="fa fa-save"></i> Save changes</button>
                                    <button type="cancel" class="btn btn-primary"><i class="fa fa-save"></i> Cancel</button>
                                    <button type="submit" class="btn btn-primary" name="del_acc"><i class="fa fa-save"></i> Delete Account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include "footer.php"; 
    try{
        include "config.php";

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['edit_acc'])) {
                $Aerrors = verifyAccEdit();

                if(empty($Aerrors)) {
                    $curuser = $_SESSION['id'];
                    $nuser = $_POST['newuser'];
                    $nemail = $_POST['newemail'];
                    $nage = $_POST['newage'];
                    $nphone = $_POST['newphone'];
                    
                    if ($nuser != "") {
                        $update = $gamesdb->prepare("UPDATE Users SET Uname = ? WHERE UID = ?");
                        $update->execute([$nuser, $curuser]);
                        $_SESSION['username'] = $nuser;
                    }
                    if ($nemail != "") {
                        $update = $gamesdb->prepare("UPDATE Users SET Email = ? WHERE UID = ?");
                        $update->execute([$nemail, $curuser]);
                    } 
                    if ($nage != "") {
                        $update = $gamesdb->prepare("UPDATE Users SET Age = ? WHERE UID = ?");
                        $update->execute([$nage, $curuser]);
                    } 
                    if ($nphone != "") {
                        $update = $gamesdb->prepare("UPDATE Users SET Phone = ? WHERE UID = ?");
                        $update->execute([$nphone, $curuser]);
                    }   
                    echo "<script type='text/javascript'>alert('Successfully Updated Account'); window.location.href = window.location.href;</script>";

                } else {
                    echo "<script type='text/javascript'>alert(". json_encode($Aerrors) .");</script>";
                }
            } 
            if(isset($_POST['edit_pass'])) {
                $Perrors = verifyPass();

                if(empty($Perrors)) {
                    $curuser = $_SESSION['id'];
                    $npass = $_POST['Pass1'];

                    $update = $gamesdb->prepare("UPDATE Users SET Pass = ? WHERE UID = ?");
                    $update->execute([$npass, $curuser]);

                    echo "<script type='text/javascript'>alert('Successfully Updated Password'); window.location.href = window.location.href;</script>";

                } else {
                    echo "<script type='text/javascript'>alert(". json_encode($Perrors) .");</script>";
                }
            }
            if(isset($_POST['del_acc'])) {
                // Checking if user is sure they want to delete account before doing so.
                echo "<script type='text/javascript'>if(confirm('Are you sure you want to delete you account?')){location.href = 'deleteAcc.php'}</script>";
            }
        }
    } catch(PDOException $e) {
        echo "<script type='text/javascript'>location.href = '404.php'";
    }
    $gamesdb = null;
?>  
</body>
</html>