<?php
/*
    -- Create tabe User if not EXISTS
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        tag STRING NOT NULL,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    -- Create table Friend if not EXISTS
    CREATE TABLE IF NOT EXISTS Friends (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        friend INT NOT NULL,
        blocked STRING,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (friend) REFERENCES User(id)
    ) ENGINE=INNODB;


    Get friend
    Method GET

    url params:
    token=string

    Return:
    {
        "status": "ok",
        "friends": [
            {
                "id": int,
                "tag": string,
                "email": string,
                "nome": string,
                "token": string
            },
            {
                "id": int,
                "tag": string,
                "email": string,
                "nome": string,
                "token": string
            }
        ]
    }

    Return:
    {
        "status": "error",
        "message": "No friends"
    }
*/
    // Get connection
    include_once '../../conn.php';

    // Verify method
    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        echo json_encode(array(
            "status" => "error",
            "message" => "Method not allowed"
        ));
        return;
    }

    // Get token
    $token = $_GET['token'];

    // Verify token
    if($token == null){
        echo json_encode(array(
            "status" => "error",
            "message" => "Token not found"
        ));
        return;
    }

    // Get user id
    $sql = "SELECT id FROM User WHERE Token = '$token'";
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        echo json_encode(array(
            "status" => "error",
            "message" => "Token not found"
        ));
        return;
    }
    $user = $result->fetch_assoc();

    // Get friends
    $sql = "SELECT * FROM friend WHERE user = $user[id]";
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        echo json_encode(array(
            "status" => "error",
            "message" => "No friends"
        ));
        return;
    }

    // Get friends
    $friends = array();

    while($friend = $result->fetch_assoc()){
        $sql = "SELECT * FROM User WHERE id = $friend[friend]";
        $result2 = $conn->query($sql);
        $friend = $result2->fetch_assoc();
        array_push($friends, $friend);
    }

    // Return friends
    echo json_encode(array(
        "status" => "ok",
        "friends" => $friends
    ));

    // Close connection
    $conn->close();
?>