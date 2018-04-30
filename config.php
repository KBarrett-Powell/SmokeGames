<?php
    // Setting up link to database for easy use in other php files

    $gamesdb = new PDO("mysql:host=csmysql.cs.cf.ac.uk;port=3306;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
    $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$gamesdb = new PDO("mysql:host=localhost;dbname=group4_2017", "root", "SmokeIt2018");
    //$gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>