<?php
    /*
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
    
    -- Create tabe User if not EXISTS
    CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    -- Create tabe Roles if not EXISTS
    CREATE TABLE IF NOT EXISTS Roles (
        id INT NOT NULL AUTO_INCREMENT,
        chatId INT NOT NULL,
        role VARCHAR(255) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (chatId) REFERENCES Chat(id)
    ) ENGINE=INNODB;

    // Set role to user
    For set role need to validate the user login only the owner can set the role
    validate if the owner id is the same of the server do this using the given token
    if yes user is validated
    if not reject

    After validation get the id of role using the name of role [role VARCHAR(255) NOT NULL]
    if not exists return error
    if exists update the role of user

    Post model
    {
        "token": "string", <- owner token
        "chat_idunique": "string", <- chat id
        "user_id": "string", <- user for change the role
        "role": "string" <- role name
    }

    Return json model
    {
        "status": "string",
        "message": "string"
    }
    */

    // Get connetion
    include_once '../../conn.php';
?>