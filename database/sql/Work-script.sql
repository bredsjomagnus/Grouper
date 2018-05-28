use grouper;
-- SET SQL_SAFE_UPDATES = 0;
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
SELECT * FROM memberchoices;

SELECT memberid, GROUP_CONCAT(choiceid) as choices FROM memberchoices WHERE eventid = 1 GROUP BY memberid;

-- --------------------------------

SELECT choiceid, count(choiceid) AS numberofachoice FROM memberchoices WHERE eventid LIKE '%%' AND organization LIKE 'Klockarhagsskolan' GROUP BY choiceid;

SELECT choiceid, count(choiceid) AS numberofachoice FROM memberchoices WHERE eventid LIKE 2 AND organization LIKE 'Klockarhagsskolan' GROUP BY choiceid;

-- --------------------------------

SELECT choiceid, sum(choiceid) AS sumofchoices FROM memberchoices WHERE eventid LIKE '%%' AND organization LIKE 'Klockarhagsskolan' GROUP BY choiceid;

SELECT sum(choiceid) AS sumofchoices FROM memberchoices WHERE eventid LIKE '%%' AND organization LIKE 'Klockarhagsskolan';

SELECT * FROM groupmembers;

SELECT * FROM groupmembers WHERE groupid LIKE 1;

SELECT groupid, count(groupid) AS numberofmembers FROM groupmembers WHERE groupid LIKE '%%' AND organization LIKE 'Klockarhagsskolan' GROUP BY groupid;

SELECT * FROM `migrations`;

SELECT * FROM choices;

SELECT * FROM `events`;

SELECT * FROM eventchoices;

SELECT eventid, count(eventid) AS numberofchoices FROM eventchoices WHERE eventid LIKE '%%' AND organization LIKE 'Klockarhagsskolan' GROUP BY eventid;

SELECT * FROM eventgroups;

SELECT groupid FROM eventgroups WHERE organization LIKE 'Klockarhagsskolan';

SELECT eventid, count(eventid) AS numberofgroups FROM eventgroups WHERE eventid LIKE '%%' AND organization LIKE 'Klockarhagsskolan' GROUP BY eventid;

SELECT eventid, groupid FROM eventgroups WHERE eventid LIKE 1 AND organization LIKE 'Klockarhagsskolan';

SELECT * FROM groups WHERE organization LIKE 'Klockarhagsskolan';


-- DELETE FROM `events` WHERE id = 3;
