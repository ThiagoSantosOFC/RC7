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

    
    Post model
    {
        "link": "string",
        "token": "string"
    }

    Error
    {
        "status": "Error!",
        "error": "string"
    }  

    Success
    {
        "status": "Success!",
        "IdUnique": "string",
    }

    */

    // Get connetion
    include_once '../../conn.php';

    // Get data
    $data = json_decode(file_get_contents("php://input"));

    // Verify if the request is a POST
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo json_encode(array("status" => "error", "error" => "Method not allowed"));
        exit();
    }

    // Verify if the data is empty
    if (empty($data->link) || empty($data->token)) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "error" => "Bad request"));
        exit();
    }

    // Verify if the link is valid
    $link = $data->link;
    $token = $data->token;

    // Verify if the link is valid
    $sql = "SELECT * FROM JoinLinks WHERE link = '$link'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "error" => "Link not valid"));
        exit();
    }

    // Verify if the token is valid
    $sql = "SELECT * FROM User WHERE Token = '$token'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "error" => "Token not valid"));
        exit();
    }

    // Get the user
    $user = mysqli_fetch_assoc($result);

    // Get the link
    $sql = "SELECT * FROM JoinLinks WHERE link = '$link'";
    $result = mysqli_query($conn, $sql);

    // Get the link
    $link = mysqli_fetch_assoc($result);

    // Get the chat
    $chatId = $link['chatId'];
    $sql = "SELECT * FROM Chat WHERE id = '$chatId'";

    $result = mysqli_query($conn, $sql);
    $chat = mysqli_fetch_assoc($result);

    // Verify if the user is already a member
    $sql = "SELECT * FROM Menbers WHERE chatId = '$chatId' AND user = '$user[id]'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) != 0) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "error" => "You are already a member"));
        exit();
    }

    // Get the everyone role from the chat
    $sql = "SELECT * FROM Roles WHERE chatId = '$chatId' AND Role = 'everyone'";
    $result = mysqli_query($conn, $sql);
    $role = mysqli_fetch_assoc($result);

    // Add the user to the chat
    $sql = "INSERT INTO Menbers (chatId, role, user) VALUES ('$chatId', '$role[id]', '$user[id]')";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        http_response_code(500);
        echo json_encode(array("status" => "error", "error" => "Internal server error"));
        exit();
    }

    // Return the chat
    http_response_code(200);
    echo json_encode(array("status" => "success", "IdUnique" => $chat['IdUnique']));
    exit();
?>