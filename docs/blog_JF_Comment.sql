CREATE TABLE Comment
(
    id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    article_id INT(10) UNSIGNED NOT NULL,
    date_add DATETIME NOT NULL,
    author VARCHAR(100) NOT NULL,
    content LONGTEXT NOT NULL,
    report INT(11) DEFAULT '0' NOT NULL,
    parent_comment_id INT(10) UNSIGNED DEFAULT '0',
    email VARCHAR(255),
    depth INT(11) DEFAULT '0',
    isAdministrator TINYINT(1) DEFAULT '0',
    CONSTRAINT fk_article_id FOREIGN KEY (article_id) REFERENCES Article (id)
);
CREATE INDEX fk_article_id ON Comment (article_id);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-04 18:14:27', 'Leo', 'Test', 0, 0, 'leogrambert@gmail.com', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-04 18:14:50', 'Leo', 'Réponse de réponse', 2, 111, '', 2, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-04 18:15:02', 'Anonyme', 'Réponse de réponse de réponse', 22, 112, '', 3, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 13:15:59', 'Anonyme', 'Test', 1, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 13:16:12', 'Anonyme', 'test', 0, 116, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 13:17:38', 'Anonyme', 'test', 2, 117, '', 2, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 14:37:18', 'Anonyme', 'test', 0, 110, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 14:39:01', 'Anonyme', 'test', 0, 110, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 14:39:10', 'Anonyme', 'test', 3, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 14:40:28', 'Anonyme', 'test', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-07 14:40:38', 'Anonyme', 'test', 1, 117, '', 2, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-09 14:37:35', 'Leo', 'commentaire test', 5, 0, 'leogrambert@gmail.com', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-09 14:37:58', 'Leo', 'Réponse
', 3, 126, 'leogrambert@gmail.com', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-09 14:38:28', 'Leo', 'Réponse
', 5, 126, 'leogrambert@gmail.com', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-09 14:38:38', 'Leo', 'Test', 4, 127, '', 2, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-11 10:30:43', 'Machin', 'test', 6, 0, 'machin@machin.fr', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (1, '2017-04-11 10:31:09', 'Et velit laboris cillum quia fugit laborum incidunt consequat Pariatur Qui est obcaecati', 'In accusamus vero molestiae omnis sit magna non vel nisi non accusantium non occaecat quo eveniet.', 41, 0, 'xowuse@yahoo.com', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 10:34:46', 'Anonyme', 'test', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 10:39:32', 'Array', 'test', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 10:40:12', 'Array', 'test', 0, 134, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 10:40:33', 'Array', 'test', 0, 134, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 10:41:05', 'Jean Forteroche', 'test', 0, 134, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 10:48:42', 'Jean Forteroche', 'test', 0, 134, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 11:34:03', 'Jean Forteroche', 'hgffghfg', 0, 134, '', 1, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 11:34:51', 'Jean Forteroche', 'Blabla', 0, 0, 'leogrambert@gmail.com', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 11:43:13', 'Leo', 'test', 0, 140, 'leogrambert@gmail.com', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 11:43:19', 'Anonyme', 'fgdfgfdgfd', 0, 141, '', 2, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 11:43:33', 'vinzou', 'fsdfsdfsd', 0, 142, 'leo@grambert.fr', 3, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 11:50:28', 'Jean Forteroche', 'Réponse', 0, 141, '', 2, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:29:56', 'Jean Forteroche', 'Test', 0, 0, '', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:30:20', 'Anonyme', 'test', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:30:32', 'Leo', 'Réponse', 0, 145, 'leogrambert@gmail.com', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:33:15', 'Leo', 'Réponse', 0, 145, 'leogrambert@gmail.com', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:33:28', 'Leo', 'jiodfgdoifjgdf', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:35:21', 'Leo', 'jiodfgdoifjgdf', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:36:37', 'Leo', 'jiodfgdoifjgdf', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:37:41', 'Leo', 'jiodfgdoifjgdf', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:39:44', 'Leo', 'jiodfgdoifjgdf', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:42:00', 'Jean Forteroche', 'test', 0, 0, '', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:43:22', 'Jean Forteroche', 'test', 0, 0, '', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:43:35', 'Jean Forteroche', 'test', 1, 0, '', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:45:55', 'Jean Forteroche', 'test', 1, 156, '', 1, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:47:44', 'Jean Forteroche', 'test', 0, 157, '', 2, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:48:02', 'Jean Forteroche', 'test', 0, 157, '', 2, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:48:13', 'Jean Forteroche', 'test', 0, 158, '', 3, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:49:12', 'Jean Forteroche', 'test', 0, 158, '', 3, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:49:23', 'Jean Forteroche', 'test', 0, 158, '', 3, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:54:16', 'Jean Forteroche', 'fgdfgdf', 0, 157, '', 2, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-05 13:56:56', 'Jean Forteroche', 'fgdfgdf', 0, 157, '', 2, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-06 13:54:11', 'test', 'test', 0, 156, '', 1, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (12, '2017-05-06 14:29:34', 'Jean Forteroche', 'Message test pour vérifier que les messages flash fonctionnent correctement.', 0, 0, '', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (3, '2017-05-06 15:30:24', 'Leo', 'Test sur mozarella firefox', 1, 0, 'leogrambert@gmail.com', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (2, '2017-05-08 09:53:39', 'Jean Forteroche', 'test', 0, 0, '', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (2, '2017-05-08 09:53:46', 'Jean Forteroche', 'test', 0, 169, '', 1, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (2, '2017-05-08 09:53:53', 'Jean Forteroche', 'test', 0, 170, '', 2, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (2, '2017-05-08 09:53:58', 'Jean Forteroche', 'test', 0, 171, '', 3, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-08 15:37:29', 'Leo', 'test', 0, 0, '', 0, 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-10 16:37:32', 'Jean Forteroche', 'Piti test', 0, 0, '', 0, 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth, isAdministrator) VALUES (29, '2017-05-10 16:37:53', 'Anonyme', 'piti test', 0, 174, '', 1, 0);
