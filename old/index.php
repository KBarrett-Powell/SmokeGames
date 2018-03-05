<?php
session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="css/Styles.css">
 <link rel="stylesheet" type="text/css" href="css/slider.css">

    <!-- #region Jssor Slider Begin -->

    <script src="js/jssor.slider-27.0.3.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/mainSlider.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,regular,500,600,700&subset=latin-ext,vietnamese,latin,cyrillic" rel="stylesheet" type="text/css" />

</head><body>

<!-- Creating Main Naviagtion Bar -->
<table class=heading><tr><td><img src='images/logo.png' width=100></td>
<h1><td class=title><a href="index.php">Smoke Games</td></h1></a>
<td class=links><form id="searchForm" method="GET" action="SearchItems.php">
<span><input type="text" name="searchvalue" class="mainsearch" placeholder="Search..."></span></form></td>
<td><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
             // display a different page in nav bar depending on if user is logged in and what type of user they are
             if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
                  echo "<a href='Admin.php'>Admin</a>";
             } else {
                echo "<a href='Profile.php?id=".$_SESSION['id']."'>".$_SESSION['username']."</a>";
             }
        } else {
            echo "<a href='SignUp.php'>Login / Sign Up</a>";
        }?>
</td></tr></table><br>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo"Hello ".$_SESSION['username']."!<br><br>";
}?>

<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="img/spin.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">
            <div data-p="225.00">
                <img data-u="image" src="images/BannerImages/Ghost.jpg" />
            </div>
            <div data-p="225.00">
                <img data-u="image" src="images/BannerImages/mathopoly.jpg" />
            </div>
            <div data-p="225.00">
                <img data-u="image" src="images/BannerImages/Bounce.jpg" />
            </div>
            <div data-p="225.00">
                <img data-u="image" src="images/BannerImages/DragRacer.jpg" />
            </div>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb052" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora053" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora053" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
            </svg>
        </div>
    </div>
    <script type="text/javascript">jssor_1_slider_init();</script>
    <!-- #endregion Jssor Slider End -->
</div>

<script type="text/javascript" src="js/mainSliderBottom.js"></script>

<br><br>

<!-- Title bar for 'Games', includes filter and sort -->
<table class=games-sort><tr><td><h2>Games</h2></td></tr>    
<tr><td class=filterOpt><form id="filterForm" method="GET" action="<?php $_SERVER['PHP_SELF']?>">

<!-- filter by type of game - NOT IMPLEMENTED YET-->
<select name='filterby'>
        <option value=''>All</option>
        <option value='action'>Action</option>
        <option value='arcade'>Arcade</option>
        <option value='multi'>Multi-Player</option>
        <option value='puzzle'>Puzzle</option></select>
<input type="submit" value="Filter"></form></td>

<!-- sort by several different options - NOT FULLY INTEGRATED as we havent started storing other options in database-->
<td class=sortOpt> <form id="sortForm" method="GET" action="<?php $_SERVER['PHP_SELF']?>">

<select name='sortwhat'>
        <option value='Gname'>Name</option>
        <option value='Popularity'>Popularity</option>
        <option value='Recommended'>Recommended</option></select>
<select name='sorthow'>
        <option value='ASC'>Ascending</option>
        <option value='DESC'>Descending</option></select>
<input type="submit" value="Sort"></form></td></tr></table>

<?php
    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // This SQL query defines how the items are sorted and what they are filtered by
        if (isset($_GET['sortwhat']) && isset($_GET['filterby'])) {
            $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Category LIKE '%?%' ORDER BY ? ? ");
            $retrieve->execute([$_GET['filterby'], $_GET['sortwhat'], $_GET['sorthow']]);
        } else if (isset($_GET['sortwhat'])) {
            $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY ? ?");
            $retrieve->execute([$_GET['sortwhat'], $_GET['sorthow']]);
        } else if (isset($_GET['filterby'])) {
            $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE Category LIKE '%?%' ORDER BY Gname ASC");
            $retrieve->execute([$_GET['filterby']]);
        } else {    
            $retrieve = $gamesdb->prepare("SELECT * FROM Games ORDER BY Gname ASC");
            $retrieve->execute();
        }

        if ($retrieve->rowCount() > 0) {
            echo "<br><div class='games'><div class='grid'>";
            foreach ($retrieve as $row) {
                $id = $row["GameID"];
                $name = $row["Gname"];
                $img = $row["Gimg2"];
                // Display an image of the game above the name, user clicking on this takes them to another page with more info about the game
                echo "<a href='IndGame.php?id=$id'><div class='game'><img src='images/$img' alt='Could not find' class='gameimage'>";
                echo "<h2>$name</h2></a></div>";
            }
            echo "</div></div>";
        } else { echo "No results"; }
        
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $gamesdb = null;
?>
</body></html>