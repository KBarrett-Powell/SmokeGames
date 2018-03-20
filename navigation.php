<div id="top">
    <div class="container">
        <div class="col-md-6 offer" data-animate="fadeInDown">
            <a href="#" id="SignUpNow">Sign up now to play exclusive games for free!</a>
        </div>
        <div class="col-md-6" data-animate="fadeInDown">
            <ul class="menu">
                <?php 
                    if (isset($_SESSION['verified']) && $_SESSION['verified'] == true && basename(__FILE__) != 'editAccount.php') {
                        $_SESSION['verified'] = false;
                    }

                    if (isset($_SESSION['username'])){
                    // display a different page in nav bar depending on if user is logged in and what type of user they are
                         if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
                              echo "<li><a href='Admin.php'>Admin</a></li>";
                         } 
                        else {                        
                            echo "<li><a href='profile.php?id=".$_SESSION['username']."'>".$_SESSION['proname']."</a></li>";
                            echo "<li><a href='logout.php'>Logout</a></li>";
                        }
                    } 
                    else {
                        echo "<li><a href='#'data-toggle='modal' data-target='#login-modal'>Login</a></li>";
                        echo "<li><a href='register.php'>Register</a></li>";
                    }
                
                ?>      
                
                <li><a href="contact.php">Contact Us</a>
                </li>
                <!-- <li><a href="#">Report</a>
                </li> -->
            </ul>
        </div>
    </div>
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Login">Login</h4>
                </div>
                <div class="modal-body">
                    <form action="" name="login" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" id="user" name="user" required="required" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="pass" name="pass" required="required"  placeholder="Password">
                        </div>
                        <p class="text-center">
                            <button class="btn btn-primary" type="submit" value="Login" name="nav_login"><i class="fa fa-sign-in"></i> Log in</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- TOP BAR END -->

<!-- NAVBAR -->

<div class="navbar navbar-default yamm" role="navigation" id="navbar">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand home" href="index.php">
                <img src="images/Logos/long-logo-white.png" alt="Smoke Games logo" class="hidden-xs" height="50px" width="300">
                <img src="images/Logos/logo-small.png" alt="Smoke Games logo" class="visible-xs"><span class="sr-only">Smoke Games homepage</span>
            </a>
            <div class="navbar-buttons">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-align-justify"></i>
                </button>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search">
                    <span class="sr-only">Toggle search</span>
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
        <!--/.navbar-header -->

        <div class="navbar-collapse collapse" id="navigation">

            <ul class="nav navbar-nav navbar-left">
                <li class="active"><a href="index.php">Home</a></li>
                <li class="dropdown yamm-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">All Games <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="yamm-content">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h5>Trending</h5>
                                        <ul>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5>Recommended</h5>
                                        <ul>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5>Spotlight</h5>
                                        <ul>
                                            <li><a href="#">Insert Game Name</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5>Categories</h5>
                                        <ul>
                                            <li><a href="#">Action</a>
                                            </li>
                                            <li><a href="#">Adventure</a>
                                            </li>
                                            <li><a href="#">Arcade</a>
                                            </li>
                                            <li><a href="#">Driving</a>
                                            </li>
                                            <li><a href="#">Multiplayer</a>
                                            </li>
                                            <li><a href="#">Sports</a>
                                            </li>
                                            <li><a href="#">Strategy</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.yamm-content -->
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
        <!--/.nav-collapse -->

        <div class="navbar-buttons">

            <!-- <div class="navbar-collapse collapse right" id="basket-overview">
                <a href="#" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm">Donate!</span></a>
            </div> -->
            <!--/.nav-collapse -->

            <div class="navbar-collapse collapse right" id="search-not-mobile">
                <button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
                    <span class="sr-only">Toggle search</span>
                    <i class="fa fa-search"></i>
                </button>
            </div>

        </div>

        <div class="collapse clearfix" id="search">

            <form class="navbar-form" role="search" id="searchForm" method="GET" action="search.php">
                <div class="input-group">
                    <input type="text" name="searchvalue" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
    try{
        include "config.php";

        // Login query
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST['nav_login'])) {
                $username = $_POST['user'];
                $password = $_POST['pass'];

                // Try to find user account with details entered
                $retrieve = $gamesdb->prepare("SELECT u.Pass, u.Verified, p.ProName FROM Users u, Profiles p WHERE u.Uname = ? AND u.Uname = p.Uname");
                $retrieve->execute([$username]);

                if ($retrieve->rowCount() == 1) {
                    $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                    $hash = $row['Pass'];
                    $verf = $row['Verified'];
                    $pname = $row['ProName'];
                    
                    // Check if account verified
                    if ($verf == 1){

                        // Compare passwords
                        //if (password_verify($password, $hash)) {
                        if ($password == $hash) {

                            // Set session variables
                            $_SESSION['username'] = $username;
                            $_SESSION['proname'] = $pname;

                            // Check if user is an admin
                            $retrieve = $gamesdb->prepare("SELECT * FROM Admins WHERE Uname = ?");
                            $retrieve->execute([$username]);
                            
                            if ($retrieve->rowCount() == 1) { 
                                $_SESSION['admin'] = true; 
                            }

                            // Take user to main page
                            echo "<script type='text/javascript'>alert('Successfully Logged In.')</script>";
                            echo "<script type='text/javascript'>location.href = 'index.php';</script>";
                            
                        } else {echo "<script type='text/javascript'>alert('Password Incorrect. ' . (5 - $attempts) . 'Please Try Again.')</script>";}

                    } else {echo "<script type='text/javascript'>alert('Please Verify Account Before Trying To Log In')</script>";}

                } else {echo "<script type='text/javascript'>alert('Username Incorrect. Please Try Again.')</script>";}
            }
        }
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>


