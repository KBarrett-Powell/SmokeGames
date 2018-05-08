<?php
    $user = $_GET['id'];
    $hash = $_GET['hash'];

    try {
        include "config.php";
        $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE UID = ? AND Hashid = ?");
        $retrieve->execute([$user, $hash]);

        if ($retrieve->rowCount() == 1) {

            $verify = $gamesdb->prepare("UPDATE Users SET Verified = 1 WHERE UID = ?");
            $verify->execute([$user]);
            
            echo "<script type='text/javascript'>alert('Successfully Verified Account')</script>";
            echo "<script type='text/javascript'>location.href = 'index.php';</script>";
        }

    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>