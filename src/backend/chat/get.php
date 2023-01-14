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

        url params:
        uniqueid: string
        name: string 
        token: string
    */

    // Include config file
    require_once "config.php";



    // Get paramether from url and prevent null
    $uniqueid = isset($_GET["uniqueid"]) ? $_GET["uniqueid"] : "";
    $name = isset($_GET["name"]) ? $_GET["name"] : "";
    $token = isset($_GET["token"]) ? $_GET["token"] : "";

    // Create sql statement
    $sql = "SELECT * FROM Chat WHERE ";

    if (!empty($uniqueid)) {
        $sql .= "IdUnique = '$uniqueid'";
    }

    if (!empty($name)) {
        $sql .= "Name = '$name'";
    }

    if (!empty($token)) {
        $sql .= "Token = '$token'";
    }

    // Execute sql statement
    $result = mysqli_query($link, $sql);

    // Verify if result is empty
    if (mysqli_num_rows($result) == 0) {
        http_response_code(404);
        die();
    }

    // Fetch result
    $row = mysqli_fetch_assoc($result);

    // Create json
    $json = array(
        "id" => $row["id"],
        "uniqueid" => $row["IdUnique"],
        "name" => $row["Name"],
        "token" => $row["Token"]
    );

    // Return json
    echo json_encode($json);

    exit(0);
?>