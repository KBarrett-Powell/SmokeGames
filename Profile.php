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
    echo "<a href='Profile.php'>".$_SESSION['username']."</a>";
    } else {
    echo "<a href='SignUp.php'>Login / Sign Up</a>";
    }?>
</td></tr></table><br>

<?php 
    // Title at top of page with log out button implemented to the right of it
    echo "<div class='proTitle'><a href='ProfileEdit.php'><p>Edit Profile</p></a><h3>".$_SESSION['username']."</h3>";
    // ADD message saying successfully logged out
    echo "<a href='Sessions.php'><button>Log Out</button></a></div><br>";

    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    // collecting info on current user
    $retrieve = "SELECT * FROM Users WHERE UserID = ".$_SESSION['id'].";";

    $result = mysqli_query($gamesdb, $retrieve);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $desc = $row['PDesc'];
        $img = $row["ProPic"];

        // displaying that information in a table
        echo "<table style='text-align:left'><col width=25%><col width=50%><col width=25%>";
        echo "<tr><td><img src='images/$img' alt='Could not find' class='userimage'></td>";
        echo "<td style='vertical-align:top; padding:0 3% 0 3%'><p style='font-size:24pt'>About Me:</p>$desc<br>";
        echo "<table class=scorestab><tr><th>Game</th><th>Score</th></tr>";

        // retrieving scores connected to the current user, and putting them in the table
        $retrieve = "SELECT g.Gname, s.Score FROM Scores s, Games g WHERE UserID = ".$_SESSION['id']." AND g.GameID = s.GameID;";
        $result = mysqli_query($gamesdb, $retrieve);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $gname = $row['Gname'];
                $score = $row['Score'];

                echo "<tr><td>$gname</td><td>$score</td></tr>";
            }
            echo "</table></td>";
        } else {
            echo "<tr><td colspan='2'>--No Scores Found--</td></tr></table></td>";
        }

        echo "<td style='vertical-align:top'><table class=scorestab><tr><th>Friends List</th></tr>";
        // collecting any users linked to current user in the friends table and adding their username to this list
        $retrieve = "SELECT u.Uname FROM Friends f, Users u WHERE f.UserID = ".$_SESSION['id']." AND f.UserID2 = u.UserID;";
        $result = mysqli_query($gamesdb, $retrieve);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $friend = $row['Uname'];

                echo "<tr><td>$friend</td></tr>";
            }
            echo "</table></td></tr></table>";
        } else {
            echo "<tr><td>--No Friends Found--</td></tr></table></td></tr></table>";
        }
    } else { echo "error";}

    mysqli_close($gamesdb);

?>

</body></html>