create database data;
use data;

CREATE TABLE IF NOT EXISTS `calendars` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  	`url` varchar(50) NOT NULL,
  	`version_id` INTEGER NOT NULL,
  	`no_versions` varchar(55) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `versions` (
  	`url` varchar(50) NOT NULL PRIMARY KEY,
  	`version_id` INTEGER NOT NULL,
  	`title_id` varchar(55) NOT NULL,
  	`json_id` varchar(55) NOT NULL,
  	`notes_id` varchar(55) NOT NULL
);

//i should search by int id instead to avoid confusion when the text is the same


CREATE TABLE IF NOT EXISTS `json_table` (
  	`json_id` varchar(55) NOT NULL PRIMARY KEY,
  	`json` varchar(1000) NOT NULL
);

CREATE TABLE IF NOT EXISTS `title_table` (
  	`title_id` varchar(55) NOT NULL PRIMARY KEY,
  	`title` varchar(1000) NOT NULL
);

CREATE TABLE IF NOT EXISTS `notes_table` (
  	`notes_id` varchar(55) NOT NULL PRIMARY KEY,
  	`notes` varchar(1000) NOT NULL
);


CREATE USER 'plan'@'localhost' IDENTIFIED BY 'password';
GRANT INSERT, SELECT, UPDATE ON data. * TO 'plan'@'localhost';




-- create
CREATE TABLE EMPLOYEE (
  empId INTEGER PRIMARY KEY,
  name TEXT NOT NULL,
  dept TEXT NOT NULL
);
CREATE TABLE dept (
  empId INTEGER PRIMARY KEY,
  name TEXT NOT NULL,
  dept TEXT NOT NULL
);
-- insert
INSERT INTO EMPLOYEE VALUES (0001, 'Clark', 'Sales');
INSERT INTO EMPLOYEE VALUES (0002, 'Dave', 'Accounting');
INSERT INTO EMPLOYEE VALUES (0003, 'Ava', 'Sales');

INSERT INTO dept VALUES (0001, 'dept', 'Sales');

-- fetch 
SELECT * FROM EMPLOYEE inner join dept on EMPLOYEE.dept = dept.dept where EMPLOYEE.dept = "Sales";


/* 
empId	name	dept	empId	name	dept
1	Clark	Sales	1	dept	Sales
3	Ava	Sales	1	dept	Sales

 */