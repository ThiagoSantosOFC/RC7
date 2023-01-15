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
    
        GET Chat messages

        This is a get method

        Url PARAMS
        chat_idunique: string <- get all messages from the chat
        token: string  <- get all messages from single user

        The messages return Is every from the oldest ones to newest ones.

        Json return for errors:
        {
            "status": "error",
            "error": "error message"
        }

        Json return for success:
        {
            "status": "success",
            "messages": [
                {
                    "id": 1,
                    "chatId": 1,
                    "userId": 1,
                    "content": "string",
                    "date": "2020-01-01 00:00:00"
                },
                {
                    "id": 2,
                    "chatId": 1,
                    "userId": 1,
                    "content": "string",
                    "date": "2020-01-01 00:00:00"
                }
            ]
        }
    */

    // Include the database connection
    include_once '../../conn.php';

    // Verify if the request is a GET
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        // Return error
        echo json_encode(array(
            'status' => 'error',
            'error' => 'Invalid request method'
        ));
        // Stop the script
        die();
    }

    // Get params and prevent empty
    $chat_idunique = isset($_GET['chat_idunique']) ? $_GET['chat_idunique'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    // Create query
    $query = "SELECT * FROM Message ";

    // Verify if the both are not empty
    if (!empty($chat_idunique) ||  !empty($token)) {
        // Add WHERE
        $query .= "WHERE ";
    }

    // Verify if the chat_idunique is not empty
    if (!empty($chat_idunique)) {
        // Add chat_idunique to query
        $query .= "chatId = (SELECT id FROM Chat WHERE IdUnique = '$chat_idunique') ";
    }

    // Verify if the token is not empty
    if (!empty($token)) {
        // Verify if the chat_idunique is not empty
        if (!empty($chat_idunique)) {
            // Add AND
            $query .= "AND ";
        }
        // Add token to query
        $query .= "userId = (SELECT id FROM User WHERE Token = '$token') ";
    }

    // Add ORDER BY
    $query .= "ORDER BY date ASC";

    // Execute query
    $result = $conn->query($query);

    // Verify if the result is empty
    if ($result->num_rows == 0) {
        // Return error
        echo json_encode(array(
            'status' => 'error',
            'error' => 'No messages found'
        ));
        // Stop the script
        die();
    }

    // Create array
    $messages = array();

    // Fetch all the results
    while ($row = $result->fetch_assoc()) {
        // Add to array
        array_push($messages, $row);
    }

    // Return success
    echo json_encode(array(
        'status' => 'success',
        'messages' => $messages
    ));

    // Close the connection
    $conn->close();
?>