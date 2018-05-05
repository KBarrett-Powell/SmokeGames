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
        try{
            include "config.php";

            $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE Uname = ?");
            $retrieve->execute([$_SESSION['username']]);
        
            if ($retrieve->rowCount() == 1) {
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $uname = $row['Uname'];
                $fname = $row['Fname'];
                $lname = $row['Lname'];

                $retrieve = $gamesdb->prepare("SELECT * FROM Profiles WHERE Uname = ?");
                $retrieve->execute([$_SESSION['username']]);
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $pname = $row['ProName'];
                $desc = $row['PDesc'];
                $img = $row['ProPic'];
                $banner = $row['Banner'];

            } else {
                echo "<script type='text/javascript'>location.href = '404.php';</script>";
            }

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $gamesdb = null;

        function verifyEdit() {
            $nfirst = $_POST['newfirst'];
            $nlast = $_POST['newlast'];
            $npname = $_POST['newpname'];
            $npic = $_POST['newpic'];
            $nban = $_POST['banpic'];
            $ndesc = $_POST['newdesc'];
            $errors = array();

            if (preg_match('/^[a-zA-Z\-]{1,30}$/', $nfirst) == 0) {
                array_push($errors, ' First name should only be 1 to 30 letters');
            }
            if (preg_match('/^[a-zA-Z\-]{1,40}$/', $nlast) == 0) {
                array_push($errors, ' Last name should only be 1 to 40 letters');
            }
            if ($npname != strip_tags($npname)) {
                array_push($errors, ' Please don\'t use tags in your profile name');
            }
            if ($ndesc != strip_tags($ndesc)) {
                array_push($errors, ' Please don\'t use tags in your description');
            }
            // picture checks here!!

            if(empty($errors)) {
                return true;
            } else {
                $js_errors = json_encode($errors);
                echo "<script type='text/javascript'>alert(". $js_errors .";</script>";
                return false;
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
                        <li><a href="index.php">Home</a></li>
                        <?php echo "<li><a href='profile.php?id=".$_SESSION['username']."'>Profile</a></li>"; ?>
                        <li>Edit Profile</li>
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
                                    <?php echo "<a href='profile.php?id=$uname'><i class='fa fa-list'></i>My profile</a>"; ?>
                                </li>
                                <li class="active">
                                    <a href="#"><i class="fa fa-heart"></i> Edit Profile</a>
                                </li>
                                <li>
                                    <a href="editAccount.php"><i class="fa fa-user"></i> Edit account</a>
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
                        <h1>Edit Profile</h1>
                        <p class="lead">Update Profile Here.</p>

                        <hr>

                        <form onsubmit="return verifyEdit()" method='post' name='editPro'>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newpname">Profile Name </label>
                                        <?php echo "<input type='text' class='form-control' id='newpname' name='newpname' placeholder='$pname'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newfirst">First Name</label>
                                        <?php echo "<input type='text' class='form-control' id='newfirst' name='newfirst' placeholder='$fname'>"; ?>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newlast">Last Name</label>
                                        <?php echo "<input type='text' class='form-control' id='newlast' name='newlast' placeholder='$lname'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="newpic">Profile Image</label>
                                        <?php echo "<img src='$img' style='width:30%; vertical-align:top;'>"; ?>
                                        <input type="file" class="form-control" id="newpic" name="newpic">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="banpic">Banner Image</label>
                                        <?php echo "<img src='$banner' style='width:30%; vertical-align:top;'>"; ?>
                                        <input type="file" class="form-control" id="banpic" name="banpic">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newdesc">Description</label>
                                        <?php echo "<input type='text' class='form-control' id='newdesc' name='newdesc' placeholder='$desc'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="edit_pro"><i class="fa fa-save"></i> Save changes</button>
                                    <button type="cancel" class="btn btn-primary"><i class="fa fa-save"></i> Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
    include "footer.php"; 

    try{
        include "config.php";

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['edit_pro'])) {
                $curuser = $_SESSION['username'];
                $nfirst = $_POST['newfirst'];
                $nlast = $_POST['newlast'];
                $npname = $_POST['newpname'];
                $npic = $_POST['newpic'];
                $nban = $_POST['banpic'];
                $ndesc = $_POST['newdesc'];

                $error = false;
                
                if ($nfirst != "") {
                    $update = $gamesdb->prepare("UPDATE Users SET FName = ? WHERE Uname = ?");
                    $update->execute([$nfirst, $curuser]);
                }
                if ($nlast != "") {
                    $update = $gamesdb->prepare("UPDATE Users SET LName = ? WHERE Uname = ?");
                    $update->execute([$nlast, $curuser]);
                } 
                if ($npname != "") {
                    $update = $gamesdb->prepare("UPDATE Profiles SET ProName = ? WHERE Uname = ?");
                    $update->execute([$npname, $curuser]);
                    $_SESSION['proname'] = $npname;
                } 
                if ($ndesc != "") {
                    $update = $gamesdb->prepare("UPDATE Profiles SET PDesc = ? WHERE Uname = ?");
                    $update->execute([$ndesc, $curuser]);
                } 
                if ($npic != "") {
                    $uploadOk = false;
                    $fileTypePlain = exif_imagetype($npic);
                    $fileType = $fileTypePlain == 1 ? "gif" : ($fileTypePlain == 2 ? "jpeg" : ( $fileTypePlain == 3 ? "png" : "" ));
                    $nfilename = uniqid() . $fileType;

                    $check = getimagesize($npic["tmp_name"]);
                    if($check !== false) {
                        $uploadOk = true;
                    } 

                    if($fileType == "") {
                        $uploadOk = false;
                    }

                    if($uploadOk) {
                        $target_file = "images/UserProfiles". $nfilename;

                        if (move_uploaded_file($npic["tmp_name"], $target_file)) {
                            $update = $gamesdb->prepare("UPDATE Profiles SET ProPic = ? WHERE Uname = ?");
                            $update->execute([$nfilename, $curuser]);
                        } else {
                            $error = true;
                            echo "<script type='text/javascript'>alert('Error uploading new profile pic.')</script>";
                        }
                    } else {
                        $error = true;
                        echo "<script type='text/javascript'>alert('Please only upload a JPG, JPEG, PNG, or a GIF file.')</script>";
                    }
                } 
                if ($nban != "") {
                    $uploadOk = false;
                    $fileTypePlain = exif_imagetype($nban);
                    $fileType = $fileTypePlain == 1 ? "gif" : ($fileTypePlain == 2 ? "jpeg" : ( $fileTypePlain == 3 ? "png" : "" ));
                    $nfilename = uniqid() . $fileType;

                    $check = getimagesize($nban["tmp_name"]);
                    if($check !== false) {
                        $uploadOk = true;
                    } 

                    if($fileType == "") {
                        $uploadOk = false;
                    }

                    if($uploadOk) {
                        $target_file = "images/UserBanners". $nfilename;

                        if (move_uploaded_file($npic["tmp_name"], $target_file)) {
                            $update = $gamesdb->prepare("UPDATE Profiles SET Banner = ? WHERE Uname = ?");
                            $update->execute([$nfilename, $curuser]);
                        } else {
                            $error = true;
                            echo "<script type='text/javascript'>alert('Error uploading new banner.')</script>";
                        }
                    } else {
                        $error = true;
                        echo "<script type='text/javascript'>alert('Please only upload a JPG, JPEG, PNG, or a GIF file.')</script>";
                    }
                } 
                if (!$error) {
                    echo "<script type='text/javascript'>alert('Successfully Updated Profile'); window.location.href = window.location.href;</script>";
                }
            }
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>
</body>
</html>