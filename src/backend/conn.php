<?php
    // Connection for db
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quark_db";
    $port = "3306";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
