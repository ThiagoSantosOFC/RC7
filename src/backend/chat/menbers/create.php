<?php
    /*
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

    json post model:
    {
        "chat_idunique": "string",
        "user_token": "string",
    }

    Get the chat id finding by the name
    and the role for new menbers is always is [everyone] find by this name and chat id
    
    Json return for errors:
    {
        "status": "error",
        "error": "error message"
    }

    Json return for success:
    {
        "status": "success",
        "menber_id": "int"
    }
    */

    // Include conn.php
    require_once "../../conn.php";

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
    $chat_idunique = $data["chat_idunique"];
    $user_token = $data["user_token"];

    if (empty($chat_idunique) || empty($user_token)) {
        // Return error
        $json = array("status" => "error", "error" => "Empty fields");
        echo json_encode($json);
        exit();
    }

    // Get user data
    $sql = "SELECT id FROM User WHERE token = '$user_token'";
    $userResult = $conn->query($sql);

    if ($userResult->num_rows > 0) {
        // Get user id
        $user = $userResult->fetch_assoc()["id"];

        // Get chat id
        $sql = "SELECT id FROM Chat WHERE IdUnique = '$chat_idunique'";
        $chatResult = $conn->query($sql);

        if ($chatResult->num_rows > 0) {
            // Get chat id
            $chat = $chatResult->fetch_assoc()["id"];

            // Verify if user already is on the server
            $sql = "SELECT * FROM menbers where user = '$user' and chatId = '$chat'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Return error
                $json = array("status" => "error", "error" => "User already is on the chat");
                echo json_encode($json);
                exit();
            }

            // Get role id
            $sql = "SELECT id FROM Roles WHERE Role = 'everyone' AND chatId = '$chat'";
            $roleResult = $conn->query($sql);

            if ($roleResult->num_rows > 0) {
                // Get role id
                $role = $roleResult->fetch_assoc()["id"];

                // Insert menber
                $sql = "INSERT INTO Menbers (chatId, role, user) VALUES ('$chat', '$role', '$user')";
                $result = $conn->query($sql);

                if ($result) {
                    // Return success
                    $json = array("status" => "success", "menber_id" => $conn->insert_id);
                    echo json_encode($json);
                    exit();
                } else {
                    // Return error
                    $json = array("status" => "error", "error" => "Error on insert menber");
                    echo json_encode($json);
                    exit();
                }
            } else {
                // Return error
                $json = array("status" => "error", "error" => "Role not found");
                echo json_encode($json);
                exit();
            }
        } else {
            // Return error
            $json = array("status" => "error", "error" => "Chat not found");
            echo json_encode($json);
            exit();
        }
    } else {
        // Return error
        $json = array("status" => "error", "error" => "User not found");
        echo json_encode($json);
        exit();
    }
?>