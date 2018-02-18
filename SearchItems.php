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
<td class=links><form id="searchForm" method="POST" action="SearchItems.php">
<span><input type="text" name="searchvalue" class="mainsearch" placeholder="Search..."></span></form></td>
<td><?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
             if (isset($_SESSION['admin']) && $_SESSION['admin'] == true){
                  echo "<a href='Admin.php'>Admin</a>";
             } else {
                echo "<a href='Profile.php'>".$_SESSION['username']."</a>";
             }
        } else {
            echo "<a href='SignUp.php'>Login / Sign Up</a>";
        }?>
</td></tr></table><br>

<?php
    // read in searchvalue from search bar
    $search = $_POST['searchvalue'];

    echo "<h2>Search Results For: ".$search."</h2><br>";

    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    // find rows in Games table that have the searchvalue present in their name or description
    $retrieve = "SELECT * FROM Games WHERE CONCAT_WS(' ', Gname, Description) LIKE '%".$search."%';";

    $result = mysqli_query($gamesdb, $retrieve);
    if (mysqli_num_rows($result) > 0) {
       echo "<div class='games'><div class='grid'>";
       while ($row = mysqli_fetch_assoc($result)) {
           $id = $row["GameID"];
           $name = $row["Gname"];
           $img = $row["Gimg2"];

           // table to output all information stored on any returned game
           echo "<a href='IndGame.php?id=$id'><div class='game'><img src='images/$img' alt='Could not find' class='gameimage'>";
           echo "<h2>$name</h2></a>";
       }
       echo "</div></div>";
    } else { echo "No results"; }

    mysqli_close($gamesdb);
?>
</body></html>