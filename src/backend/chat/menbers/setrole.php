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

    // Set role to user
    For set role need to validate the user login only the owner can set the role
    validate if the owner id is the same of the server do this using the given token
    if yes user is validated
    if not reject

    After validation get the id of role using the name of role [role VARCHAR(255) NOT NULL]
    if not exists return error
    if exists update the role of user

    endpoint: /backend/chat/menbers/setrole.php

    Post model
    {
        "token": "string", <- owner token
        "chat_idunique": "string", <- chat id
        "user_id": "string", <- user for change the role
        "role": "string" <- role name
    }

    Return json model
    {
        "status": "string",
        "message": "string"
    }
    */

    // Get connetion
    include_once '../../conn.php';

    // Verify if method is post
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "message" => "Method not allowed"
        ));
        return;
    }

    // Get data
    $data = json_decode(file_get_contents("php://input"));

    // Verify if data is null
    if ($data == null) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "message" => "Data is null"
        ));
        return;
    }

    // Get values from data
    $token = $data->token;
    $chat_idunique = $data->chat_idunique;
    $user_id = $data->user_id;
    $role = $data->role;

    // Verify if values is null
    if ($token == null || $chat_idunique == null || $user_id == null || $role == null) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "message" => "Given values is null"
        ));
        return;
    }

    // Validate Owner
    /*
    Using chat owner id get the user token
    And compare with given token
    */
    $sql = "SELECT Token FROM User WHERE id = (SELECT owner FROM Chat WHERE IdUnique = '$chat_idunique')";
    $result = mysqli_query($conn, $sql);
    // Verify if token exists
    if ($result->num_rows == 0) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "message" => "Token not found or invalid."
        ));
        return;
    }

    // Get chat id
    $sql = "SELECT id FROM Chat WHERE IdUnique = '$chat_idunique'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows == 0) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "message" => "Chat not found"
        ));
        return;
    }
    $chat_id = mysqli_fetch_assoc($result)['id'];

    // Get role id
    $sql = "SELECT id FROM Roles WHERE chatId = '$chat_id' AND role = '$role'";
    $result = mysqli_query($conn, $sql);

    // Verify if role exists
    if ($result->num_rows == 0) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "message" => "Role not found"
        ));
        return;
    }

    // Get role id
    $role_id = mysqli_fetch_assoc($result)['id'];

    // Update role
    $sql = "UPDATE Menbers SET role = '$role_id' WHERE chatId = '$chat_id' AND user = '$user_id'";
    $result = mysqli_query($conn, $sql);

    // Verify if role was updated
    if (mysqli_affected_rows($conn) == 0) {
        // Return error
        echo json_encode(array(
            "status" => "error",
            "message" => "User role not updated"
        ));
        return;
    }

    // Return success
    echo json_encode(array(
        "status" => "success",
        "message" => "User role updated"
    ));

    // Close connetion
    mysqli_close($conn);
?>