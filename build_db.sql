CREATE TABLE IF NOT EXISTS `main` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  	`url` varchar(50) NOT NULL,
  	`json_id` varchar(55) NOT NULL,
  	`version_id` varchar(55) NOT NULL,
  	`created` TIMESTAMP NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `version` (
  	`version_id` varchar(50) NOT NULL,
  	`json_id` varchar(55) NOT NULL
);

CREATE TABLE IF NOT EXISTS `version` (
  	`json_id` varchar(50) NOT NULL,
  	`json` varchar(50) NOT NULL,
  	`title` varchar(55) NOT NULL,
  	`notes` varchar(55) NOT NULL
  	`last_edited` TIMESTAMP NOT NULL
);

version control:
	i would need to insert multiple rows in differend dbs for this to work


CREATE USER 'plan'@'localhost' IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON data. * TO 'plan'@'localhost';

ALTER TABLE content
ADD title varchar(55);

ALTER TABLE [content] DROP COLUMN id
ALTER TABLE [content] ADD id INT IDENTITY(1,1)


UPDATE content SET title = ?, content = ? WHERE url = ?