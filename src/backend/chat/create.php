<?php
    /*
    // Create chat
    // GET FROM JSON POST
    CREATE TABLE IF NOT EXISTS Chat (
        id INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(255) NOT NULL,
        IdUnique VARCHAR(255), NOT NULL UNIQUE,
        owner INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (owner) REFERENCES User(id)
    ) ENGINE=INNODB;

    CREATE TABLE IF NOT EXISTS Roles (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        role VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id)
    ) ENGINE=INNODB;

    json post model:
    {
        "name": "string",
        "owner_token": "string - token"
    }

    Json return for errors:
    {
        "status": "error",
        "error": "error message"
    }

    Json return for success:
    {
        "status": "success",
        "chat_id": "int"
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
    $name = $data["name"];
    $owner_token = $data["owner_token"];

    if (empty($name) || empty($owner_token)) {
        // Return error
        $json = array("status" => "error", "error" => "Empty fields");
        echo json_encode($json);
        exit();
    }

    // Get owner data
    $sql = "SELECT id, Token FROM User WHERE token = '$owner_token'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Return error
        $json = array("status" => "error", "error" => "User not found");
        echo json_encode($json);
        exit();
    }
    else {
        // Validate tokens
        $row = $result->fetch_assoc();
        $user_token = $row["Token"];
        if ($user_token != $owner_token) {
            // Return error
            $json = array("status" => "error", "error" => "Invalid token");
            echo json_encode($json);
            exit();
        }
        else {
            // Get owner id
            $owner = $row["id"];

            // Create IdUnique
            /*
            The id unique is basicaly a hash md5 based on userID + owner_token + random String
            */
            $id_unique = md5($owner . $owner_token . uniqid());

            // Insert chat
            $sql = "INSERT INTO Chat (Name, IdUnique, owner) VALUES ('$name', '$id_unique', '$owner')";
            $result = $conn->query($sql);

            // Insert the default role to chat [name: everyone]
            $sql = "SELECT * FROM Chat WHERE Name = '$name'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $chat_id = $row["id"];
            $sql = "INSERT INTO Roles (chatId, role) VALUES ('$chat_id', 'everyone')";
            $result = $conn->query($sql);

            if ($result) {
                // Return success
                $json = array("status" => "success", "chat_id" => $conn->insert_id);
                echo json_encode($json);
                exit();
            }
            else {
                // Return error
                $json = array("status" => "error", "error" => "Error creating chat");
                echo json_encode($json);
                exit();
            }
        }
    }

    // Close connection
    $conn->close();
?>