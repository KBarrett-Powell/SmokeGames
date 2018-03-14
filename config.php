<?php
    $gamesdb = new PDO("mysql:host=localhost;port=3306;dbname=group4_2017", "group4.2017", "WKPrte4YHjB34F");
    $gamesdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>