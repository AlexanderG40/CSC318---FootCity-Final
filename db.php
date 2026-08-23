<?php 
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "shoe_store";

    // This is the file for the connection to the database
    // without this the database and my code wont read and update
    $conn = mysqli_connect($host, $username, $password, $database);
?>