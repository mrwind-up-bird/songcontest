/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  oli
 * Created: 17.03.2021
 */
CREATE USER 'songcontest'@'localhost' IDENTIFIED BY 'l0c4lh05t';
CREATE DATABASE songcontest;
GRANT ALL PRIVILEGES ON songcontest . * to 'songcontest'@'localhost';
FLUSH PRIVILES;

USE songcontest;

CREATE TABLE `history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `score` int DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `contest` varchar(50) DEFAULT NULL,
  `ts` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`history_id`),
  UNIQUE KEY `history_id_UNIQUE` (`history_id`)
) ENGINE=InnoDB AUTO_INCREMENT=158 DEFAULT CHARSET=utf8