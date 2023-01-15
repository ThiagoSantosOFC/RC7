<?php
    /*
    Get menber

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

    For this use a innerjoin that return all fields from 
    Menbers, User and Roles
    Exept by User.Password

    INNER JOIN:

    SELECT Menbers.*, User.Email, User.Nome, User.Token, Roles.role, Chat.IdUnique
    FROM Menbers
    INNER JOIN User ON Menbers.user = User.id
    INNER JOIN Roles ON Menbers.role = Roles.id
    INNER JOIN Chat ON Menbers.chatId = Chat.id
    WHERE Menbers.chatId = 2;

    MARIADB VERSION:

    SELECT Menbers.*, User.Email, User.Nome, User.Token, Roles.role, Chat.IdUnique
    INNER JOIN User ON Menbers.user = User.id
    INNER JOIN Roles ON Menbers.role = Roles.id
    INNER JOIN Chat ON Menbers.chatId = Chat.id
    WHERE Menbers.chatId = 2;
    OR
    WHERE User.Token = 'Token';

    url params:
    chatId: int
    token: string
    */

    // Include conn file
    require_once "../../conn.php";

    // Method get
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        http_response_code(405);
        die();
    }

    // Get paramether from url and prevent null
    $chatId = isset($_GET["chatId"]) ? $_GET["chatId"] : "";
    $token = isset($_GET["token"]) ? $_GET["token"] : "";
    // echo $chatId;
    // echo $token;

    // Create sql statement preventing the fields that can be empty
    $sql = "";
    $sql .= "SELECT Menbers.*, User.Email, User.Nome, User.Token, Roles.role, Chat.IdUnique as chatUniqueID ";
    $sql .= "FROM Menbers ";
    $sql .= "INNER JOIN User ON Menbers.user = User.id ";
    $sql .= "INNER JOIN Roles ON Menbers.role = Roles.id ";
    $sql .= "INNER JOIN Chat ON Menbers.chatId = Chat.id ";


    if(!empty($chatId) || !empty($token)) {
        $sql .= "WHERE ";
    }

    if (!empty($chatId)) {
        $sql .= "Menbers.chatId = $chatId";
    }

    if (!empty($token)) {
        $sql .= "User.Token = '$token'";
    }

    $result = $conn->query($sql);
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Return json whitout the password
    echo json_encode(array(
        "status" => "success",
        "message" => "Menbers found",
        "menbers" => $rows
    ));


    $conn->close();
?>