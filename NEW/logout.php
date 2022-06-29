<?php
    include 'all.php';
    echo '<script>alert("Confirm logout");</script>';
    session_unset();
    session_destroy();
    header("Location: login.php");
    
?>
