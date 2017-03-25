/*This file contains all sql commands for this project*/


/*24.03.2017 : Create article table*/
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


/*24.03.2017 : Create comments table*/
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


/*24.03.2017 : Insert some datas*/
INSERT INTO Article (title, summary, content, is_published)
VALUES
    ('La naissance d\'un beau projet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dictum et ligula eget pharetra.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dictum et ligula eget pharetra. Cras ut ligula posuere, dictum tortor sagittis, congue lacus. Etiam semper tellus non dui maximus, non tempus eros varius. Phasellus in lacus risus. Morbi ultricies vehicula diam, id ullamcorper tortor ultricies ac. Morbi congue tincidunt mauris id egestas. Sed dapibus sed augue non ultrices. Nunc sit amet nulla ex. In molestie maximus est eget sagittis.

    Donec eu quam quis libero interdum vulputate eget nec ante. Phasellus volutpat diam sed blandit lacinia. Donec consequat mi euismod, interdum libero sit amet, tincidunt tellus. Aenean nec arcu turpis. Donec condimentum egestas lorem vitae faucibus. Nam at augue accumsan, sagittis leo in, suscipit nunc. Mauris vehicula risus eu neque scelerisque maximus. Nullam pellentesque dolor ex. Vestibulum maximus lectus est, id egestas mauris sollicitudin nec. Pellentesque finibus tristique augue nec aliquam.

    Donec aliquam orci tellus. Quisque bibendum mauris molestie tellus rhoncus, sed porta justo auctor. Ut iaculis posuere mi ut vulputate. Donec in congue lacus, cursus rutrum ex. Aenean ac urna ut massa luctus ultricies ac maximus est. Curabitur ex nisl, porttitor vitae pretium eu, dapibus id ante. Ut tincidunt lectus nec venenatis tempor. Maecenas enim tortor, pretium id fringilla non, sodales sed turpis. Nam porta vehicula nisl, non mattis nisi viverra sit amet. In diam felis, efficitur ut nisi eu, egestas molestie augue. Suspendisse et bibendum dolor. Donec dignissim, nunc in vulputate congue, mauris sapien porttitor eros, ac consequat erat erat non est.

    Mauris eu lacus vel dolor molestie tempus. Donec a sem sem. Duis ex lectus, mollis vitae sollicitudin et, vestibulum sit amet mi. Aenean venenatis consectetur massa. Phasellus risus mauris, sollicitudin at suscipit sit amet, congue et nisi. Quisque posuere tortor sagittis, eleifend libero ac, rhoncus elit. Ut egestas efficitur ipsum in semper. Ut vitae turpis ac odio convallis sollicitudin nec ac lectus.

    Sed eu viverra nulla, id placerat ex. Sed tellus lectus, sagittis accumsan pulvinar a, rhoncus nec ligula. Duis maximus aliquam laoreet. Duis sed velit dolor. Donec suscipit efficitur elit, a luctus urna scelerisque sit amet. Duis vel suscipit eros, vitae fermentum magna. Sed pellentesque ipsum et tincidunt lobortis. Integer id lacus sit amet justo faucibus malesuada.', 1),
    ('La préparation et les doutes', 'Proin dictum et ligula eget pharetra. Cras ut ligula posuere, dictum tortor sagittis, congue lacus.', 'Lutpat diam sed blandit lacinia. Donec consequat mi euismod, interdum libero sit amet, tincidunt tellus. Aenean nec arcu turpis. Donec condimentum egestas lorem vitae faucibus. Nam at augue accumsan, sagittis leo in, suscipit nunc. Mauris vehicula risus eu neque scelerisque maximus. Nullam pellentesque dolor ex. Vestibulum maximus lectus est, id egestas mauris sollicitudin nec. Pellentesque finibus tristique augue nec aliquam.

    Donec aliquam orci tellus. Quisque bibendum mauris molestie tellus rhoncus, sed porta justo auctor. Ut iaculis posuere mi ut vulputate. Donec in congue lacus, cursus rutrum ex. Aenean ac urna ut massa luctus ultricies ac maximus est. Curabitur ex nisl, porttitor vitae pretium eu, dapibus id ante. Ut tincidunt lectus nec venenatis tempor. Maecenas enim tortor, pretium id fringilla non, sodales sed turpis. Nam porta vehicula nisl, non mattis nisi viverra sit amet. In diam felis, efficitur ut nisi eu, egestas molestie augue. Suspendisse et bibendum dolor. Donec dignissim, nunc in vulputate congue, mauris sapien porttitor eros, ac consequat erat erat non est.

    Mauris eu lacus vel dolor molestie tempus. Donec a sem sem. Duis ex lectus, mollis vitae sollicitudin et, vestibulum sit amet mi. Aenean venenatis consectetur massa. Phasellus risus mauris, sollicitudin at suscipit sit amet, congue et nisi. Quisque posuere tortor sagittis, eleifend libero ac, rhoncus elit. Ut egestas efficitur ipsum in semper. Ut vitae turpis ac odio convallis sollicitudin nec ac lectus.

    Sed eu viverra nulla, id placerat ex. Sed tellus lectus, sagittis accumsan pulvinar a, rhoncus nec ligula. Duis maximus aliquam laoreet. Duis sed velit dolor. Donec suscipit efficitur elit, a luctus urna scelerisque sit amet. Duis vel suscipit eros, vitae fermentum magna. Sed pellentesque ipsum et tincidunt lobortis. Integer id lacus sit amet justo faucibus malesuada.', 1),
    ('Le départ, aucun retour en arrière n\'est possible', 'Cras ut ligula posuere, dictum tortor sagittis, congue lacus. Etiam semper tellus non dui maximus, non tempus eros varius.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin dictum et ligula eget pharetra. Cras ut ligula posuere, dictum tortor sagittis, congue lacus. Etiam semper tellus non dui maximus, non tempus eros varius. Phasellus in lacus risus. Morbi ultricies vehicula diam, id ullamcorper tortor ultricies ac. Morbi congue tincidunt mauris id egestas. Sed dapibus sed augue non ultrices. Nunc sit amet nulla ex. In molestie maximus est eget sagittis.

    Donec eu quam quis libero interdum vulputate eget nec ante. Phasellus volutpat diam sed blandit lacinia. Donec consequat mi euismod, interdum libero sit amet, tincidunt tellus. Aenean nec arcu turpis. Donec condimentum egestas lorem vitae faucibus. Nam at augue accumsan, sagittis leo in, suscipit nunc. Mauris vehicula risus eu neque scelerisque maximus. Nullam pellentesque dolor ex. Vestibulum maximus lectus est, id egestas mauris sollicitudin nec. Pellentesque finibus tristique augue nec aliquam.

    Donec aliquam orci tellus. Quisque bibendum mauris molestie tellus rhoncus, sed porta justo auctor. Ut iaculis posuere mi ut vulputate. Donec in congue lacus, cursus rutrum ex. Aenean ac urna ut massa luctus ultricies ac maximus est. Curabitur ex nisl, porttitor vitae pretium eu, dapibus id ante. Ut tincidunt lectus nec venenatis tempor. Maecenas enim tortor, pretium id fringilla non, sodales sed turpis. Nam porta vehicula nisl, non mattis nisi viverra sit amet. In diam felis, efficitur ut nisi eu, egestas molestie augue. Suspendisse et bibendum dolor. Donec dignissim, nunc in vulputate congue, mauris sapien porttitor eros, ac consequat erat erat non est.

    Mauris eu lacus vel dolor molestie tempus. Donec a sem sem. Duis ex lectus, mollis vitae sollicitudin et, vestibulum sit amet mi. Aenean venenatis consectetur massa. Phasellus risus mauris, sollicitudin at suscipit sit amet, congue et nisi. Quisque posuere tortor sagittis, eleifend libero ac, rhoncus elit. Ut egestas efficitur ipsum in semper. Ut vitae turpis ac odio convallis sollicitudin nec ac lectus.

    Sed eu viverra nulla, id placerat ex. Sed tellus lectus, sagittis accumsan pulvinar a, rhoncus nec ligula. Duis maximus aliquam laoreet. Duis sed velit dolor. Donec suscipit efficitur elit, a luctus urna scelerisque sit amet. Duis vel suscipit eros, vitae fermentum magna. Sed pellentesque ipsum et tincidunt lobortis. Integer id lacus sit amet justo faucibus malesuada.', 1);
INSERT INTO Comment(article_id, author, content, report, reply)
VALUES (1, 'Leo', 'Commentaire test', 0, 1);
/* ---------------------------- */


/*24.03.2017 : Add a foreign key on article_id on Comment*/
ALTER TABLE Comment
ADD CONSTRAINT fk_article_id FOREIGN KEY (article_id) REFERENCES Article(id) ON DELETE CASCADE;
/* ---------------------------- */
