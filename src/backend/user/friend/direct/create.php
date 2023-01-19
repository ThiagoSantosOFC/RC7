<?php
    /*
        $userSql = "CREATE TABLE IF NOT EXISTS User (
        id INT NOT NULL AUTO_INCREMENT,
        tag VARCHAR(255) NOT NULL,
        Email VARCHAR(255) NOT NULL UNIQUE,
        Password VARCHAR(255) NOT NULL,
        Nome VARCHAR(255) NOT NULL,
        Token VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;";

    $frirendSql = "CREATE TABLE IF NOT EXISTS Friend (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        friend INT NOT NULL,
        blocked VARCHAR(255),
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (friend) REFERENCES User(id)
    ) ENGINE=INNODB;";

    $directMessageSql = "CREATE TABLE IF NOT EXISTS DirectMessage (
        id INT NOT NULL AUTO_INCREMENT,
        user INT NOT NULL,
        friend INT NOT NULL,
        message VARCHAR(255) NOT NULL,
        date TIMESTAMP NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user) REFERENCES User(id),
        FOREIGN KEY (friend) REFERENCES User(id)
    ) ENGINE=INNODB;";
    
    Create direct message

    */

