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

<div class='proTitle'><a href='Admin.php'><h3>Admin</h3></a><a href='Sessions.php'><button>Log Out</button></a></div><br>

<table width=100% align='center'><tr><th>Delete Manager</th></tr><tr><td style='vertical-align:top'></table>

<p class="registered_sc">You have successfully deleted your record! <p>
<form action="DeleteManager.php">
<div class="adddeletescript-add">
    <input type="submit" class="adddeletescript-add-button" value="Delete Another Record">
</div>
</form>

<?php
    
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    $ID = $_POST['ID'];

    $retrieve="DELETE FROM Users WHERE UserID='$ID'";

    mysqli_query($gamesdb, $retrieve) or die ("Error: " . mysql_error($con));

?>

</body></html>