<?php
    /*
    Sql:

    -- Create tabe User if not EXISTS
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    -- Create tabe UserConfig if not EXISTS
    CREATE TABLE IF NOT EXISTS UserConfig (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id)
    ) ENGINE=INNODB;

    -- Create tabe Notfy if not EXISTS
    CREATE TABLE IF NOT EXISTS Notfy (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        author INT NOT NULL,
        chatId INT NOT NULL,
        date TIMESTAMP NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (author) REFERENCES User(id),
        FOREIGN KEY (chatId) REFERENCES Chat(id)
    ) ENGINE=INNODB;

    -- Create tabe Chat if not EXISTS
    CREATE TABLE IF NOT EXISTS Chat (
        id INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(255) NOT NULL UNIQUE,
        owner INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (owner) REFERENCES User(id)
    ) ENGINE=INNODB;

    -- Create tabe Menbers if not EXISTS
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

    -- Create tabe Roles if not EXISTS
    CREATE TABLE IF NOT EXISTS Roles (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        role VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id)
    ) ENGINE=INNODB;

    -- Create tabe ChatConfig if not EXISTS
    CREATE TABLE IF NOT EXISTS ChatConfig (
        id INT NOT NULL AUTO_INCREMENT,
        chat INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chat) REFERENCES Chat(id)
    ) ENGINE=INNODB;

    -- Create tabe Message if not EXISTS
    CREATE TABLE IF NOT EXISTS Message (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        userId INT NOT NULL,
        content VARCHAR(4000),
        date TIMESTAMP NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id),
        FOREIGN KEY (userId) REFERENCES User(id)
    ) ENGINE=INNODB;

    */

    // Import conn
    require_once "conn.php";

    // Sql strings

    $userSql = "CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;";

    $chatSql = "CREATE TABLE IF NOT EXISTS Chat (
        id INT NOT NULL AUTO_INCREMENT,
        Name VARCHAR(255) NOT NULL UNIQUE,
        owner INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (owner) REFERENCES User(id)
    ) ENGINE=INNODB;";

    $rolesSql = "CREATE TABLE IF NOT EXISTS Roles (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        role VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id)
    ) ENGINE=INNODB;";

    $menbersSql = "CREATE TABLE IF NOT EXISTS Menbers (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        role INT NOT NULL,
        user INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id),
        FOREIGN KEY (role) REFERENCES Roles(id),
        FOREIGN KEY (user) REFERENCES User(id)
    ) ENGINE=INNODB;";

    $configSql = "CREATE TABLE IF NOT EXISTS UserConfig (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id)
    ) ENGINE=INNODB;";

    $notfySql = "CREATE TABLE IF NOT EXISTS Notfy (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        author INT NOT NULL,
        chatId INT NOT NULL,
        date TIMESTAMP NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (author) REFERENCES User(id),
        FOREIGN KEY (chatId) REFERENCES Chat(id)
    ) ENGINE=INNODB;";

    $chatConfigSql = "CREATE TABLE IF NOT EXISTS ChatConfig (
        id INT NOT NULL AUTO_INCREMENT,
        chat INT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chat) REFERENCES Chat(id)
    ) ENGINE=INNODB;";

    $messageSql = "CREATE TABLE IF NOT EXISTS Message (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        userId INT NOT NULL,
        content VARCHAR(4000),
        date TIMESTAMP NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id),
        FOREIGN KEY (userId) REFERENCES User(id)
    ) ENGINE=INNODB;";

    // Create tables
    if ($conn->query($userSql) === TRUE) {
        echo "<br \>Table User created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    if ($conn->query($chatSql) === TRUE) {
        echo "Table Chat created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    if ($conn->query($rolesSql) === TRUE) {
        echo "Table Roles created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    
    if ($conn->query($menbersSql) === TRUE) {
        echo "Table Menbers created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    if ($conn->query($configSql) === TRUE) {
        echo "Table UserConfig created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    if ($conn->query($notfySql) === TRUE) {
        echo "Table Notfy created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    if ($conn->query($chatConfigSql) === TRUE) {
        echo "Table ChatConfig created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    if ($conn->query($messageSql) === TRUE) {
        echo "Table Message created successfully<br \>";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    // Close conn
    $conn->close();
?>