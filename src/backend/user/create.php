<?php
    // Create user
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

    json post model:
    {
        "email": "email",
        "pasword": "pasw",
        "nome": "nome"
    }

    Json return for errors:
    {
        "status": "error",
        "error": "error message"
    }

    Json return for success:
    {
        "status": "success",
        "token": Token
    }
    */
    // Include conn.php
    require_once "../conn.php";

    // Verify if method is post
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        // Return error
        $json = array("status" => "error", "error" => "Method not allowed");
        echo json_encode($json);
        exit();
    }

    // Get json data
    $json = file_get_contents('php://input');

    // Decode json data
    $data = json_decode($json, true);

    // Get data
    $email = $data["email"];
    $password = $data["password"];
    $nome = $data["nome"];

    if (empty($email) || empty($password) || empty($nome)) {
        // Return error
        $json = array("status" => "error", "error" => "Empty fields");
        echo json_encode($json);
        exit();
    }

    // Hash password
    $password = md5($password);

    // Create token
    $token = md5($email . $password . $nome);

    // Create sql string
    $sql = "INSERT INTO User (Email, Password, Nome, Token) VALUES ('$email', '$password', '$nome', '$token')";

    // Execute sql string
    if ($conn->query($sql) === TRUE) {
        // Return token
        $json = array("status" => "success", "token" => $token);
        echo json_encode($json);
    } else {
        // Return error
        $json = array("status" => "error", "error" => $conn->error);
        echo json_encode($json);
    }

    // Close connection
    $conn->close();
?>
