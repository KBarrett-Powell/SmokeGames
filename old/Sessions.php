<?php 
    // get rid of all stored session variables, therefore logging user out
    session_start();
    session_destroy();
    echo "<script type='text/javascript'>alert('Successfully logged out')</script>";
    header("Location: index.php");
    exit;
?>