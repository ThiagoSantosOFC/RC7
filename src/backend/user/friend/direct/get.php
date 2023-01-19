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

    Get direct message
    endpoint: /backend/user/friend/direct/get.php

    Method GET

    url params:
    token=string
    friend=int

    Messages are returned from older to newer

    Return:
    {
        "status": "ok",
        "messages": [
            {
                "id": int,
                "user": int,
                "friend": int,
                "message": string,
                "date": string
            },
            {
                "id": int,
                "user": int,
                "friend": int,
                "message": string,
                "date": string
            }
        ]
    }
    */

    // Get connection
    require_once '../../../conn.php';

    // Verify if method is get
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        // Return error
        $json = array("status" => "error", "error" => "Method not allowed");
        echo json_encode($json);
        exit();
    }

    // Create the query
    $query = "SELECT * FROM DirectMessage WHERE ";

    // Build query
    if (isset($_GET["token"]) && isset($_GET["friend"])) {
        $query .= "user = (SELECT id FROM User WHERE Token = ?) AND friend = ? ORDER BY date ASC";
    }
    else if(isset($_GET["token"])) {
        $query .= "user = (SELECT id FROM User WHERE Token = ?) ORDER BY date ASC";
    }
    else if(isset($_GET["friend"])) {
        $query .= "friend = ? ORDER BY date ASC";
    }
    else {
        // Return error
        $json = array("status" => "error", "error" => "Missing params");
        echo json_encode($json);
        exit();
    }

    // Prepare statement
    $stmt = $conn->prepare($query);

    // Bind params
    if (isset($_GET["token"]) && isset($_GET["friend"])) {
        $stmt->bind_param("si", $_GET["token"], $_GET["friend"]);
    }
    else if(isset($_GET["token"])) {
        $stmt->bind_param("s", $_GET["token"]);
    }
    else if(isset($_GET["friend"])) {
        $stmt->bind_param("i", $_GET["friend"]);
    }

    // Execute statement
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Get all messages
    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    // Return messages
    $json = array("status" => "ok", "messages" => $messages);
    echo json_encode($json);

    // Close connection
    $conn->close();
?>
    