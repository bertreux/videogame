-- Supprimer la base de données "videogames" si elle existe déjà
DROP DATABASE IF EXISTS videogames;

-- Créer la base de données "videogames"
CREATE DATABASE videogames;

-- Utiliser la base de données "videogames"
USE videogames;

-- Supprimer la table "game" si elle existe déjà
DROP TABLE IF EXISTS game;


-- Créer la table "game"
CREATE TABLE game (
  id TINYINT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  release_date DATE NOT NULL,
  poster VARCHAR(255) NOT NULL,
  price DECIMAL(5,2) NOT NULL
);

-- Ajouter des jeux vidéos
INSERT INTO game (id, title, description, release_date, poster, price)
VALUES
  (1, 'The Legend of Zelda: Breath of the Wild', 'Explorez Hyrule et affrontez des ennemis dans cette aventure épique de Zelda.', '2017-03-03', 'zelda-breath-of-the-wild.jpg', 59.99),
  (2, 'Super Mario Odyssey', 'Rejoignez Mario dans sa quête pour sauver la princesse Peach dans ce jeu de plateforme en monde ouvert.', '2017-10-27', 'mario-odyssey.jpg', 49.99),
  (3, 'Red Dead Redemption 2', "Explorez le Far West et vivez l'aventure de cow-boy dans ce jeu de Rockstar.", '2018-10-26', 'red-dead-redemption-2.jpg', 59.99);
