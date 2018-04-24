<?php
    try {
        include "config.php";
        // Leaving user in Profiles table so can view their profile name in comments and reviews, etc

        // Deleting user from user table
        $delete = $gamesdb->prepare("DELETE FROM Users WHERE Uname = ?");
        $delete->execute([$_SESSION['username']]);

        // Delete from the friends table
        //$delete = $gamesdb->prepare("DELETE FROM Friends WHERE Uname1 = ? OR Uname2 = ?");
        //$delete->execute([$_SESSION['username'], $_SESSION['username']]);

        echo "<script type='text/javascript'>alert('Deleted Account'); location.href = 'logout.php';</script>";
        
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>