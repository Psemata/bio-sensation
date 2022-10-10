-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `biosensation`;
CREATE DATABASE `biosensation` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `biosensation`;

DROP TABLE IF EXISTS `biome`;
CREATE TABLE `biome` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos_x` int(11) NOT NULL,
  `pos_y` int(11) NOT NULL,
  `radius` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `genre` (`genre`),
  CONSTRAINT `biome_ibfk_2` FOREIGN KEY (`genre`) REFERENCES `genre` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `biome` (`id`, `pos_x`, `pos_y`, `radius`, `genre`) VALUES
(1,	777876,	5966527,	150,	1),
(3,	785835,	5963802,	300,	3),
(4,	778377,	5966070,	100,	2);

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `playlist` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `playlist` (`playlist`),
  CONSTRAINT `genre_ibfk_1` FOREIGN KEY (`playlist`) REFERENCES `playlist` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `genre` (`id`, `name`, `playlist`) VALUES
(1,	'Ville',	1),
(2,	'Plage',	2),
(3,	'Forêt',	3);

DROP TABLE IF EXISTS `music`;
CREATE TABLE `music` (
  `link` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  PRIMARY KEY (`link`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `playlist`;
CREATE TABLE `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `playlist` (`id`, `name`) VALUES
(1,	'OuaisOuaisOuais'),
(2,	'Ukulele Songs'),
(3,	'Forest Piano');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `email`, `password`, `username`, `admin`) VALUES
(1,	'test@test.ch',	'$2y$10$/eqhctKE/SEY6vJyw4hxOe/Gf0hjeEsD20NPDedger3SnEPoGA0vu',	'PseudoTest',	0),
(2,	'bruno.costa@he-arc.ch',	'$2y$10$pcbQmkAy8RomkdEQ5cLolON.U2nMqmBrJrIJfgosa1ZS8bOkI78Ky',	'Psemata',	1),
(3,	'diogo.lopesdas@he-arc.ch',	'$2y$10$SFGA1QN6a/WzFdVTP..cjeiV8rKZuTS9pt.vDy4gc9IBzLynJENNC',	'Ultrasic',	1),
(5,	'test12345@test.ch',	'$2y$10$UScbhpWbCFg7D4HHTDJ37.Jt4SeSiI0vmEVcljcTz9AkpffIictAG',	'PseudoTest2',	0),
(8,	'bruno.costa@he-arc.com',	'$2y$10$Pz2GjdEA.mlBKd11PjtEMe73mem.3xsDjawK873HkwYfy0kh19p8G',	'wlkjdlakjdwlajd',	0),
(9,	'koalak.warrior@ultra.ch',	'$2y$10$sASOc6KqT2oQslG0noq2.eJeTo6CjCojvBUbqIwHQRc8BiLdXosga',	'Koalak',	0),
(10,	'harold@hotmail.ch',	'$2y$10$0isJMBOhty.nQ0/Ug8rYne5XDxr7jLsh9TNZXJQ.o8QXBuPChx./6',	'TestUser',	0);

-- 2021-06-19 11:14:14
