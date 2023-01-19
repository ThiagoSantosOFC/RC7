<?php
    /*
        $userSql = "CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        tag VARCHAR(255) NOT NULL,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;";

    $frirendSql = "CREATE TABLE IF NOT EXISTS Friend (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        friend INT NOT NULL,
        blocked VARCHAR(255),
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (friend) REFERENCES User(id)
    ) ENGINE=INNODB;";

    $directMessageSql = "CREATE TABLE IF NOT EXISTS DirectMessage (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        friend INT NOT NULL,
        message VARCHAR(255) NOT NULL,
        date TIMESTAMP NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (friend) REFERENCES User(id)
    ) ENGINE=INNODB;";
    
    Create direct message

    Method post
    Body JSON
    {
        "token": string,
        "friend": int,
        "message": "Hello"
    }

    Return:
    {
        "status": "ok",
        "message": "Message sent"
    }

    Return:
    {
        "status": "error",
        "message": "Message not sent"
    }

    */

    // Get connection
    require_once '../../../conn.php';

    // Check if method is post
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(array("status" => "error", "message" => "Method not allowed"));
        exit();
    }

    // Get json data
    $json = file_get_contents('php://input');

    // Decode json
    $data = json_decode($json);

    // Get token
    $token = $data->token;

    // Get friend
    $friend = $data->friend;

    // Get message
    $message = $data->message;

    // Get user
    $user = $conn->query("SELECT * FROM User WHERE Token = '$token'");

    // Check if user exist
    if ($user->num_rows == 0) {
        echo json_encode(array("status" => "error", "message" => "Token invalid"));
        exit();
    }

    // Get user
    $user = $user->fetch_assoc();

    // Get id from user
    $id = $user['id'];

    // Create direct message
    $sql = "INSERT INTO DirectMessage (user, friend, message) VALUES ($id, $friend, '$message')";

    // Check if message was sent
    if ($conn->query($sql)) {
        echo json_encode(array("status" => "ok", "message" => "Message sent"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Message not sent"));
    }

    // Close connection
    $conn->close();
?>