<?php
    /*
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

        This use get method

        Get chat
        endpoint: /backend/chat/get.php

        url params:
        uniqueid: string
        name: string 
        token: string
    */

    // Include conn file
    require_once "../conn.php";

    // Method get
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        http_response_code(405);
        die();
    }

    // Get paramether from url and prevent null
    $uniqueid = isset($_GET["uniqueid"]) ? $_GET["uniqueid"] : "";
    $name = isset($_GET["name"]) ? $_GET["name"] : "";
    $token = isset($_GET["token"]) ? $_GET["token"] : "";
    // echo $uniqueid;
    // echo $name;
    
    // Create sql statement preventing the fields that can be empty
    $sql = "SELECT * FROM Chat ";

    if(!empty($uniqueid) || !empty($name)) {
        $sql .= "WHERE ";
    }

    if (!empty($uniqueid)) {
        $sql .= "IdUnique = '$uniqueid'";
    }

    if (!empty($name)) {
        $sql .= "Name = '$name'";
    }


    // echo $sql;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $json = array(
            "status" => "success",
            "chat" => array(
                "id" => $row["id"],
                "name" => $row["Name"],
                "idunique" => $row["IdUnique"],
                "owner" => $row["owner"]
            )
        );
        echo json_encode($json);
    } else {
        $json = array("status" => "error", "error" => "Not found");
        echo json_encode($json);
    }

    $conn->close();

    exit(0);
?>