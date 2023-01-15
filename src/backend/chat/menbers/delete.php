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

    // Delete the menber 
    For delete need to validate the user login
    Using the given token for this is simple just need to seach if exists a user with the same token on DB
    if yes user is validated
    if not reject

    After validation just delete user

    POST json model
    {
        "token": "string",
        "chat_idunique": "string"
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
        $message = array('status' => 'error', 'message' => 'Method not allowed');
        echo json_encode($message);
        exit();
    }

    // Get json from body
    $json = file_get_contents('php://input');

    // Decode json
    $data = json_decode($json);

    // Get token and chat_uniqueid
    $token = $data->token;
    $chat_idunique = $data->chat_idunique;

    // Create sql statement
    $sql = "SELECT * FROM User WHERE Token = '$token'";

    // Get result
    $result = $conn->query($sql);

    // Check if result is empty
    if ($result->num_rows == 0) {
        // Return error
        $message = array('status' => 'error', 'message' => 'User not found');
        echo json_encode($message);
        exit();
    }
    else {
        // Get user data
        $user = $result->fetch_assoc();

        // Get user id
        $user_id = $user['id'];

        // Create sql statement
        $sql = "SELECT * FROM Chat WHERE IdUnique = '$chat_idunique'";

        // Get result
        $result = $conn->query($sql);

        // Check if result is empty
        if ($result->num_rows == 0) {
            // Return error
            $message = array('status' => 'error', 'message' => 'Chat not found');
            echo json_encode($message);
            exit();
        }

        // Get chat data
        $chat = $result->fetch_assoc();

        // Get chat id
        $chat_id = $chat['id'];

        // Create sql statement
        $sql = "SELECT * FROM Menbers WHERE user = '$user_id' AND chatId = '$chat_id'";

        // Get result
        $result = $conn->query($sql);

        // Check if result is empty
        if ($result->num_rows == 0) {
            // Return error
            $message = array('status' => 'error', 'message' => 'User not in chat');
            echo json_encode($message);
            exit();
        }
        else {
            // Delete the user
            // Create sql statement
            $sql = "DELETE FROM Menbers WHERE chatId = '$chat_id' AND user = '$user_id'";

            // Execute sql
            if ($conn->query($sql) === TRUE) {
                // Return error
                $message = array('status' => 'success', 'message' => 'User deleted');
                echo json_encode($message);
                exit();
            }
            else {
                // Return error
                $message = array('status' => 'error', 'message' => 'Error deleting user');
                echo json_encode($message);
                exit();
            }
        }
    }

    // Close connection
    $conn->close();
?>