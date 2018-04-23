use grouper;

DROP TABLE IF EXISTS `groups`;

show tables;

CREATE TABLE IF NOT EXISTS `groups` (
	id INTEGER NOT NULL AUTO_INCREMENT,
    groupname VARCHAR(255),
    
    PRIMARY KEY (id)
);

-- INSERT INTO `groups` (`groupname`) VALUES ('Klass 7A');

SELECT * FROM `groups`;