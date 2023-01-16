<?php
// Create user
// Recive json data method post
/*
    Table of users
    $userSql = "CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        tag STRING NOT NULL,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;";


    -- Create tabe UserConfig if not EXISTS
    CREATE TABLE IF NOT EXISTS UserConfig (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id)
    ) ENGINE=INNODB;

    json post model:
    {
        "email": "email",
        "password": "pasw",
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

// Create tag string format 0000 The tag can only be numeric
$tag = rand(1000, 9999);

// Create sql string
$sql = "INSERT INTO User (tag, Email, Password, Nome, Token) VALUES ('$tag', '$email', '$password', '$nome', '$token')";

//  create userconfig
$sql2 = "INSERT INTO UserConfig (user) VALUES (LAST_INSERT_ID())";

// Execute sql string
if ($conn->query($sql) === TRUE) {
    // Create userconfig
    $conn->query($sql2);
    // Return token

    // Start section
    session_start();

    // Set session
    $_SESSION["token"] = $token;

    // Set cokie
    setcookie("token", $token, time() + (86400 * 30), "/");

    $json = array("status" => "success", "token" => $token);
    echo json_encode($json);
} else {
    // Return error
    $json = array("status" => "error", "error" => $conn->error);
    echo json_encode($json);
}

// Close connection
$conn->close();
