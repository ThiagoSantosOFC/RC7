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

    DELETE FRIEND

    json model
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

    // Verify if token is set
    if (!isset($data["token"])) {
        // Return error
        $json = array("status" => "error", "error" => "Token not set");
        echo json_encode($json);
        exit();
    }

    // Verify if friend_tag is set
    if (!isset($data["friend_tag"])) {
        // Return error
        $json = array("status" => "error", "error" => "Friend tag not set");
        echo json_encode($json);
        exit();
    }

    // Verify if friend_nome is set
    if (!isset($data["friend_nome"])) {
        // Return error
        $json = array("status" => "error", "error" => "Friend nome not set");
        echo json_encode($json);
        exit();
    }

    // Get token
    $token = $data["token"];

    // Get friend_tag
    $friend_tag = $data["friend_tag"];

    // Get friend_nome
    $friend_nome = $data["friend_nome"];

    // Verify if token is valid
    $sql = "SELECT * FROM User WHERE Token = '$token'";
    // $result = $conn->query($sql);
    $result = mysqli_query($conn, $sql);

    // Verify if token is valid
    if (mysqli_num_rows($result) == 0) {
        // Return error
        $json = array("status" => "error", "error" => "Invalid token");
        echo json_encode($json);
        exit();
    }

    // Get user id
    $row = mysqli_fetch_assoc($result);
    $id = $row["id"];

    // Verify if friend exist
    $sql = "SELECT * FROM User WHERE tag = '$friend_tag' AND Nome = '$friend_nome'";
    // $result = $conn->query($sql);
    $result = mysqli_query($conn, $sql);

    // Verify if friend exist
    if (mysqli_num_rows($result) == 0) {
        // Return error
        $json = array("status" => "error", "error" => "Friend not found");
        echo json_encode($json);
        exit();
    }

    // Get friend id
    $row = mysqli_fetch_assoc($result);
    $friend_id = $row["id"];

    // Verify if friend is already friend
    $sql = "SELECT * FROM Friend WHERE user = $id AND friend = $friend_id";
    // $result = $conn->query($sql);
    $result = mysqli_query($conn, $sql);

    // Verify if friend is already friend
    if (mysqli_num_rows($result) == 0) {
        // Return error
        $json = array("status" => "error", "error" => "You are not friends");
        echo json_encode($json);
        exit();
    }

    // Delete friend
    $sql = "DELETE FROM Friend WHERE user = $id AND friend = $friend_id";
    $conn->query($sql);

    // Return success
    $json = array("status" => "success", "friend" => $friend_nome);
    echo json_encode($json);

    // Close connection
    $conn->close();
?>