<?php  
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    $db_host="csmysql.cs.cf.ac.uk";
    $db_name="group4_2017";
    $myusername="group4.2017";
    $mypassword="WKPrte4YHjB34F";

    $gamesdb = mysqli_connect($db_host, $myusername, $mypassword, $db_name);
?>