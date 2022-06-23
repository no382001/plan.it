CREATE TABLE IF NOT EXISTS `content` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  	`url` varchar(50) NOT NULL,
  	`title` varchar(55) NOT NULL,
  	`json` varchar(1000) NOT NULL,
  	`notes` varchar(1000) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE USER 'plan'@'localhost' IDENTIFIED BY 'password';
GRANT INSERT, SELECT, UPDATE ON data. * TO 'plan'@'localhost';
