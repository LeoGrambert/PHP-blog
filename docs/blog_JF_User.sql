CREATE TABLE User
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(255),
    password VARCHAR(255),
    picture VARCHAR(255) DEFAULT '/web/img/user.png'
);
CREATE UNIQUE INDEX User_id_uindex ON User (id);
INSERT INTO blog_JF.User (username, password, picture) VALUES ('username', '5f4dcc3b5aa765d61d8327deb882cf99', '/web/img/upload/man.png');
