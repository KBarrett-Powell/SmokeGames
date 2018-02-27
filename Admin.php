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

<div class='proTitle'><a href='AccountManager.php'><button style="position: absolute; left: 1.5%; ">Accounts</button><a href='Admin.php'><h3>Admin</h3></a><a href='Sessions.php'><button>Log Out</button></a></div><br>

<?php
    // creating neat display for reports and upload games forms
    echo "<table width='100%'><col width='50%'><col width='50%'><tr><th>Reports</th><th>Upload Games</th></tr><tr><td style='vertical-align:top'>";
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    echo "<table class=scorestab><tr><th>ID</th><th>Report</th></tr>";
    $retrieve = "SELECT * FROM Reports WHERE Resolved = false;";
    $result = mysqli_query($gamesdb, $retrieve);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['UserID1'];
            $report = $row['Report'];

            echo "<tr><td>$id</td><td>$report</td></tr>";
        }
        echo "</table></td>";
    } else {
        echo "<tr><td colspan='2'>--No Unresolved Reports Found--</td></tr></table></td>";
    }

    echo "</td><td style='padding-top:2%'><form class=proeditform onSubmit='' name='upload'><input type='file' id='newgame' name='newgame'><br>";
    echo "Game ID: <input type='text' id='gameid' name='gameid'><br>";
    echo "Game Name: <input type='text' id='gname' name='gname'><br>";
    echo "Description: <input type='text' id='desc' name='desc'><br>";
    echo "Banner Image: <input type='file' id='img1' name='img1'><br>";
    echo "Small Image: <input type='file' id='img2' name='img2'><br>";
    echo "<input class=button type='submit' value='Upload Game'></form><br></td></tr></table>";


?>

</body></html>