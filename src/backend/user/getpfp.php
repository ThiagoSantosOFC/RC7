<?php
    /*
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;
        
    Get user pfp
    endpoint: /backend/user/getpfp.php

    Get Method:
    ?nome=

    Return:
    {
        "url": "id + email + nome" <- string
    }
    */
    // Get connection
    require_once '../conn.php';

    // Verify if method is get
    if ($_SERVER['REQUEST_METHOD'] != 'GET') {
        http_response_code(405);
        die();
    }

    // Verify if nome is set
    if (!isset($_GET['nome'])) {
        http_response_code(400);
        die();
    }

    // Get nome prevent null
    $nome = $_GET['nome'] ?? '';

    // Verify if nome is empty
    if (empty($nome)) {
        http_response_code(400);
        die();
    }

    // Get user
    $stmt = $conn->prepare('SELECT * FROM User WHERE Nome = ?');

    // Bind nome
    $stmt->bind_param('s', $nome);

    // Execute
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Verify if user exists
    if ($result->num_rows == 0) {
        http_response_code(404);
        die();
    }

    // Get user
    $user = $result->fetch_assoc();

    // Get url
    $data = $user['id'] . $user['Email'] . $user['Nome'];
    $url = "https://api.dicebear.com/5.x/adventurer-neutral/svg?seed=" . $data;

    // Return
    echo json_encode([
        'url' => $url
    ]);

    // Close connection
    $conn->close();
?>