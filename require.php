<?php
    if (!isset($_SESSION['username'])) {
        echo "<script type='text/javascript'>location.href = 'register.php';</script>";
    }
?>