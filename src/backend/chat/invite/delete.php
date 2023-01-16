<?php
    /*
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
        "Name": "string"
    }

    DELETE LINK
    */

    // Get connetion
    include_once '../../conn.php';

    // Get data from post
    $data = json_decode(file_get_contents("php://input"));

    // Get user
    $token = $data->token;
    $sql = "SELECT * FROM User WHERE Token = '$token'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    // Validate if user exists
    if($user == null){
        echo json_encode(array("status" => "Error!", "error" => "User not found!"));
        return;
    }

    // Get link
    $link = $data->link;
    $sql = "SELECT * FROM JoinLinks WHERE link = '$link'";
    $result = $conn->query($sql);
    $joinLink = $result->fetch_assoc();

    // Validate if link exists
    if($joinLink == null){
        echo json_encode(array("status" => "Error!", "error" => "Link not found!"));
        return;
    }

    // Get chat
    $chatid = $joinLink['chatId'];
    $sql = "SELECT * FROM Chat WHERE id = '$chatid'";
    $result = $conn->query($sql);
    $chat = $result->fetch_assoc();

    // Check if user is owner of chat
    if($chat['owner'] == $user['id']){
        // Delete link
        $sql = "DELETE FROM JoinLinks WHERE link = '$link'";
        $conn->query($sql);
        echo json_encode(array("status" => "Success!"));
    } else {
        echo json_encode(array("status" => "Error!", "error" => "You are not the owner of this chat!"));
    }

    // Close conn
    $conn->close();
?> 