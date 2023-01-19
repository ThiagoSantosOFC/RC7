<?php
    /*
    Recive json data method post

    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;


    Update user
    endpoint: /backend/user/update.php

    json post model:
    {
        "email": "email",
        "pasword": "pasw",
        "nome": "nome",
        "token": "token",
        "tag": tag <- int 0000
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

    Update user
    Find and validate user by token and after the token match update user data
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
    $email = $data["email"];
    $password = $data["password"];
    $nome = $data["nome"];
    $token = $data["token"];
    // Tag is optional
    $tag = "";
    if (isset($data["tag"])) {
        $tag = $data["tag"];
    }

    // Check if fields are empty

    if (empty($email) || empty($password) || empty($nome) || empty($token)) {
        // Return error
        $json = array("status" => "error", "error" => "Empty fields");
        echo json_encode($json);
        exit();
    }

    // Hash password
    $password = md5($password);

    // Create token
    $newToken = md5($email . $password . $nome);

    // Check if user exists
    $sql = "SELECT * FROM User WHERE Token = '$token'";

    // Execute query
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        // Match tokens
        $row = $result->fetch_assoc();
        if ($row["Token"] == $token) {
            // Update user
            $sql = "";

            // Check if tag is set
            if (!empty($tag)) {
                // Update user with tag
                $sql = "UPDATE User SET Email = '$email', Password = '$password', Nome = '$nome', Token = '$newToken', Tag = '$tag' WHERE Token = '$token'";
            }
            
            else {
                // Generate a new random tag
                $tag = rand(1000, 9999);

                // Update user without tag
                $sql = "UPDATE User SET Email = '$email', Password = '$password', Nome = '$nome', Token = '$newToken', Tag = '$tag' WHERE Token = '$token'";
            }

            // Execute query
            $result = $conn->query($sql);

            // Check if user was updated
            if ($conn->affected_rows > 0) {
                // Return success
                $json = array("status" => "success", "token" => $newToken);
                echo json_encode($json);
                exit();
            }
            else {
                // Return error
                $json = array("status" => "error", "error" => "User not updated");
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
    }
    else {
        // Return error
        $json = array("status" => "error", "error" => "User not found");
        echo json_encode($json);
        exit();
    }
    
    // Close connection
    $conn->close();
?>