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