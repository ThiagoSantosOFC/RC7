<?php
    /*
    
    -- Create tabe Menbers if not EXISTS
    CREATE TABLE IF NOT EXISTS Menbers (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        role INT NOT NULL,
        user INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id),
        FOREIGN KEY (role) REFERENCES Roles(id),
        FOREIGN KEY (user) REFERENCES User(id)
    ) ENGINE=INNODB;
    
    -- Create tabe User if not EXISTS
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;


    Get all servers that user is
    For get all servers need get token and seach 
    the corresponding menber for user that have the token
    and get all servers that contains the menber
    and return a array with each server that contains the menber

    THIS IS A GET METHOD

    endpoint: /backend/chat/menbers/getservers.php

    Params:
    token: string

    Return json model
        [
            {
                "id": "int",
                "name": "string",
                "idunique": "string",
                "owner": "int"
            }
        ]
    */

    // Get connection
    include_once '../../conn.php';

    // Verify if method is get
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(405);
        echo json_encode(array(
            "status" => "error",
            "message" => "Method not allowed"
        ));
        die();
    }

    // Get token
    $token = $_GET['token'];

    // Verify if token is set
    if (!isset($token)) {
        http_response_code(400);
        echo json_encode(array(
            "status" => "error",
            "message" => "Token not set"
        ));
        die();
    }

    // Get user id
    $sql = "SELECT id FROM User WHERE Token = '$token'";
    $result = $conn->query($sql);

    // Verify if user exists
    if ($result->num_rows == 0) {
        http_response_code(404);
        echo json_encode(array(
            "status" => "error",
            "message" => "User not found"
        ));
        die();
    }

    // Get user id
    $row = $result->fetch_assoc();
    $userId = $row['id'];

    // Get menbers
    $sql = "SELECT chatId FROM Menbers WHERE user = '$userId'";
    $result = $conn->query($sql);

    // Verify if menbers exists
    if ($result->num_rows == 0) {
        http_response_code(404);
        echo json_encode(array(
            "status" => "error",
            "message" => "Menbers not found"
        ));
        die();
    }

    // Create array that will contain all servers
    $servers = array();

    // Get all servers
    while ($row = $result->fetch_assoc()) {
        // Get chat id
        $chatId = $row['chatId'];

        // Get chat data
        $sql = "SELECT id, name, idunique, owner FROM Chat WHERE id = '$chatId'";
        $resultChat = $conn->query($sql);

        // Verify if chat exists
        if ($resultChat->num_rows == 0) {
            http_response_code(404);
            echo json_encode(array(
                "status" => "error",
                "message" => "Chat not found"
            ));
            die();
        }

        // Get chat data
        $rowChat = $resultChat->fetch_assoc();
        $chat = array(
            "id" => $rowChat['id'],
            "name" => $rowChat['name'],
            "idunique" => $rowChat['idunique'],
            "owner" => $rowChat['owner']
        );

        // Add chat to servers array
        array_push($servers, $chat);
    }

    // Return servers
    http_response_code(200);
    echo json_encode(array(
        "status" => "success",
        "message" => "Servers found",
        "servers" => $servers
    ));
    die();
?>