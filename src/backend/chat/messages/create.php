<?php
    /*
        -- Create tabe Message if not EXISTS
        CREATE TABLE IF NOT EXISTS Message (
            id INT NOT NULL AUTO_INCREMENT,
            chatId INT NOT NULL,
            userId INT NOT NULL,
            content VARCHAR(4000),
            date TIMESTAMP NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (chatId) REFERENCES Chat(id),
            FOREIGN KEY (userId) REFERENCES User(id)
        ) ENGINE=INNODB;

        CREATE TABLE IF NOT EXISTS Chat (
            id INT NOT NULL AUTO_INCREMENT,
            Name VARCHAR(255) NOT NULL,
            IdUnique VARCHAR(255), NOT NULL UNIQUE,
            owner INT NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (owner) REFERENCES User(id)
        ) ENGINE=INNODB;

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

        CREATE TABLE IF NOT EXISTS User (
            id INT NOT NULL AUTO_INCREMENT,
            Email VARCHAR(255) NOT NULL UNIQUE,
            Password VARCHAR(255) NOT NULL,
            Nome VARCHAR(255) NOT NULL,
            Token VARCHAR(500) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=INNODB;

        -- Create tabe Notfy if not EXISTS
        CREATE TABLE IF NOT EXISTS Notfy (
            id INT NOT NULL AUTO_INCREMENT,
            user INT NOT NULL,
            author INT NOT NULL,
            chatId INT NOT NULL,
            date TIMESTAMP NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (user) REFERENCES User(id),
            FOREIGN KEY (author) REFERENCES User(id),
            FOREIGN KEY (chatId) REFERENCES Chat(id)
        ) ENGINE=INNODB;

        Create the mensage for specfict chat
        endpoint: /backend/chat/message/create.php

        json post model:
        {
            "chat_idunique": "string",
            "token": "string",
            "content": "string"
        }

        Json return for errors:
        {
            "status": "error",
            "error": "error message"
        }

        Json return for success:
        {
            "status": "success",
            "message": "message"
        }

    */

    // Include conn.php
    require_once "../../conn.php";

    // Verify if method is post
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "error" => "Method not allowed"
        ));
        // Stop script
        exit();
    }

    // Get json data
    $json = file_get_contents('php://input');

    // Decode json data
    $data = json_decode($json, true);

    // Get data
    $chatIdUnique = $data["chat_idunique"];
    $token = $data["token"];
    $content = $data["content"];

    // Verify if data is empty
    if (empty($chatIdUnique) || empty($token) || empty($content)) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "error" => "Empty fields"
        ));
        // Stop script
        exit();
    }

    // Verify if chat exists
    $sql = "SELECT * FROM Chat WHERE IdUnique = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $chatIdUnique);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Verify if chat exists
    if ($result->num_rows == 0) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "error" => "Chat not found"
        ));
        // Stop script
        exit();
    }

    // Get chat
    $chat = $result->fetch_assoc();

    // Verify if user is member
    $sql = "SELECT * FROM Menbers WHERE chatId = ? AND user = (SELECT id FROM User WHERE Token = ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $chat["id"], $token);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Verify if user is member
    if ($result->num_rows == 0) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "error" => "User not member"
        ));
        // Stop script
        exit();
    }

    // Get user
    $user = $result->fetch_assoc();

    // Insert message
    $sql = "INSERT INTO Message (chatId, userId, content, date) VALUES (?, ?, ?, NOW())";

    // Prepare statement
    $stmt = $conn->prepare($sql);

    // Bind params
    $stmt->bind_param("iis", $chat["id"], $user["user"], $content);

    // Execute statement
    $stmt->execute();

    // Verify if message was inserted
    if ($stmt->affected_rows == 0) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "error" => "Message not inserted"
        ));
        // Stop script
        exit();
    }

    // Return success
    echo json_encode(array(
        "status" => "success",
        "message" => "Message inserted",
        "content" => $content,
        "date" => date("Y-m-d H:i:s")
    ));

    // Create notify for each user in chat
    $sql = "SELECT * FROM Menbers WHERE chatId = ? AND user != ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $chat["id"], $user["user"]);
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Verify if user is member
    if ($result->num_rows > 0) {
        // Get users
        $users = $result->fetch_all(MYSQLI_ASSOC);

        // Insert notify for each user
        foreach ($users as $user) {
            // Insert notify
            $sql = "INSERT INTO Notfy (user, author, chatId, date) VALUES (?, ?, ?, NOW())";

            // Prepare statement
            $stmt = $conn->prepare($sql);

            // Bind params
            $stmt->bind_param("iii", $user["user"], $user["user"], $chat["id"]);

            // Execute statement
            $stmt->execute();
        }
    }

    // Close connection
    $conn->close();

    // Stop script
    exit();
?>