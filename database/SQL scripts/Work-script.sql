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
-- INSERT INTO organizations (organizationname) VALUES ('Klockarhagsskolan');

-- ALTER TABLE `groups` ADD updated_at DATETIME; 

SELECT * FROM `groups` WHERE (SELECT DISTINCT(groupname) FROM groups);

SELECT * FROM organizations;

SELECT * FROM `groups`;

SELECT * FROM `users`;

SELECT * FROM members;
-- UPDATE members SET membername = 'Göran' WHERE id = 12;

SELECT * FROM groupmembers;

SELECT * FROM groupmembers WHERE groupid LIKE 1;

SELECT groupid, count(groupid) AS numberofmembers FROM groupmembers WHERE groupid LIKE '%%' GROUP BY groupid;

SELECT * FROM `migrations`;
