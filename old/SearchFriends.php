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
    echo "<form id='searchFriends' method='POST' action='SearchFriends.php'><span><input type='text' 
    name='searchvalue' class='mainsearch' placeholder='Search for friends'>";
    echo "<h2>Search Results For: ".$search."</h2><br>";

    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // find rows in Games table that have the searchvalue present in their name or description
        $currentU = $_SESSION['username'];
        $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE Uname LIKE '%?%'");
        $retrieve->execute([$search]);

        if ($retrieve->rowCount() > 0) {
            echo "<div class='games'><div class='grid'>";
            foreach ($retrieve as $row) {
                $id = $row["UserID"];
                $name = $row["Uname"];
                $img = $row["ProPic"];

                // table to output all information stored on any returned game
                echo "<div class='game'><a href='Profile.php?id=$id'><img src='images/$img' alt='Could not find' class='gameimage'>";
                echo "<h2>$name</h2><button type='submit' name='addfriend' value='$id'>Add Friend</button></a></div>";
            }
            echo "</div></div>";
        } else { echo "No results"; }

        if (isset($_POST['addfriend'])) {
            $friendId = $_POST['addfriend'];

            $retrieve = $gamesdb->prepare("SELECT max(FID) FROM Friends");
            $retrieve->execute();

            $row = $nextId->fetch(PDO::FETCH_ASSOC);
            $fid = $row["max(FID)"] + 1;

            $id1 = $_SESSION['id'];
            $date = date('Y-m-d');

            $addNew = $gamesdb->prepare("INSERT INTO Friends(FID, UserID1, UserID2, DateEstab) VALUES (?, ?, ?, ?)");
            $addNew->execute([$fid, $id1, $friendId, $date]);

            echo "<script>alert('Friend Added Successfully')</script>";
        }
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>
</body></html>