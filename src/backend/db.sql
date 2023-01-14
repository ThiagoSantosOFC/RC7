/*


------------------ user/client

        User

id INT unique auto increment
Email unico notNull vchar 255
Pasw notNull varchar 255
Nome notNull varchar 255

        Config

id INT unique auto increment
user INT KEY TO USER ID

... Configs

        Notfy

id INT unique auto increment
user INT KEY TO USER ID
author INT KEY TO USER ID
chatId INT KEY TO CHAT ID
date TIMESTAMP NotNull 



------------------ chat

        Chat

id INT unique auto increment
Name unique varchar 255
owner INT KEY TO USER ID

        Menbers

id INT unique auto increment
chatId INT KEY TO CHAT ID
role INT KEY TO ROLE ID
user INT KEY TO USER ID

        Roles

id INT unique auto increment
chatId INT KEY TO CHAT ID
role notNull String

        Config

id INT unique auto increment
chat INT KEY TO CHAT ID

... Configs

        Message

id INT unique auto increment
chatId INT KEY TO CHAT ID
id INT KEY TO USER ID
content varchar 4000
date TIMESTAMP NotNull 


Engine: INNODB
*/



-- Create tabe User if not EXISTS
CREATE TABLE IF NOT EXISTS User (
    id INT NOT NULL AUTO_INCREMENT,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Pasw VARCHAR(255) NOT NULL,
    Nome VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=INNODB;

-- Create tabe Config if not EXISTS
CREATE TABLE IF NOT EXISTS Config (
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
    Name VARCHAR(255) NOT NULL,
    IdUnique VARCHAR(255), NOT NULL UNIQUE,
    owner INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (owner) REFERENCES User(id)
) ENGINE=INNODB;

-- Create table JoinLinks if not EXISTS
CREATE TABLE IF NOT EXISTS JoinLinks (
    id INT NOT NULL AUTO_INCREMENT UNIQUE,
    chatId INT NOT NULL,
    link VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (chatId) REFERENCES Chat(id)
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

-- Create tabe Config if not EXISTS
CREATE TABLE IF NOT EXISTS Config (
    id INT NOT NULL AUTO_INCREMENT,
    chat INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (chat) REFERENCES Chat(id)
) ENGINE=INNODB;

-- Create tabe Message if not EXISTS
CREATE TABLE IF NOT EXISTS Message (
    id INT NOT NULL AUTO_INCREMENT,
    chatId INT NOT NULL,
    id INT NOT NULL,
    content VARCHAR(4000),
    date TIMESTAMP NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (chatId) REFERENCES Chat(id),
    FOREIGN KEY (id) REFERENCES User(id)
) ENGINE=INNODB;
