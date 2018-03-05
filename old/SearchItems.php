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
    // read in searchvalue from search bar
    $search = $_GET['searchvalue'];

    echo "<h2>Search Results For: ".$search."</h2><br>";

    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // find rows in Games table that have the searchvalue present in their name or description
        $retrieve = $gamesdb->prepare("SELECT * FROM Games WHERE CONCAT_WS(' ', Gname, Description) LIKE '%?%'");
        $retrieve->execute([$search]);

        if ($retrieve->rowCount() > 0) {
            echo "<div class='games'><div class='grid'>";
            foreach ($retrieve as $row) {
                $id = $row["GameID"];
                $name = $row["Gname"];
                $img = $row["Gimg2"];

                // table to output all information stored on any returned game
                echo "<div class='game'><a href='IndGame.php?id=$id'><img src='images/$img' alt='Could not find' class='gameimage'>";
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