<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        Smoke Games - Admin Game Upload
    </title>

    <?php 
        if (!isset($_SESSION['username']) || !isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
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
                                    <a href="#"><i class="fa fa-list"></i>Admin Rules</a>
                                </li>
                                <li>
                                    <a href="adminReports.php"><i class="fa fa-user"></i>Manage User Reports</a>
                                </li>
                                <li class="active">
                                    <a href="adminGames.php"><i class="fa fa-heart"></i>Upload New Game</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Add a New Game</h1>
                        <p class="lead">Fill in information for a new game to add to the site here.</p>

                        <hr>

                        <form onsubmit="return verifyEdit()" method='post' name='newGame'>

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
                                        <label for="img1">Rectangle Image <span class="required">*</span></label>
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
                                        <label for="age">Age <span class="required">*</span></label>
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
<?php include "footer.php"; ?>
    
</body></html>