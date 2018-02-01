<?php 
    // get rid of all stored session variables, therefore logging user out
    session_start();
    session_destroy();
    header("Location: MainPage.php");
    exit;
?>