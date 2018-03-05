<?php 
    // get rid of all stored session variables, therefore logging user out
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    session_destroy();
    echo "<script type='text/javascript'>alert('Successfully logged out')</script>";
    header("Location: index.php");
    exit;
?>