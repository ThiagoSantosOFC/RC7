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

    // Get url params and prevent null values
    $token = isset($_GET["token"]) ? $_GET["token"] : "";
    $email = isset($_GET["email"]) ? $_GET["email"] : "";
    $id = isset($_GET["id"]) ? $_GET["id"] : "";

    // Verify if token is empty
    if (empty($token) && empty($email) && empty($id)) {
        // Return error
        $json = array("status" => "error", "error" => "Empty fields");
        echo json_encode($json);
        exit();
    }

    $sql = "SELECT * FROM User WHERE ";

    // Create query
    if (!empty($token)) {
        $sql .= "Token = '$token'";
    } else if (!empty($email)) {
        $sql .= "Email = '$email'";
    } else if (!empty($id)) {
        $sql .= "id = '$id'";
    }

    // Execute query
    $result = $conn->query($sql);

    // Verify if user exists
    if ($result->num_rows > 0) {
        // Get user
        $user = $result->fetch_assoc();

        // Return user whitout the password
        $json = array(
            "status" => "success",
            "user" => array(
                "id" => $user["id"],
                "email" => $user["Email"],
                "nome" => $user["Nome"],
                "token" => $user["Token"]
            )
        );
    } else {
        // Return error
        $json = array("status" => "error", "error" => "User not found");
    }

    // Return json
    echo json_encode($json);

    // Close connection
    $conn->close();
?>
        