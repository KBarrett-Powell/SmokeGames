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
                        <li><a href="index.php">Home</a></li>
                        <?php echo "<li><a href='profile.php?id=".$_SESSION['username'].">Profile</a></li>"?>
                        <li>Edit Profile</li>
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
                                <li class="active">
                                    <a href="#"><i class="fa fa-heart"></i> Edit Profile</a>
                                </li>
                                <li>
                                    <a href="editAccount.php"><i class="fa fa-user"></i> Edit account</a>
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
                        <h1>Edit Profile</h1>
                        <p class="lead">Update Profile Here.</p>

                        <hr>

                        <form onSubmit='' method='post' name='editPro'>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newpname">Profile Name </label>
                                        <?php echo "<input type='text' class='form-control' id='newpname' placeholder='$pname'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newfirst">First Name</label>
                                        <?php echo "<input type='text' class='form-control' id='newfirst' placeholder='$fname'>"; ?>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="newlast">Last Name</label>
                                        <?php echo "<input type='text' class='form-control' id='newlast' placeholder='$lname'>"; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="newpic">Profile Image</label>
                                        <?php echo "<img src='$img' style='width:30%; vertical-align:top;'>"; ?>
                                        <input type="file" class="form-control" id="newpic">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="banpic">Banner Image</label>
                                        <?php echo "<img src='$banner' style='width:30%; vertical-align:top;'>"; ?>
                                        <input type="file" class="form-control" id="banpic">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="newdesc">Description</label>
                                        <?php echo "<input type='text' class='form-control' id='newdesc' placeholder='$desc'>"; ?>
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

                $update = $gamesdb->prepare("UPDATE Users SET FName = ? WHERE Uname = ?");
                $update->execute([$nFirst, $curuser]);
            }
        }

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>
</body>
</html>