CREATE TABLE Comment
(
    id INT(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    article_id INT(10) UNSIGNED NOT NULL,
    date_add DATETIME DEFAULT 'CURRENT_TIMESTAMP' NOT NULL,
    author VARCHAR(100) NOT NULL,
    content LONGTEXT NOT NULL,
    report INT(11) DEFAULT '0' NOT NULL,
    parent_comment_id INT(10) UNSIGNED DEFAULT '0',
    email VARCHAR(255),
    depth INT(11) DEFAULT '0',
    CONSTRAINT fk_article_id FOREIGN KEY (article_id) REFERENCES Article (id)
);
CREATE INDEX fk_article_id ON Comment (article_id);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-04 18:14:27', 'Leo', 'Test', 0, 0, 'leogrambert@gmail.com', 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-04 18:14:39', 'Leo', 'Réponse', 0, 110, 'leo@grambert.fr', 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-04 18:14:50', 'Leo', 'Réponse de réponse', 0, 111, '', 2);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-04 18:15:02', 'Anonyme', 'Réponse de réponse de réponse', 0, 112, '', 3);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 13:15:59', 'Anonyme', 'Test', 0, 0, '', 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 13:16:12', 'Anonyme', 'test', 0, 116, '', 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 13:17:38', 'Anonyme', 'test', 0, 117, '', 2);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 14:37:18', 'Anonyme', 'test', 0, 110, '', 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 14:39:01', 'Anonyme', 'test', 0, 110, '', 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 14:39:10', 'Anonyme', 'test', 0, 0, '', 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 14:40:28', 'Anonyme', 'test', 0, 0, '', 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 14:40:38', 'Anonyme', 'test', 0, 117, '', 2);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 14:40:44', 'Anonyme', 'test', 0, 117, '', 2);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-07 14:40:52', 'Anonyme', 'test', 0, 112, '', 3);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-09 14:37:35', 'Leo', 'commentaire test', 0, 0, 'leogrambert@gmail.com', 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-09 14:37:58', 'Leo', 'Réponse
', 0, 126, 'leogrambert@gmail.com', 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-09 14:38:28', 'Leo', 'Réponse
', 0, 126, 'leogrambert@gmail.com', 1);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-09 14:38:38', 'Leo', 'Test', 0, 127, '', 2);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-11 10:30:43', 'Machin', 'test', 0, 0, 'machin@machin.fr', 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-11 10:30:57', 'Machin', 'test', 0, 0, 'machin@machin.fr', 0);
INSERT INTO blog_JF.Comment (article_id, date_add, author, content, report, parent_comment_id, email, depth) VALUES (1, '2017-04-11 10:31:09', 'Et velit laboris cillum quia fugit laborum incidunt consequat Pariatur Qui est obcaecati', 'In accusamus vero molestiae omnis sit magna non vel nisi non accusantium non occaecat quo eveniet.', 10, 0, 'xowuse@yahoo.com', 0);
