<?php
    // Create user
    // Get data from request
    /*
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    Delete user
    endpoint: /backend/user/delete.php

    json post model:
    {
        "token": "token"
    }

    Json return for errors:
    {
        "status": "error",
        "error": "error message"
    }

    Json return for success:
    {
        "status": "success",
        "token": Token
    }
    */
    // Include conn.php
    require_once "../conn.php";

    // Verify if method is post
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        // Return error
        $json = array("status" => "error", "error" => "Method not allowed");
        echo json_encode($json);
        exit();
    }

    // Get json data
    $json = file_get_contents('php://input');

    // Decode json data
    $data = json_decode($json, true);

    // Get data
    $token = $data["token"];

    if (empty($token)) {
        // Return error
        $json = array("status" => "error", "error" => "Empty fields");
        echo json_encode($json);
        exit();
    }
    
    // Get token from db
    $sql = "SELECT Token FROM User WHERE Token = '$token'";

    // Execute sql
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Validate token
        $row = $result->fetch_assoc();
        if($row["Token"] == $token){
            // Delete user
            $sql = "DELETE FROM User WHERE Token = '$token'";
            // Execute sql
            $result = $conn->query($sql);
            if($result){
                // Return success
                $json = array("status" => "success", "message" => "User sucessfully deleted!");
                echo json_encode($json);
                exit();
            } else {
                // Return error
                $json = array("status" => "error", "error" => "Error deleting user");
                echo json_encode($json);
                exit();
            }
        }
        else {
            // Return error
            $json = array("status" => "error", "error" => "Invalid token!");
            echo json_encode($json);
            exit();
        }
    } else {
        // Return error
        $json = array("status" => "error", "error" => "User not found!");
        echo json_encode($json);
        exit();
    }

    // Close connection
    $conn->close();
?>

