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
  

    Get method

    Url params
    ?chat_idunique=string
    
    Return:
    [
        {
            "id": int,
            "chatId": int,
            "link": "string"
        },
        {
            "id": int,
            "chatId": int,
            "link": "string"
        },
        ...
    ]

    Error:
    {
        "status": "Error!",
        "error": "string"
    }
    */

    // Get connetion
    include_once '../../conn.php';

    // Get data from post
    $idunique = $_GET['chat_idunique'];

    // Get chat
    $sql = "SELECT * FROM Chat WHERE IdUnique = '$idunique'";
    $result = $conn->query($sql);
    $chat = $result->fetch_assoc();
    // Verify if exists
    if($chat == null) {
        echo json_encode(array(
            "status" => "Error!",
            "error" => "Chat not found!"
        ));
        return;
    }

    // Get links
    $sql = "SELECT * FROM JoinLinks WHERE chatId = '$chat[id]'";

    // Get result
    $result = $conn->query($sql);
    $links = array();
    while($row = $result->fetch_assoc()) {
        array_push($links, $row);
    }

    // Return
    echo json_encode($links);
?>