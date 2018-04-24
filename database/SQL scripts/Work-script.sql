use grouper;
SET SQL_SAFE_UPDATES = 0;
-- DROP TABLE IF EXISTS `groups`;

show tables;

-- CREATE TABLE IF NOT EXISTS `groups` (
-- 	id INTEGER NOT NULL AUTO_INCREMENT,
--     groupname VARCHAR(255),
--     
--     PRIMARY KEY (id)
-- );

-- INSERT INTO `groups` (`groupname`, `member`, `organization`) VALUES ('Klass 7A', 'Maj-Björn', 'Klockarhagsskolan');

SELECT * FROM `groups` WHERE (SELECT DISTINCT(groupname) FROM groups);

DELETE FROM `groups` WHERE groupname = 'Klass 5B';

SELECT * FROM `groups`;

SELECT * FROM `users`;

SELECT * FROM `migrations`;

