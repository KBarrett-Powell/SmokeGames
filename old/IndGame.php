<?php
    session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="Styles.css">
</head><body>

<table class=heading><tr><td><img src='images/logo.png' width=100></td>
<h1><td class=title><a href="index.php">Smoke Games</td></h1></a>
<td class=links><form id="searchForm" method="GET" action="SearchItems.php">
<span><input type="text" name="searchvalue" class="mainsearch" placeholder="Search..."></span></form></td>
<td><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
             if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
                  echo "<a href='Admin.php'>Admin</a>";
             } else {
                echo "<a href='Profile.php?id=".$_SESSION['id']."'>".$_SESSION['username']."</a>";
             }
        } else {
            echo "<a href='SignUp.php'>Login / Sign Up</a>";
        }?>
</td></tr></table><br>

<?php
    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE GameID = ?");
        $retrieve->execute([$_GET['id']]);
        
        $row = $retrieve->fetch(PDO::FETCH_ASSOC);
        $id = $row["GameID"];
        $name = $row["Gname"];
        $desc = $row["Description"];
        $img = $row["Gimg1"];
        //$vid = $row["video"];

        // How to create basic gallery view of images
        // echo "<div id='mainImgContainer'>";
        // echo "<a id='mainImgLink' href=images/".$img.">";
        // echo "<img id='mainImg' src=images/".$img.">";
        // echo "</a>";
        // echo "</div>";

        // echo "<div id='galleryView'>";
        // echo "<img class='galleryImg' src='images/".$img."' onclick='prettyimages(this)'>";
        // echo "<img class='galleryImg' src='images/".$img2."' onclick='prettyimages(this)'>"; 
        // echo "</div>";

        //if (!empty($vid)) {
        //    echo "<video class='galleryvideo' controls><source src='video/".$vid."' type='video/mp4' onclick='prettyimages(this)'></video>";
        //}

        // echo "<div id='galleryinfo'>";

        // Layout of the page with name at center top, play buttom at right top, and the images below them
        echo "<div class='gameTitle'><h3>".$name."</h3><button class='playbutton'>Play Now</button></div><br>";
        echo "<img src='images/".$img."'><br>";
        // Then the description of the game and the top scores in a column on the left
        // The average rating and reviews in column on the right
        echo "<table style='padding:0 2% 0 2%'><col width='60%><col width='40%'><tr><td style='padding-left:2%'>$desc</td>";
        echo "<td><p style='vertical-align:top'>Average Rating:</p><img src='images/5stars.png' style='width:50%'></td></tr><br>";
        echo "<tr><td><table class=scorestab><tr><th colspan='2'>Top Scores</th></tr>";
  
        $retrieve = $gamesdb->prepare("SELECT u.Uname, s.Score FROM Users u, Scores s WHERE GameID = ? AND u.UserID = s.UserID");
        $retrieve->execute([$id]);

        if ($retrieve->rowCount() > 0) {
            foreach ($retrieve as $row) {
                $uid = $row['UserID'];
                $score = $row['Score'];

                // add id and score to new row in top scores table
                echo "<tr><td>$uid</td><td>$score</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>--No Scores Found--</td></tr>";
        }

        echo "</table></td><td><table class=scorestab><tr><th colspan='3'>Reviews</th></tr>";

        $retrieve = $gamesdb->prepare("SELECT u.Uname, r.Review, r.Rating FROM Users u, Reviews r WHERE r.GameID = ? AND u.UserID = r.UserID");
        $retrieve->execute([$id]);

        if ($retrieve->rowCount() > 0) {
            foreach ($retrieve as $row) {
                $uname = $row['Uname'];
                $rating = $row['Rating'];
                $review = $row['Review'];

                // username, rating, and review inserted into reviews table in new row
                // could put in image representing rating, instead of just a number
                echo "<tr><td>$uname</td><td>$rating</td>$review</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>--No Reviews Found--</td></tr>";
        }

        echo "</td></tr></table>";

    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>
</body></html>