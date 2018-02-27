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

<div class='proTitle'><a href='DeleteManager.php'><button style="position: absolute; left: 1.5%; ">Delete</button><a href='Admin.php'><h3>Admin</h3></a><a href='Sessions.php'><button>Log Out</button></a></div><br>

<?php
    
    echo "<table width='100% align='center'><tr><th>Account Manager</th></tr><tr><td style='vertical-align:top'></table>";
    $gamesdb = mysqli_connect("csmysql.cs.cf.ac.uk", "group4.2017", "WKPrte4YHjB34F", "group4_2017");
    if (!$gamesdb) {
       die("Failed to connect: " . mysqli_connect_error());
    } 

    echo "<table class=scorestab><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Username</th><th>E-mail</th><th>Age</th><th>Phone</th></tr>";
    
    $retrieve = "SELECT * FROM Users";
    $result = mysqli_query($gamesdb, $retrieve);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['UserID'];
            $fname = $row['Fname'];
            $lname = $row['Lname'];
            $uname = $row['Uname'];
            $email = $row['Email'];
            $age = $row['Age'];
            $phone = $row['Phone'];
    
    echo "<tr><td>$id</td><td>$fname</td><td>$lname</td><td>$uname</td><td>$email</td><td>$age</td><td>$phone</td></tr>";
        }
        echo "</table></td>";
    } else {
        echo "<tr><td colspan='2'>--No Data Found--</td></tr></table></td>";
    }

?>

</body></html>