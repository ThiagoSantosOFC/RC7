<?php
    /*
    -- Create tabe User if not EXISTS
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        tag STRING NOT NULL,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    -- Create table Friend if not EXISTS
    CREATE TABLE IF NOT EXISTS Friends (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        friend INT NOT NULL,
        blocked STRING,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (friend) REFERENCES User(id)
    ) ENGINE=INNODB;


    Create friend
    endpoint: /backend/user/friend/create.php

    post model
    {
        "token": "string",
        "friend_tag": "string", <- 0000
        "friend_nome": "string" <- nome
    }

    Error
    {
        "status": "Error!",
        "error": "string"
    }

    Success
    {
        "status": "Success!",
        "friend": "string"
    }
    */

    // Include conn.php
    require_once "../../conn.php";

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
    $friend_tag = $data["friend_tag"];
    $friend_nome = $data["friend_nome"];

    // Verify if token is empty
    if (empty($token)) {
        // Return error
        $json = array("status" => "error", "error" => "Token is empty");
        echo json_encode($json);
        exit();
    }

    // Verify if friend_tag is empty
    if (empty($friend_tag)) {
        // Return error
        $json = array("status" => "error", "error" => "Friend tag is empty");
        echo json_encode($json);
        exit();
    }

    // Verify if friend_nome is empty
    if (empty($friend_nome)) {
        // Return error
        $json = array("status" => "error", "error" => "Friend nome is empty");
        echo json_encode($json);
        exit();
    }

    // Verify if token is valid
    $sql = "SELECT * FROM User WHERE Token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Return error
        $json = array("status" => "error", "error" => "Token is invalid");
        echo json_encode($json);
        exit();
    }

    // Verify if friend_tag is valid
    $sql = "SELECT * FROM User WHERE tag = '$friend_tag'";
    $result = $conn->query($sql);


    if ($result->num_rows == 0) {
        // Return error
        $json = array("status" => "error", "error" => "Friend tag is invalid");
        echo json_encode($json);
        exit();
    }

    // Verify if friend_nome is valid
    $sql = "SELECT * FROM User WHERE Nome = '$friend_nome'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Return error
        $json = array("status" => "error", "error" => "Friend nome is invalid");
        echo json_encode($json);
        exit();
    }

    // Verify if friend already exists
    $sql = "SELECT * FROM Friend WHERE user = (SELECT id FROM User WHERE Token = '$token') AND friend = (SELECT id FROM User WHERE tag = '$friend_tag')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Return error
        $json = array("status" => "error", "error" => "You already is friend.");
        echo json_encode($json);
        exit();
    }

    // Get user id
    $sql = "SELECT id FROM User WHERE Token = '$token'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $user = $row["id"];

    // Get friend id
    $sql = "SELECT id FROM User WHERE tag = '$friend_tag'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $friend = $row["id"];

    // Create friend
    $sql = "INSERT INTO Friend (user, friend, blocked) VALUES ('$user', '$friend', 'false')";
    $result = $conn->query($sql);

    // Verify if friend was created
    if ($result) {
        // Return success
        $json = array("status" => "success", "friend" => $friend_nome);
        echo json_encode($json);
        exit();
    } else {
        // Return error
        $json = array("status" => "error", "error" => "Friend not created");
        echo json_encode($json);
        exit();
    }

    // Close connection
    $conn->close();
?>