<?php
    // Get user
    // Recive json data method post
    /*
    Table of users
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;
    
    get url params:
    ?token=token
    ?email=email
    ?id=id
    ?user_tag=0000&nome=pedro <- The tag need to be passed with the name of the user
    ?nome=pedro&user_tag=9033

    Get user
    endpoint: /backend/user/get.php

    Json return for errors:
    {
        "status": "error",
        "error": "error message"
    }

    Json return for success:
    {
        "status": "success",
        "user": {
            "id": id,
            "email": email,
            "nome": nome,
            "token": token
        }
    }
    
    */

    // Include conn.php
    require_once "../conn.php";

    // Verify if method is get
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        // Return error
        $json = array("status" => "error", "error" => "Method not allowed");
        echo json_encode($json);
        exit();
    }

    // Get data and prevent empty
    $token = $_GET["token"] ?? '';
    $email = $_GET["email"] ?? '';
    $id = $_GET["id"] ?? '';
    $user_tag = $_GET["user_tag"] ?? '';
    $nome = $_GET["nome"] ?? '';

    // Create sql query
    $sql = "SELECT * FROM User ";

    // Verify if something is not empty
    if (!empty($token) || !empty($email) || !empty($id) || !empty($user_tag)) {
        $sql .= "WHERE ";
    }
    // Verify if token is not empty
    if (!empty($token)) {
        $sql .= "Token = '$token'";
    } else if (!empty($email)) {
        $sql .= "Email = '$email'";
    } else if (!empty($id)) {
        $sql .= "id = '$id'";
    } else if (!empty($user_tag)) {
        $sql .= "Tag = '$user_tag' AND Nome = '$nome'";
    }

    // Execute sql query
    $result = $conn->query($sql);

    // Verify if result is empty
    if ($result->num_rows == 0) {
        // Return error
        $json = array("status" => "error", "error" => "User not found");
        echo json_encode($json);
        exit();
    }

    /*
    If nothing has passed it means the client want all users
    validate if nothing passed if true return an array if not return an object
    */

    // Create array
    $users = array();

    // Verify if nothing passed
    if (empty($token) && empty($email) && empty($id) && empty($user_tag)) {
        // Fetch all users
        while ($row = $result->fetch_assoc()) {
            // Add user to array
            array_push($users, $row);
        }
    } else {
        // Fetch user
        $users = $result->fetch_assoc();
    }

    // Return success
    $json = array("status" => "success", "user" => $users);
    echo json_encode($json);
    exit();
?>
        