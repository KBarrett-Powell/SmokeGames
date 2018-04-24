<?php
    if (!isset($_SESSION['username'])) {
        echo "<script type='text/javascript'>alert('You need to be logged in to view this page.'); location.href = 'register.php';</script>";
    }
?>