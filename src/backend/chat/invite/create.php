<?php
    /*
    -- Create tabe User if not EXISTS
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    -- Create tabe JoinLinks if not EXISTS
    CREATE TABLE IF NOT EXISTS JoinLinks (
        id INT NOT NULL AUTO_INCREMENT UNIQUE,
        chatId INT NOT NULL,
        link VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id)
    ) ENGINE=INNODB;

    -- Create tabe Chat if not EXISTS
    CREATE TABLE IF NOT EXISTS Chat (
        id INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(255) NOT NULL,
        IdUnique VARCHAR(255), NOT NULL UNIQUE,
        owner INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (owner) REFERENCES User(id)
    ) ENGINE=INNODB;

    Create the invite link for join the server
    endpoint: /backend/chat/invite/create.php

    Json post:
    {
        "chat_uinqueid": string,
        "token": string
    }

    Json response:
    {
        "status": string,
        "link": string
    }

    Error return
    {
        "status": "error",
        "error": string
    }

    */

    // Include config
    include_once '../../conn.php';

    // Verify if the request is a POST
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        http_response_code(405);
        echo json_encode(array("status" => "error", "error" => "Method not allowed"));
        exit();
    }    

    // Get data from post
    $data = json_decode(file_get_contents("php://input"));

    // Verify if the data is valid
    if (!isset($data->chat_uinqueid) || !isset($data->token)) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "error" => "Invalid data"));
        exit();
    }

    // Get the chat id
    $sql = "SELECT id FROM Chat WHERE IdUnique = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $data->chat_uinqueid);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verify if the chat exists
    if ($result->num_rows == 0) {
        http_response_code(404);
        echo json_encode(array("status" => "error", "error" => "Chat not found"));
        exit();
    }

    // Get the chat id
    $chatId = $result->fetch_assoc()['id'];

    // Verify if the user is the owner of the chat
    $sql = "SELECT id FROM Chat WHERE id = ? AND owner = (SELECT id FROM User WHERE Token = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $chatId, $data->token);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verify if the user is the owner
    if ($result->num_rows == 0) {
        http_response_code(401);
        echo json_encode(array("status" => "error", "error" => "Unauthorized"));
        exit();
    }

    // Generate a random string Based on Current time with 8 chars
    $link = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(8/strlen($x)) )),1,8);

    // Insert the link in the database
    $sql = "INSERT INTO JoinLinks (chatId, link) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $chatId, $link);
    $stmt->execute();

    // Return the link
    echo json_encode(array("status" => "ok", "link" => $link));

    // Close the connection
    $conn->close();
?>