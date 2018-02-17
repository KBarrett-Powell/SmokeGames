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
  <img class=imgs src="images/BannerImages/Ghost.jpg" style="width:100%">
  <img class=imgs src="images/BannerImages/Bounce.jpg" style="width:100%">
  <img class=imgs src="images/BannerImages/DragRacer.jpg" style="width:100%">
  <div class=imgNav>
    <!-- Defining left and right nav arrows -->
    <div class=leftNav onclick="plusDivs(-1)">&#10094;</div>
    <div class=rightNav onclick="plusDivs(1)">&#10095;</div>
    <!-- Defining circle nav -->
    <span class=viewNum onclick="currentDiv(1)"></span>
    <span class=viewNum onclick="currentDiv(2)"></span>
    <span class=viewNum onclick="currentDiv(3)"></span>
  </div>
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