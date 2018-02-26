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

<?php 
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    $id = $_GET['id'];
    // collecting info on current user
    $retrieve = "SELECT * FROM Users WHERE UserID = '$id';";
    $result = mysqli_query($gamesdb, $retrieve);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $uname = $row['Uname'];
        $desc = $row['PDesc'];
        $img = $row['ProPic'];

        if ($id == $_SESSION['id']){
            // Username as title, with links to log out and edit profile
            echo "<div class='proTitle'><a href='ProfileEdit.php'><p>Edit Profile</p></a><h3>".$_SESSION['username']."</h3>";
            // -- need alert to say successfully logged out --
            echo "<a href='Sessions.php'><button>Log Out</button></a></div><br>";
        } else {
            // Username as title, with link to add friend
            echo "<div class='proTitle'><h3>$uname</h3><button type='submit' name='addfriend' value='$id'>Add Friend</button></div>";
        }
    
        // displaying that information in a table
        echo "<table style='text-align:left'><col width=25%><col width=50%><col width=25%>";
        echo "<tr><td><img src='images/$img' alt='Could not find' class='userimage'></td>";
        echo "<td style='vertical-align:top; padding:0 3% 0 3%'><p style='font-size:24pt'>About Me:</p>$desc<br>";
        echo "<table class=scorestab><tr><th>Game</th><th>Score</th></tr>";

        // retrieving scores connected to the current user, and putting them in the table
        $retrieve = "SELECT g.Gname, s.Score FROM Scores s, Games g WHERE UserID = '$id' AND g.GameID = s.GameID;";
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

        echo "<td style='vertical-align:top'><table class=scorestab><tr><form id='searchFriends' method='GET' action='SearchFriends.php'><span><input type='text' 
        name='searchvalue' class='mainsearch' placeholder='Search for friends'></span></form></tr><tr><th colspan='2'>Friends List</th></tr>";

        // collecting any users linked to current user in the friends table and adding their username to this list
        $retrieve = "SELECT u.Uname, u.ProPic FROM Users u JOIN Friends f ON u.UserID = f.UserID1 WHERE f.UserID2 = '$id'
        UNION SELECT u.Uname, u.ProPic FROM  Users u JOIN Friends f ON u.UserID = f.UserID2 WHERE f.UserID1 = '$id';";
        $result = mysqli_query($gamesdb, $retrieve);
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $fUser = $row['Uname'];
                $fPic = $row['ProPic'];

                echo "<tr><td><img src='images/$fPic' alt='Could not find' class='userimage'></td><td>$fUser</td></tr>";
            }
            echo "</table></td></tr></table>";
        } else {
            echo "<tr><td>--No Friends Found--</td></tr></table></td></tr></table>";
        }
    } else { echo "error";}

    mysqli_close($gamesdb);
?>

</body></html>