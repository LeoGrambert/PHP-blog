/*This file contains all sql commands for this project*/


/*Create article database*/
CREATE TABLE Article (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    date_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(50) NOT NULL,
    summary VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    is_published BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
)
ENGINE=INNODB;
/* ---------------------------- */


/*Create comments database*/
CREATE TABLE Comment (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  article_id INT UNSIGNED NOT NULL,
  date_add DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  author VARCHAR(10) NOT NULL,
  content TEXT NOT NULL,
  report BOOLEAN NOT NULL DEFAULT 0,
  reply INTEGER NOT NULL,
  PRIMARY KEY (id)
)
ENGINE=INNODB;
/* ---------------------------- */
