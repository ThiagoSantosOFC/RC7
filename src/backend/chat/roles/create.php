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

        -- Create tabe Roles if not EXISTS
        CREATE TABLE IF NOT EXISTS Roles (
            id INT NOT NULL AUTO_INCREMENT,
            chatId INT NOT NULL,
            role VARCHAR(255) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (chatId) REFERENCES Chat(id)
        ) ENGINE=INNODB;

        Method post

        Json model
        {
            "chat_idunique": string,
            "role": string,
            "token": string
        }
    */

    // Get connetion
    include_once '../../conn.php';

    // Get json
    $json = file_get_contents('php://input');

    // Decode json
    $obj = json_decode($json);

    // Get data
    $chat_idunique = $obj->chat_idunique;
    $role = $obj->role;
    $token = $obj->token;

    // Verify if data is null
    if ($chat_idunique == null || $role == null || $token == null) {
        // Return error
        $message = array('status' => 'error', 'message' => 'Data is null');
        echo json_encode($message);
        exit();
    }

    // Verify if chat exists
    $sql = "SELECT * FROM Chat WHERE IdUnique = '$chat_idunique'";

    ?>