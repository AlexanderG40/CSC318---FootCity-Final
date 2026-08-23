<?php 
    session_start();

    // We clear all the session data with an empty array
    $_SESSION = array();

    session_destroy();

    // We redirect the user to the login page
    header("Location: login.php");
    exit();
?>