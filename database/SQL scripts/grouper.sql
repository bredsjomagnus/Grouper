DROP TABLE IF EXISTS organizationgroups;
DROP TABLE IF EXISTS groupmembers;
DROP TABLE IF EXISTS eventgroups;
DROP TABLE IF EXISTS eventchoices;
DROP TABLE IF EXISTS memberchoices;

DROP TABLE IF EXISTS groups;
DROP TABLE IF EXISTS members;
DROP TABLE IF EXISTS organizations;
DROP TABLE IF EXISTS choices;
DROP TABLE IF EXISTS `events`;

-- DROP TABLE IF EXISTS organizationschoices;

CREATE TABLE IF NOT EXISTS groups (
	id INT(11) AUTO_INCREMENT,
    groupname VARCHAR(255),
    organization VARCHAR(255),
    updated_at DATETIME,
    deleted_at DATETIME,

    PRIMARY KEY (id)
);
-- SHOW CREATE TABLE groups;

CREATE TABLE IF NOT EXISTS members (
	id INT(11) AUTO_INCREMENT,
    membername VARCHAR(255),
    organization VARCHAR(255),
    updated_at DATETIME,
    deleted_at DATETIME,

    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS organizations (
	id INT(11) AUTO_INCREMENT,
    organizationname VARCHAR(255),
    

    PRIMARY KEY(id)
);
-- SHOW CREATE TABLE organizations;

CREATE TABLE IF NOT EXISTS organizationgroups (
	id INTEGER NOT NULL AUTO_INCREMENT,
    organizationid INT(11),
    groupid INT(11),
    updated_at DATETIME,
    deleted_at DATETIME,

    PRIMARY KEY(id),
    FOREIGN KEY (organizationid) REFERENCES organizations (id),
    FOREIGN KEY (groupid) REFERENCES groups (id)
);
-- SHOW CREATE TABLE organizationgroups;

CREATE TABLE IF NOT EXISTS groupmembers (
	id INTEGER AUTO_INCREMENT,
    groupid INT(11),
    memberid INT(11),
	organization VARCHAR(255),
    updated_at DATETIME,
    deleted_at DATETIME,
    
    PRIMARY KEY(id),
    FOREIGN KEY (groupid) REFERENCES groups (id),
    FOREIGN KEY (memberid) REFERENCES members (id)
);

CREATE TABLE IF NOT EXISTS choices (
	id INTEGER AUTO_INCREMENT,
    choicename VARCHAR(255),
    organization VARCHAR(255),
    updated_at DATETIME,
    deleted_at DATETIME,
    
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS `events` (
	id INTEGER AUTO_INCREMENT,
    eventname VARCHAR(255),
    organization VARCHAR(255),
    created_at DATETIME,
    updated_at DATETIME,
    deleted_at DATETIME,
    
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS eventgroups (
	id INTEGER AUTO_INCREMENT,
    eventid INTEGER,
    groupid INTEGER,
    organization VARCHAR(255),
    updated_at DATETIME,
    deleted_at DATETIME,
    
    PRIMARY KEY(id),
    FOREIGN KEY (eventid) REFERENCES `events` (id),
    FOREIGN KEY (groupid) REFERENCES groups (id)
);

CREATE TABLE IF NOT EXISTS eventchoices (
	id INTEGER AUTO_INCREMENT,
    eventid INTEGER,
    choiceid INTEGER,
    organization VARCHAR(255),
    updated_at DATETIME,
    deleted_at DATETIME,
    
    PRIMARY KEY(id),
    FOREIGN KEY (eventid) REFERENCES `events` (id),
    FOREIGN KEY (choiceid) REFERENCES choices (id)
);

CREATE TABLE IF NOT EXISTS memberchoices (
	id INTEGER AUTO_INCREMENT,
    memberid INTEGER,
    choiceid INTEGER,
    organization VARCHAR(255),
    updated_at DATETIME,
    deleted_at DATETIME,
    
    PRIMARY KEY(id),
    FOREIGN KEY (memberid) REFERENCES members (id),
    FOREIGN KEY (choiceid) REFERENCES choices (id)
);
-- CREATE TABLE IF NOT EXISTS organizationschoices (
-- 	id INTEGER AUTO_INCREMENT,
--     organizationid INT(11),
--     choiceid INT(11),
--     
--     PRIMARY KEY(id),
--     FOREIGN KEY (organizationid) REFERENCES organizations (id),
--     FOREIGN KEY (choiceid) REFERENCES choices (id)
-- );
