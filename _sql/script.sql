-- Supprimer la base de données "videogames" si elle existe déjà
DROP DATABASE IF EXISTS videogames;

-- Créer la base de données "videogames"
CREATE DATABASE videogames;

-- Utiliser la base de données "videogames"
USE videogames;

-- Créer la table "editor"
CREATE TABLE editor (
    id TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255)
);

-- Ajouter des éditeurs de jeux videos
INSERT INTO editor (name) 
VALUES
  ('Electronic Arts'),
  ('Ubisoft'),
  ('Activision Blizzard'),
  ('Bethesda Softworks'),
  ('Square Enix');

-- Créer la table "game"
CREATE TABLE game (
  id TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  release_date DATE NOT NULL,
  poster VARCHAR(255) NOT NULL,
  price DECIMAL(5,2) NOT NULL,
  editor_id TINYINT NOT NULL,
  FOREIGN KEY (editor_id) REFERENCES editor(id) ON DELETE CASCADE
);

-- Ajouter des jeux vidéos
INSERT INTO game (title, description, release_date, poster, price, editor_id)
VALUES
  ('The Legend of Zelda: Breath of the Wild', 'Explorez Hyrule et affrontez des ennemis dans cette aventure épique de Zelda.', '2017-03-03', 'zelda-breath-of-the-wild.jpg', 59.99, 1),
  ('Super Mario Odyssey', 'Rejoignez Mario dans sa quête pour sauver la princesse Peach dans ce jeu de plateforme en monde ouvert.', '2017-10-27', 'mario-odyssey.jpg', 49.99, 3),
  ('Red Dead Redemption 2', "Explorez le Far West et vivez l'aventure de cow-boy dans ce jeu de Rockstar.", '2018-10-26', 'red-dead-redemption-2.jpg', 59.99, 2),
  ('Horizon Zero Dawn', "Jeu d'action-aventure avec des combats contre des robots dans un monde ouvert post-apocalyptique.", '2017-02-28', 'horizon_zero_dawn.jpg', 39.99, 5),
  ('Final Fantasy VII Remake', 'Jeu de rôle en temps réel avec une histoire complexe et des personnages mémorables.', '2020-04-10', 'final_fantasy_vii_remake.jpg', 59.99, 4),
  ('The Last of Us Part II', "Jeu de survie en mode post-apocalyptique avec des éléments d'action-aventure.", '2020-06-19', 'the_last_of_us_part_ii.jpg', 69.99, 1),
  ("Assassin's Creed Valhalla", "Jeu d'action-aventure se déroulant dans l'univers des Vikings.", '2020-11-10', 'assassins_creed_valhalla.jpg', 59.99, 5),
  ('Mario Kart 8 Deluxe', "Jeu de course de kart avec des personnages de l'univers de Mario.", '2017-04-28', 'mario_kart_8_deluxe.jpg', 59.99, 2);

-- Créer la table "admin"
CREATE TABLE admin (
    id TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);
-- Ajouter un admin
INSERT INTO admin (email, password) VALUES ('admin@gmail.com','$argon2i$v=19$m=16,t=2,p=1$MUdjZVBQRWpHQmtSdUc0SA$VhHjZkW9Fa7aDdGTWe/0Xg');
-- mdp : azertyuiop

-- Créer la table "category"
CREATE TABLE category (
    id TINYINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) UNIQUE
);


-- Ajouter des catégories de jeux vidéos
INSERT INTO category (name) 
VALUES
  ('Action'),
  ('Aventure'),
  ('RPG'),
  ('Sport'),
  ('Stratégie');

-- Créer la table "game_category"
CREATE TABLE game_category (
    game_id TINYINT NOT NULL,
    category_id TINYINT NOT NULL,
    PRIMARY KEY (game_id, category_id),
    FOREIGN KEY (game_id) REFERENCES game(id),
    FOREIGN KEY (category_id) REFERENCES category(id)
);

-- Ajouter des catégories au élement de la table game
INSERT INTO game_category (game_id, category_id) 
VALUES
  (1,1),
  (1,2),
  (1,3),
  (2,1),
  (2,2),
  (3,1),
  (3,2),
  (3,3),
  (4,5),
  (5,3),
  (5,4),
  (5,5),
  (5,1),
  (5,2),
  (6,1),
  (6,4),
  (6,3),
  (6,5),
  (7,1),
  (7,5),
  (8,3);
  