drop database if exists videogames;
create database videogames;

use videogames;

create table videogames.game
(
    id tinyint primary key AUTOINCREMENT,
    title VARCHAR NOT NULL,
    [description] text NOT NULL,
    release_date DATE NOT NULL,
    poster VARCHAR NOT NULL,
    price DECIMAL(5,2) NOT NULL,
);

-- insert into videogames.game
-- values  ('jeux1','description1','22020524','poster1',12.5),
--         ('jeux2','description2','20030412','poster2',23.9),
--         ('jeux3','description3','20051224','poster3',52.99);