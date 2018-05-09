<?php
    session_start(); 
    try {
        include "config.php";

        // Deleting user from user table
        $delete = $gamesdb->prepare("DELETE FROM Users WHERE UID = ?");
        $delete->execute([$_SESSION['id']]);

        echo "<script type='text/javascript'>alert('Deleted Account Successfully');location.href = 'logout.php';</script>";
        
    } catch(PDOException $e) {
        echo "<script type='text/javascript'>location.href = '404.php'";
    }
    $gamesdb = null;
?>