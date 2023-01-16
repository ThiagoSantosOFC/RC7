<?php
    /*
    $userSql = "CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        tag STRING NOT NULL,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;";

    How works
    Get user data by email 
    Hash password
    Create token -> md5(email . password . nome)
    Compare tokens
    if match return all user data exept by password hash
    else return error


    json post model:
    {
        "email": "email",
        "pasword": "pasw"
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

    Update user
    Find and validate user by token and after the token match update user data
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

    if (empty($email) || empty($password)) {
        // Return error
        $json = array("status" => "error", "error" => "Empty fields");
        echo json_encode($json);
        exit();
    }

    // Hash password
    $password = md5($password);

    // Get user data using email
    $sql = "SELECT * FROM User WHERE Email = '$email'";

    // Execute query
    $result = $conn->query($sql);

    // Verify if user exists
    if ($result->num_rows > 0) {
        // Get user data
        $user = $result->fetch_assoc();

        // Get user password
        $userPassword = $user["Password"];

        // Compare passwords
        if ($password == $userPassword) {
            // Get user token
            $userToken = $user["Token"];

            // Create token
            $token = md5($email . $password . $user["Nome"]);

            // Compare tokens
            if ($token == $userToken) {

                // Start section
                session_start();

                // Set session
                $_SESSION["token"] = $token;
                $_SESSION["email"] = $user["Email"];
                $_SESSION["nome"] = $user["Nome"];
                $_SESSION["id"] = $user["id"];
                $_SESSION["tag"] = $user["Tag"];

                // Set cokie
                setcookie("token", $token, time() + (86400 * 30), "/");
                setcookie("email", $user["Email"], time() + (86400 * 30), "/");
                setcookie("nome", $user["Nome"], time() + (86400 * 30), "/");
                setcookie("id", $user["id"], time() + (86400 * 30), "/");
                setcookie("tag", $user["tag"], time() + (86400 * 30), "/");
                


                // Return user data
                $json = array(
                    "status" => "success",
                    "token" => $token,
                    "email" => $user["Email"],
                    "nome" => $user["Nome"],
                    "id" => $user["id"],
                    "tag" => $user["Tag"]
                );
                echo json_encode($json);
                exit();
            } else {
                // Return error
                $json = array("status" => "error", "error" => "Invalid token");
                echo json_encode($json);
                exit();
            }
        } else {
            // Return error
            $json = array("status" => "error", "error" => "Invalid password");
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