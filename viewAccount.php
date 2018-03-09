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
        try{
            $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
            $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE Uname = ?");
            $retrieve->execute([$_SESSION['username']]);
        
            if ($retrieve->rowCount() == 1) {
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $uname = $row['Uname'];
                $fname = $row['Fname'];
                $lname = $row['Lname'];
                $email = $row['Email'];
                $age = $row['Age'];
                $phone = $row['Phone'];
                if ($email != null) {
                    $email = substr($email, 0, 3).str_repeat("*", strlen($email) - 3);
                }

                $retrieve = $gamesdb->prepare("SELECT * FROM Profiles WHERE Uname = ?");
                $retrieve->execute([$_SESSION['username']]);
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $pname = $row['ProName'];
                $desc = $row['PDesc'];
                $img = $row['ProPic'];

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
                            <h3 class="panel-title">Account</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li class="active">
                                    <?php echo "<a href='profile.php?id=$uname'><i class='fa fa-list'></i>My profile</a>"; ?>
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
                        <p class="lead">View your personal details here.</p>
                        
                        <hr>

                        <!-- FORM FOR EDIT DETAILS. -->
                        
                        <h3>Personal details</h3>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo "First Name : $fname"; ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo "UserName : $uname"; ?>
                                </div>
                            </div>
                        </div>
                            <!-- /.row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo "Last Name : $lname"; ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo "Email : $email"; ?>
                                </div>
                            </div>
                        </div>
                            <!-- /.row -->
                        <div class="row">
                            <div class="col-sm-6 col-md-2">
                                <div class="form-group">
                                    <?php echo "Age : $age"; ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <?php echo "Phone : $phone"; ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <?php echo "Profile Pic : <img src='$img' style='width:40%;' alt='User Profile Image Not Found'>"; ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="form-group">
                                    <label for="state">Banner Image</label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?php echo "Description : $desc"; ?>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center">
                                <a href="editProfile.php"><i class="fa fa-save"></i> Edit Profile</a>
                            </div>
                        </div>
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