drop database data; create database data; use data;
CREATE TABLE IF NOT EXISTS `calendars` (
  	`url` varchar(50) NOT NULL PRIMARY KEY,
  	`version_id` INTEGER NOT NULL,
  	`no_versions` INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS `versions` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  	`url` varchar(50) NOT NULL,
  	`version_id` INTEGER NOT NULL,
  	`title_id` varchar(55) NOT NULL,
  	`json_id` varchar(55) NOT NULL,
  	`notes_id` varchar(55) NOT NULL
);

CREATE TABLE IF NOT EXISTS `jsontable` (
  	`json_id` varchar(55) NOT NULL PRIMARY KEY,
  	`json` varchar(1000) NOT NULL
);

CREATE TABLE IF NOT EXISTS `titletable` (
  	`title_id` varchar(55) NOT NULL PRIMARY KEY,
  	`title` varchar(1000) NOT NULL
);

CREATE TABLE IF NOT EXISTS `notestable` (
  	`notes_id` varchar(55) NOT NULL PRIMARY KEY,
  	`notes` varchar(1000) NOT NULL
);

GRANT INSERT, SELECT, UPDATE ON data. * TO 'plan'@'localhost';

CREATE USER 'plan'@'localhost' IDENTIFIED BY 'password';