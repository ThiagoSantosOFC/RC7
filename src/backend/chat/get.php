<?php
    /*
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

        CREATE TABLE IF NOT EXISTS User (
            id INT NOT NULL AUTO_INCREMENT,
            Email VARCHAR(255) NOT NULL UNIQUE,
            Password VARCHAR(255) NOT NULL,
            Nome VARCHAR(255) NOT NULL,
            Token VARCHAR(500) NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=INNODB;

        This use get method

        url params:
        chatId: int
        token: string
    */
?>