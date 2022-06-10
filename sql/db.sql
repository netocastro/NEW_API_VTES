DROP TABLE IF EXISTS have_list_library;
DROP TABLE IF EXISTS have_list_crypt;
DROP TABLE IF EXISTS want_list_library;
DROP TABLE IF EXISTS want_list_crypt;
DROP TABLE IF EXISTS crypt_list;
DROP TABLE IF EXISTS library_list;
DROP TABLE IF EXISTS decks;
DROP TABLE IF EXISTS adresses;
DROP TABLE IF EXISTS decktxt;
DROP TABLE IF EXISTS users;

CREATE TABLE `users`(
      `id` INTEGER AUTO_INCREMENT,
      `name` VARCHAR(30) NOT NULL UNIQUE,
      `email` VARCHAR(50) NOT NULL UNIQUE,
      `password` VARCHAR(64) NOT NULL,

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into users(name, password, email) VALUES('admin','$2y$10$nV6.u2MRA/lEbo5OdkIQSOE5H.330s6UkVAgXNe8.DsEUcnU.kvRm','admin@admin.com'),
('Joao','$2y$10$nV6.u2MRA/lEbo5OdkIQSOE5H.330s6UkVAgXNe8.DsEUcnU.kvRm','joao@joao.com'),('Maria','$2y$10$nV6.u2MRA/lEbo5OdkIQSOE5H.330s6UkVAgXNe8.DsEUcnU.kvRm','mariana@teste.com'),('Paulo','$2y$10$nV6.u2MRA/lEbo5OdkIQSOE5H.330s6UkVAgXNe8.DsEUcnU.kvRm','paulo@teste.com'),
('Otorrinolaringologista','$2y$10$nV6.u2MRA/lEbo5OdkIQSOE5H.330s6UkVAgXNe8.DsEUcnU.kvRm','otorrinolaringologista@teste.com'),('Alice','td$2y$10$nV6.u2MRA/lEbo5OdkIQSOE5H.330s6UkVAgXNe8.DsEUcnU.kvRm','alice@teste.com'),('Alicate','td$2y$10$nV6.u2MRA/lEbo5OdkIQSOE5H.330s6UkVAgXNe8.DsEUcnU.kvRm','alicate@teste.com');

CREATE TABLE `adresses`(
      `id` INTEGER AUTO_INCREMENT,
      `user_id` integer,
      `street` VARCHAR(50),
      `number` VARCHAR(10),
      `complement` VARCHAR(10),
      `city` VARCHAR(50) NOT NULL,
      `state` VARCHAR(50) NOT NULL,
      `country` VARCHAR(50) NOT NULL,

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE adresses ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;

insert into adresses(user_id, street, number, complement, city, state, country) VALUES(1,'','','','Maceio','AL','country');

CREATE TABLE `decks`(
      `id` INTEGER AUTO_INCREMENT,
      `name` VARCHAR(30) NOT NULL,
      `user_id` integer,

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE decks ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;

insert into decks(name, user_id) VALUES('Giovanni de aliado',1);

CREATE TABLE `library_list`(
      `id` INTEGER AUTO_INCREMENT,
      `deck_id` integer NOT NULL, 
      `amount` TINYINT NOT NULL,  
      `library_card_id` integer NOT NULL, 

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE library_list ADD FOREIGN KEY (deck_id) REFERENCES decks(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE library_list ADD FOREIGN KEY (library_card_id) REFERENCES vteslib(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- ids de cartas de livraria começam apartir de 100001

insert into library_list(deck_id, amount, library_card_id) VALUES(1, 2, 100001), (1, 3, 100015), (1, 2, 100023);

CREATE TABLE `crypt_list`(
      `id` INTEGER AUTO_INCREMENT,
      `deck_id` integer NOT NULL, 
      `amount` TINYINT NOT NULL,  
      `crypt_card_id` integer NOT NULL, 

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE crypt_list ADD FOREIGN KEY (deck_id) REFERENCES decks(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE crypt_list ADD FOREIGN KEY (crypt_card_id) REFERENCES vtescrypt(id) ON UPDATE CASCADE ON DELETE CASCADE;

-- ids de cartas de livraria comecam aparrtir de 200001

insert into crypt_list(deck_id, amount, crypt_card_id) VALUES(1, 2, 200001), (1, 3, 200015), (1, 2, 200023);

CREATE TABLE `decktxt`(
      `id` INTEGER AUTO_INCREMENT,
      `user_id` integer NOT NULL, 
      `directory` VARCHAR(100) NOT NULL,

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE decktxt ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;

CREATE TABLE `want_list_library`(
      `id` INTEGER AUTO_INCREMENT,
      `amount` TINYINT NOT NULL,  
      `user_id` integer NOT NULL, 
      `library_card_id` integer NOT NULL, 

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE want_list_library ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE want_list_library ADD FOREIGN KEY (library_card_id) REFERENCES vteslib(id) ON UPDATE CASCADE ON DELETE CASCADE;

insert into want_list_library(user_id, amount, library_card_id) VALUES(1, 2, 100001), (1, 3, 100015), (1, 2, 100023);

CREATE TABLE `want_list_crypt`(
      `id` INTEGER AUTO_INCREMENT,
      `amount` TINYINT NOT NULL,  
      `user_id` integer NOT NULL, 
      `crypt_card_id` integer NOT NULL, 

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE want_list_crypt ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE want_list_crypt ADD FOREIGN KEY (crypt_card_id) REFERENCES vtescrypt(id) ON UPDATE CASCADE ON DELETE CASCADE;

insert into want_list_crypt(user_id, amount, crypt_card_id) VALUES(1, 2, 200001), (1, 3, 200015), (1, 2, 200023), (1, 3, 200003);

CREATE TABLE `have_list_library`(
      `id` INTEGER AUTO_INCREMENT,
      `amount` TINYINT NOT NULL,  
      `user_id` integer NOT NULL, 
      `library_card_id` integer NOT NULL, 

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE have_list_library ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE have_list_library ADD FOREIGN KEY (library_card_id) REFERENCES vteslib(id) ON UPDATE CASCADE ON DELETE CASCADE;

insert into have_list_library(user_id, amount, library_card_id) VALUES(1, 2, 100001), (1, 3, 100015), (1, 2, 100023);

CREATE TABLE `have_list_crypt`(
      `id` INTEGER AUTO_INCREMENT,
      `amount` TINYINT NOT NULL,  
      `user_id` integer NOT NULL, 
      `crypt_card_id` integer NOT NULL, 

      PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE have_list_crypt ADD FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE have_list_crypt ADD FOREIGN KEY (crypt_card_id) REFERENCES vtescrypt(id) ON UPDATE CASCADE ON DELETE CASCADE;

insert into have_list_crypt(user_id, amount, crypt_card_id) VALUES(1, 2, 200001), (1, 3, 200015), (1, 2, 200023), (1, 3, 200003);
