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

<div class='proTitle'><h3>Account Info</h3></div><br>

<?php
try{
    $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
    $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE UserID = ?");
    $retrieve->execute([$_SESSION['id']]);

    if ($retrieve->rowCount() == 1) {
        $row = $nextId->fetch(PDO::FETCH_ASSOC);
        $uname = $row['Uname'];
        $fname = $row['Fname'];
        $lname = $row['Lname'];
        $email = $row['Email'];
        $desc = $row['PDesc'];
        $img = $row['ProPic'];

        if ($email != null) {
            $email = substr($email, 0, 3).str_repeat("*", strlen($email) - 3);
        }

        echo "<table class=forms><tr><td><form class=proeditform onSubmit='' method='post' name='editAcc'>";
        echo "Username: $uname <br>";
        echo "First Name: $fname <br>";
        echo "Last Name: $lname <br>";
        echo "Email: $email <br>";
        echo "Profile Pic: $img <br>";
        echo "Description: $desc <br>";
        echo "Password: ************* <br>";
        echo "<button name='edit' id='edit'>Edit Account</button></td></tr></form>";   

        if(isset($_POST['edit'])) {
            header("Location: ProfileEdit.php");
            exit;
        }
    }

}catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
$gamesdb = null;
?>
</body></html>