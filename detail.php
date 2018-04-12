<?php
    session_start(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  
    <title>
        Smoke Games
    </title>

    <?php include "references.php"; ?>

</head>

<body>

    <?php include "navigation.php"; 
    
        try{
            include "config.php";

            // Retrieving details of the game requested
            $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE GameID = ?");
            $retrieve->execute([$_GET['id']]);

            // If one result is returned from query, collect information on game, to display in page
            if ($retrieve->rowCount() == 1){
                $row = $retrieve->fetch(PDO::FETCH_ASSOC);
                $id = $row['GameID'];
                $name = $row['Gname'];
                $desc = $row['Description'];
                $img = $row['Gimg1'];
                $squareImg = $row['GimgSquare'];
                $age = $row['AgeRating'];
                $credits = $row['Credits'];
                $howto = $row['HowTo'];
            
            // else if id in url not linked to a game, send user to error page
            } else {
                header("Location: 404.html");
                exit;
            }

            // Sending a new review to the database
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_POST['leaveReview'])) {
                    // Collect details to send to database
                    $reviewer = $_SESSION['username'];
                    $rating = $_POST['rating'];
                    $review = $_POST['review'];
                    $date = date('Y-m-d');
                    $gameid = $_GET['id'];
                    
                    // Inserting new information into the database
                    $addNew = $gamesdb->prepare("INSERT INTO Reviews(GameID, DateOf, Uname, Rating, Review) VALUES (?, ?, ?, ?, ?)");
                    $addNew->execute([$gameid, $date, $reviewer, $rating, $review]);
    
                    echo "<script type='text/javascript'>alert('Reviewed Successfully.')</script>";
                }
            }

        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $gamesdb = null;
    ?>
    
    <div id="all">
        <div id="content">
            <div class="container">

                <!-- Links back to home page -->
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="games.php">Games</a></li>
                        <li><?php echo $name; ?></li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <div class="panel panel-default sidebar-menu">

                        <!-- Display high scores for this game --> 
                        <div class="panel-heading">
                            <h3 class="panel-title">Leaderboards</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked category-menu">
                                <li>
                                    <?php
                                        try {
                                            include "config.php";
                                            
                                            // Retrieve top 10 scores from the Scores table
                                            $retrieve = $gamesdb->prepare("SELECT Uname, Score FROM Scores WHERE GameID = ? ORDER BY Score DESC LIMIT 10");
                                            $retrieve->execute([$_GET['id']]);

                                            if ($retrieve->rowCount() > 0) {
                                                echo "<a href='#'>High Scores: <span class='badge pull-right'></span></a><ul>";
                                                foreach ($retrieve as $row) {
                                                    // For each score retrieved, display the name of the user, and their score
                                                    $uname = $row['Uname'];
                                                    $score = $row['Score'];

                                                    $findpro = $gamesdb->prepare("SELECT ProName FROM Profiles WHERE Uname = ?");
                                                    $findpro->execute([$uname]);

                                                    $prow = $findpro->fetch(PDO::FETCH_ASSOC);
                                                    $pname = $prow['ProName'];

                                                    echo "<li style='margin-left:10%; margin-bottom:3%;'>$pname: $score</li>";
                                                }
                                                echo "</ul>";

                                            } else {
                                                // If no scores are found, display message informing user of this instead of leaving blank space
                                                echo "<a href='#'>--No Scores Found--</a>";
                                            }

                                        } catch(PDOException $e) {
                                            echo "Connection failed: " . $e->getMessage();
                                        }
                                        $gamesdb = null;
                                    ?>
                                </li>

                                <li>
                                    <?php 
                                        try{
                                            include "config.php";

                                            // Calculate the average rating for this game, round to 1 decimal place
                                            $avgRating = $gamesdb->prepare("SELECT ROUND(AVG(Rating), 1) AS avgRating FROM Reviews WHERE GameID = ?");
                                            $avgRating->execute([$_GET['id']]);

                                            $avgRow = $avgRating->fetch(PDO::FETCH_ASSOC);
                                            $avg = $avgRow['avgRating'];

                                            // If an average rating exists...
                                            if ($avg != NULL) {
                                                // Display average rating
                                                echo "<a href='#'>Average rating:  <span class='badge pull-right'>$avg</span></a>";

                                            // If they're aren't any reviews for this game, tell the user that neatly
                                            } else {
                                                echo "<a href='#'>--No Rating Yet--</a>";
                                            }
                                        
                                        }catch(PDOException $e) {
                                            echo "Connection failed: " . $e->getMessage();
                                        }
                                        $gamesdb = null;
                                    ?> 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">

                    <div class="row" id="productMain">

                        <div class="col-sm-6">
                            <div id="mainImage">
                                <img src="<?php echo $img; ?>" alt="" class="img-responsive">
                            </div>
                        </div>

                        <div class="col-sm-6">

                            <div class="box">
                                <h1 class="text-center"><?php echo $name; ?></h1>

                                <?php if ($credits != "") {echo "<p style='text-align: center'>By: ".$credits."</p>";}?>

                                <p style='text-align: center'>Age: <?php echo $age; ?>+</p>

                                <p class="text-center buttons">
                                    <?php echo "<a href='play.php?GameID=".$_GET['id']."' class='btn btn-primary' style='font-size: 16pt'><i class='fa fa-shopping-cart'></i> PLAY GAME</a>";?>
                                </p>
                            </div>

                            <div class="row" id="thumbs">
                                <div class="col-xs-4">
                                    <a href="<?php echo $img; ?>" class="thumb">
                                        <img src="<?php echo $squareImg; ?>" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="<?php echo $img; ?>" class="thumb">
                                        <img src="<?php echo $squareImg; ?>" alt="" class="img-responsive">
                                    </a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="<?php echo $img; ?>" class="thumb">
                                        <img src="<?php echo $squareImg; ?>" alt="" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box" id="details">
                        <p>
                            <h3>Game details</h3>

                            <p><?php echo $desc; ?></p>

                            <?php if ($howto != "") {echo "<h4>How to play:</h4> <p>".$howto."</p>";}?>
                        </p>
                    </div>

                    <div class="box" id="reviews">
                        <?php 
                            try{
                                include "config.php";

                                // Retrieve all ratings and reviews for this game
                                $retrieve = $gamesdb->prepare("SELECT r.Rating, r.Review, r.DateOf, p.ProName FROM Reviews r JOIN Profiles p ON r.Uname = p.Uname WHERE r.GameID = ?");
                                $retrieve->execute([$_GET['id']]);

                                $count = $retrieve->rowCount();
                                if ($count > 0) {
                                    // Display number of reviews
                                    echo "<h3>".$count." Reviews</h3>";

                                    // For each review display the profile name of the user, their rating, and review, and the date the review was made
                                    foreach ($retrieve as $row) {
                                        $rating = $row['Rating'];
                                        $review = $row['Review'];
                                        $daterev = $row['DateOf'];
                                        $rname = $row['ProName'];

                                        echo "<p><h5><span style='font-size:16pt'>$rname</span>  : $rating Smokes</h5><h5>$daterev</h5>$review</p>\r\n";
                                    }
                                } else {
                                    // If they're aren't any reviews for this game, tell the user that neatly
                                    echo "<a href='#'>--No Reviews Yet--</a>";
                                }
                                        
                            }catch(PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }
                            $gamesdb = null;
                        ?>   
                        
                        <hr>

                        <!-- Form for users to leve reviews of the game -->
                        <div id="comment-form" data-animate="fadeInUp">

                            <h4>Leave a review</h4>

                            <form method="post">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="rating">Rating out of 5 <span class="required">*</span></label>
                                            <input class="form-control" type="number" id="rating" name="rating" required="required" min="1" max="5" placeholder="5">
                                            <label for="review">Review <span class="required">*</span></label>
                                            <textarea class="form-control" id="review" name="review" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button class="btn btn-primary" type="submit" name="leaveReview"><i class="fa fa-comment-o"></i> Post review</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- CODE FOR THE RECOMMENDED GAMES! -->
                    
                    <div class="row" id="productMain">
                        <div class="col-xs-3">
                            <div class="box same-height">
                                <h2>Suggested Games: </h2>
                            </div>
                        </div>
                        
                        <?php
                            try{
                                include "config.php";
                            
                                $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Recommended = 1 ORDER BY Gname ASC");
                                $retrieve->execute();

                                if($retrieve->rowCount() > 0) {
                                    foreach($retrieve as $row){
                                        $recid = $row["GameID"];
                                        $recname = $row["Gname"];
                                        $recimg = $row["Gimg1"];

                                        echo "<div class='row same-height-row'>";
                                        echo "<div class='col-xs-3'>";
                                            echo "<div class='product same-height'>";
                                                echo "<div class='flip-container'>";
                                                    echo "<div class='flipper'>";
                                                        echo "<div class='front'>";
                                                            echo "<a href='#'>";
                                                                echo "<img src='$recimg' alt='' class='img-responsive'>";
                                                            echo "</a>";
                                                        echo "</div>";
                                                        echo "<div class='back'>";
                                                            echo "<a href='#'";
                                                                echo "<img src='$recimg' alt='' class='img-responsive'>";
                                                            echo "</a>";
                                                        echo "</div>";
                                                    echo "</div>";
                                                echo "</div>";
                                                echo "<a href='#' class='invisible'>";
                                                    echo "<img src='$recimg' alt='' class='img-responsive'>";
                                                echo "</a>";
                                                echo "<div class='text'>";
                                                    echo "<h3>$recname</h3>";
                                                    echo "<p class='price'>PLAY NOW!</p>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "No results";
                                }
                                echo "</div>";

                            }catch(PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }
                            $gamesdb = null;                 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>      
<?php include "footer.php"; ?>

</body>
</html>