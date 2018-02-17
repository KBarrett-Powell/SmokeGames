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
<h1><td class=title><a href="MainPage.php">Smoke Games</td></h1></a>
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

<!--Filter Code. (Added by Kailesh)-->
<?php
    $gameFilterType = $_POST['filterby'];
    $retrive = "SELECT * FROM Games WHERE Category LIKE '%{$gameFilterType}%' ORDER BY Gname ASC ";
    //echo $gameFilterType;
?>

<!-- Creating space for display of images -->
<div class=imgDisplay>
    <!-- #region Jssor Slider Begin -->
    <!-- Generator: Jssor Slider Maker -->
    <!-- Source: https://www.jssor.com -->
    <script src="js/jssor.slider-27.0.4.min.js" type="text/javascript"></script>
    <!-- I want to move the java script for this into another file. - Kailesh-->
    <script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_SlideoTransitions = [
              [{b:-1,d:1,o:-0.7}],
              [{b:900,d:2000,x:-379,e:{x:7}}],
              [{b:900,d:2000,x:-379,e:{x:7}}],
              [{b:-1,d:1,o:-1,sX:2,sY:2},{b:0,d:900,x:-171,y:-341,o:1,sX:-2,sY:-2,e:{x:3,y:3,sX:3,sY:3}},{b:900,d:1600,x:-283,o:-1,e:{x:16}}]
            ];

            var jssor_1_options = {
              $AutoPlay: 1,
              $SlideDuration: 800,
              $SlideEasing: $Jease$.$OutQuint,
              $Cols: 1,
              $Align: 0,
              $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: jssor_1_SlideoTransitions
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 3000;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300italic,regular,italic,700,700italic&subset=latin-ext,greek-ext,cyrillic-ext,greek,vietnamese,latin,cyrillic" rel="stylesheet" type="text/css" />

    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="img/spin.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;">
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
        <div data-u="navigator" class="jssorb032" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora051" style="width:65px;height:65px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora051" style="width:65px;height:65px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
            </svg>
        </div>
    </div>
    <script type="text/javascript">jssor_1_slider_init();</script>
    <!-- #endregion Jssor Slider End -->
</div>

<script>
    //Displaying first image
    var slideIndex = 1;
    showImg(slideIndex);

    //Changes left and right clicks have on image displayed
    function plusDivs(n) {
        showImg(slideIndex += n);
    }

    //Displaying image at n position in list
    function currentDiv(n) {
        showImg(slideIndex = n);
    }

    //How image is displayed
    function showImg(n) {
    var i;
    var x = document.getElementsByClassName("imgs");
    var dots = document.getElementsByClassName("viewNum");
    if (n > x.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = x.length}
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" white", "");
    }
    x[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " white";
    }
</script>

<br><br>

<!-- Title bar for 'Games', includes filter and sort -->
<table class=games-sort><tr><td><h2>Games</h2></td></tr>    
<tr><td class=filterOpt>
    
<!-- filter by type of game - NOT IMPLEMENTED YET-->
<form action="index.php" method="post">
    <select name="filterby">
            <option value='all'>All</option>
            <option value='action'>Action</option>
            <option value='arcade'>Arcade</option>
            <option value='multi'>Multi-Player</option>
            <option value='puzzle'>Puzzle</option></select>
    <input type="submit" value="Filter">
</form></td>

    
<form id="filterForm" method="GET" action="<?php $_SERVER['PHP_SELF']?>">

<!-- sort by several different options - NOT FULLY INTEGRATED as we havent started storing other options in database-->
<td class=sortOpt> <form id="sortForm" method="GET" action="<?php $_SERVER['PHP_SELF']?>">

<select name='sortwhat'>
        <option value='Gname'>Name</option>
        <option value='Gname'>Popularity</option>
        <option value='Gname'>Recommended</option></select>
<select name='sorthow'>
        <option value='ASC'>Ascending</option>
        <option value='DESC'>Descending</option></select>
<input type="submit" value="Sort"></form></td></tr></table>

<?php
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    // Add filter functionality here, use WHERE
    // This SQL query defines how the items are sorted
    if (isset($_GET['sortwhat'])) {
        $retrieve = "SELECT * FROM Games ORDER BY ". $_GET['sortwhat'] . " " . $_GET['sorthow'] . ";";
    } else {
        $retrieve = "SELECT * FROM Games ORDER BY Gname ASC";
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