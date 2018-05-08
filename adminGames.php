<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Smoke Games - Admin Game Upload
    </title>

    <?php 
        if (!isset($_SESSION['id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
            echo "<script type='text/javascript'>location.href = '404.php';</script>";
        }
        include "references.php"; 
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
                        <li>Admin</li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title"> Admin Section </h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="admin.php"><i class="fa fa-list"></i>Admin Rules</a>
                                </li>
                                <li>
                                    <a href="adminReports.php"><i class="fa fa-user"></i>Manage User Reports</a>
                                </li>
                                <li class="active">
                                    <a href="#"><i class="fa fa-play"></i>Upload New Game</a>
                                </li>
                                <!-- <li>
                                    <a href="adminUpdates.php"><i class="fa fa-heart"></i>Update Games</a>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Add a New Game</h1>
                        <p class="lead">Fill in information for a new game to add to the site here.</p>

                        <hr>

                        <form action="adminGames.php" method='post' name='newGame'>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="gfile">Game File <span class="required">*</span></label>
                                        <input type="file" class="form-control" id="gfile">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="gname">Game Name <span class="required">*</span></label>
                                        <input type='text' class='form-control' id='gname' placeholder='Enter name'>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="desc">Description <span class="required">*</span></label>
                                        <textarea class="form-control" id="desc" name="desc" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="img1">Normal Image <span class="required">*</span></label>
                                        <input type="file" class="form-control" id="img1">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="sqImg">Square Image <span class="required">*</span></label>
                                        <input type="file" class="form-control" id="sqImg">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="howto">How to play</label>
                                        <textarea class="form-control" id="howto" name="howto" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="category">Categories </label>
                                        <select multiple class="form-control" name='category'>
                                            <option value='Action'>Action</option>
                                            <option value='Arcade'>Arcade</option>
                                            <option value='Multi-Player'>Multi-Player</option>
                                            <option value='Puzzle'>Puzzle</option>
                                            <option value='Shooter'>Shooter</option>
                                            <option value='Sports'>Sports</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="age">Age Rating <span class="required">*</span></label>
                                        <input type='number' class='form-control' id='age'>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label for="credit">Credits </label>
                                        <input type='text' class='form-control' id='credit'>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn-primary" name="upload_game"><i class="fa fa-save"></i> Upload Game</button>
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
        // Code for buttons in page
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            // If respond to friend request selected :
            if(isset($_POST['upload_game'])) {
                $gfile = $_FILES['gfile'];
                $gname = $_POST['gname'];
                $desc = $_POST['desc'];
                $img = $_FILES['img1'];
                $sqimg = $_FILES['sqImg'];
                $howto = $_POST['howto'];
                $category = $_POST['category'];
                $age = $_POST['age'];
                $credit = $_POST['credit'];
                
                // Create new game id for the game being uploaded
                $retrieve = $gamesdb->prepare("SELECT max(GameID) FROM Games");
                $retrieve->execute();
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $gid = $row["max(GameID)"] + 1;

                $uploadOk = false;

                // Getting file types of images
                $imgExt = strtolower(pathinfo($img["name"], PATHINFO_EXTENSION));
                $sqExt = strtolower(pathinfo($sqimg["name"], PATHINFO_EXTENSION));
                $gameExt = strtolower(pathinfo($gfile["name"], PATHINFO_EXTENSION));

                $imgfilename = $gname . uniqid() . "." . $imgExt;
                $Sqfilename = $gname . uniqid() . "." . $sqExt;
                $gfilename = $gname . "." . $fgameExt;

                $checkImg = getimagesize($img["tmp_name"]);
                $checkSq = getimagesize($sqimg["tmp_name"]);

                if($checkImg !== false && $checkSq !== false && ($imgExt == "jpg" || $imgExt == "png" || $imgExt == "jpeg" || $imgExt == "gif") && ($sqExt == "jpg" || $sqExt == "png" || $sqExt == "jpeg" || $sqExt == "gif")) {
                    $uploadOk = true;
                } 

                if($uploadOk) {
                    $target_file_img = "images/HomeTrending/". $imgfilename;

                    if (move_uploaded_file($img["tmp_name"], $target_file_img)) {

                        $target_file_sq = "images/HomeTrending/". $Sqfilename;

                        if (move_uploaded_file($sqimg["tmp_name"], $target_file_sq)) {
                            $target_file_game = "Games/". $gname . "/" . $gfilename;

                            if (move_uploaded_file($gfile["tmp_name"], $target_file_game)) {
                                $newGame = $gamesdb->prepare("INSERT INTO Games(GameID, Gname, Description, Gimg1, GimgSquare, Category, AgeRating, Credits, HowTo, GameFile) VALUES (?,?,?,?,?,?,?,?,?,?)");
                                $newGame->execute([$gid, $gname, $desc, $target_file_img, $target_file_sq, $category, $age, $credit, $howto, $target_file_game]);

                                echo "<script type='text/javascript'>alert('Game uploaded successfuly.'); window.location.href = window.location.href;</script>";

                            } else {
                                echo "<script type='text/javascript'>alert('Error uploading game file.')</script>";
                            }
                        } else {
                            echo "<script type='text/javascript'>alert('Error uploading square image.')</script>";
                        }
                    } else {
                        echo "<script type='text/javascript'>alert('Error uploading normal image.')</script>";
                    }      
                } else {
                    echo "<script type='text/javascript'>alert('Please only upload a JPG, JPEG, PNG, or a GIF file for the images.')</script>";
                }
            }
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>
    
</body></html>