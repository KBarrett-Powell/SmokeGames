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

<div class='proTitle'><a href='AccountManager.php'><button style="position: absolute; left: 1.5%; ">Accounts</button><h3>Admin</h3><a href='Sessions.php'><button>Log Out</button></a></div><br>

<table width=100% align='center'><tr><th>Delete Manager</th></tr><tr><td style='vertical-align:top'></table>

<script type="text/javascript">
function FormValidation(theForm) {
    var errors = "";
    var digits = /^[0-9]{1,2}$/;

    if (theForm.ID.value == "") {
        errors += "Please enter the user's unique number! \n";
    }

    else if (!digits.test(theForm.ID.value)) {
        errors += "The users's unique number must consist only of one or two digits! \n";
    }

    if (!errors == "") {
        alert("LIST OF ERRORS: \n" + errors);
        return false;
    } else {
        return true;
    }
}

function ShowHelpID() {
    document.getElementById("demo1").innerHTML = "Help: Fill in the user's unique number.";
}

</script>

<form method="POST" action="DeleteManagerScript.php" class="myForm" name="myForm" onSubmit="javascript:return FormValidation(this)">

<div class="delete-ID">
    <input type="text" placeholder="ID" class="form-delete-ID" id="ID" name="ID" onfocus="ShowHelpID()">
</div>

<div class="delete-submit-1">
    <input type="submit" class="form-delete-submit" value="Delete Record">
</div>

<div class="form-delete-heplbutton">
<p id="demo1"></p>
</div>

</body></html>