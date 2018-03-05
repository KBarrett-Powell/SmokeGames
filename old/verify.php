<?php 
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
        // Verify data
        $email = mysql_escape_string($_GET['email']); // Set email variable
        $hash = mysql_escape_string($_GET['hash']); // Set hash variable
    }

    try{
        $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
        $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $retrieve = $gamesdb->prepare("SELECT * FROM Users WHERE Email = ? AND Hashid = ?");
        $retrieve->execute([$email, $hash]);

        if($retrieve->rowCount() == 1){
            $row = $nextId->fetch(PDO::FETCH_ASSOC);
            $id = $row['UserID'];

            $retrieve = $gamesdb->prepare("UPDATE Users SET Verified = 1 WHERE UserID = ?");
            $retrieve->execute([$id]);

            echo "<script type='text/javascript'>alert('Account Successfully Verified')</script>";
            header("Location: SignUp.php");
            exit;
        }
    
    }catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $gamesdb = null;
?>