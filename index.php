<?php
session_start();
?>
<!DOCTYPE html>
<html><head>
<title>Smoke Games</title>
<link rel="stylesheet" type="text/css" href="Styles.css">
</head><body>

<!-- Creating Main Naviagtion Bar -->
<table class=heading><tr><td><img src='images/logo.png' width=100></td>
<h1><td class=title><a href="index.php">Smoke Games</td></h1></a>
<td class=links><form id="searchForm" method="POST" action="SearchItems.php">
<span><input type="text" name="searchvalue" class="mainsearch" placeholder="Search..."></span></form></td>
<td><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
             // display a different page in nav bar depending on if user is logged in and what type of user they are
             if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
                  echo "<a href='Admin.php'>Admin</a>";
             } else {
                echo "<a href='Profile.php'>".$_SESSION['username']."</a>";
             }
        } else {
            echo "<a href='SignUp.php'>Login / Sign Up</a>";
        }?>
</td></tr></table><br>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo"Hello ".$_SESSION['username']."!<br><br>";
}?>

<!-- Creating space for display of images -->
<div class=imgDisplay>
    <script src="js/jssor.slider-27.0.4.min.js" type="text/javascript"></script>

    <!-- Code for the gallery slider. -->
    <script type="text/javascript" src="js/mainSlider.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,regular,italic,700,700italic&subset=latin-ext,greek-ext,cyrillic-ext,greek,vietnamese,latin,cyrillic" rel="stylesheet" type="text/css" />

    <div id="jssor_1">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin">
            <img class="spinImg" src="img/spin.svg" />
        </div>
        <div data-u="slides" class="slidesImg">
            <div data-p="225.00">
                <img data-u="image" src="images/BannerImages/Ghost.jpg" />
            </div>
            <div data-p="225.00">
                <img data-u="image" src="images/BannerImages/Bounce.jpg" />
            </div>
            <div data-p="225.00">
                <img data-u="image" src="images/BannerImages/DragRacer.jpg" />
            </div>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb032" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i">
                <svg viewbox="0 0 16000 16000" class="svgNav">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora051" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewbox="0 0 16000 16000" class="arrowSvg">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora051" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewbox="0 0 16000 16000" class="arrowSvg">
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
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    // This SQL query defines how the items are sorted and what they are filtered by
    if (isset($_GET['sortwhat']) && isset($_GET['filterby'])) {
        $retrieve = "SELECT * FROM Games WHERE Category LIKE '%".$_GET['filterby']."%' ORDER BY ". $_GET['sortwhat'] . " " . $_GET['sorthow'] . ";";
    } else if (isset($_GET['sortwhat'])) {
        $retrieve = "SELECT * FROM Games ORDER BY ". $_GET['sortwhat'] . " " . $_GET['sorthow'] . ";";
    } else if (isset($_GET['filterby'])) {
        $retrieve = "SELECT * FROM Games WHERE Category LIKE '%".$_GET['filterby']."%' ORDER BY Gname ASC;";
    } else {    
        $retrieve = "SELECT * FROM Games ORDER BY Gname ASC;";
    }

    $result = mysqli_query($gamesdb, $retrieve);
    if (mysqli_num_rows($result) > 0) {
       echo "<br><div class='games'><div class='grid'>";
       while ($row = mysqli_fetch_assoc($result)) {
           $id = $row["GameID"];
           $name = $row["Gname"];
           $img = $row["Gimg2"];

           // Display an image of the game above the name, user clicking on this takes them to another page with more info about the game
           echo "<a href='IndGame.php?id=$id'><div class='game'><img src='images/$img' alt='Could not find' class='gameimage'>";
           echo "<h2>$name</h2></a></div>";
       }
       echo "</div></div>";
    } else { echo "No results"; }

    mysqli_close($gamesdb);
?>
</body></html>