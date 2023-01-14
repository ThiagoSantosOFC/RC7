<?php
    /*
    // Update chat
    // GET FROM JSON POST
    CREATE TABLE IF NOT EXISTS Chat (
        id INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(255) NOT NULL UNIQUE,
        owner INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (owner) REFERENCES User(id)
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
    $sql = "SELECT id, Token FROM User WHERE Token = '$owner_token'";
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
        else{
            // Get owner id
            $owner_id = $row["id"];

            // Update the chat data
            $sql = "UPDATE Chat SET Name = '$name' WHERE owner = '$owner_id'";
            $result = $conn->query($sql);

            if ($result) {
                // Return success
                $json = array("status" => "success");
                echo json_encode($json);
                exit();
            }
            else {
                // Return error
                $json = array("status" => "error", "error" => "Error updating chat");
                echo json_encode($json);
                exit();
            }
        }
    }

    // Close connection
    $conn->close();
?>


