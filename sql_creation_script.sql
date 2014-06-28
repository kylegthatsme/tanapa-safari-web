DROP TABLE IF EXISTS SAFARI_POINTS_OF_INTEREST;
DROP TABLE IF EXISTS SAFARI_WAYPOINTS;
DROP TABLE IF EXISTS REPORT;
DROP TABLE IF EXISTS REPORT_TYPE;
DROP TABLE IF EXISTS USER_LOG;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS SAFARI;
DROP TABLE IF EXISTS MEDIA;
DROP TABLE IF EXISTS ANIMAL_GROUP;
DROP TABLE IF EXISTS ANIMAL_SPECIFIC;


DROP TABLE IF EXISTS safari_points_of_interest;
DROP TABLE IF EXISTS safari_waypoints;
DROP TABLE IF EXISTS report;
DROP TABLE IF EXISTS report_type;
DROP TABLE IF EXISTS user_log;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS safari;
DROP TABLE IF EXISTS media;
DROP TABLE IF EXISTS animal_group;
DROP TABLE IF EXISTS animal_specific;


CREATE TABLE USER
(
	id				INTEGER(20) NOT NULL auto_increment,
	PRIMARY KEY(id)
);

CREATE TABLE USER_LOG
(
	id				INTEGER(30) NOT NULL auto_increment,
	user_id			INTEGER(20) NOT NULL,
	latitude		DECIMAL(8,6) NOT NULL,
	longitude		DECIMAL(9,6) NOT NULL,
	time			TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id),
	Foreign Key (user_id) references USER(id)
);

CREATE TABLE MEDIA
(
	id				INTEGER(30) NOT NULL auto_increment,
	type			VARCHAR(20) NOT NULL,
	url				VARCHAR(50) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE REPORT_TYPE
(
	id				INTEGER(20) NOT NULL auto_increment,
	name			VARCHAR(80) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE REPORT
(
	id				INTEGER(20) NOT NULL auto_increment,
	report_type_id	INTEGER(20) NOT NULL,
	content			TEXT,
	time			timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	latitude		DECIMAL(8,6),
	longitude		DECIMAL(9,6),
	user_id			INTEGER(20) NOT NULL,
	report_media_id	INTEGER(30),
	PRIMARY KEY(id),
	Foreign Key(report_type_id) references REPORT_TYPE(id),
	Foreign Key(user_id) references USER(id),
	Foreign Key(report_media_id) references MEDIA(id)
);

CREATE TABLE SAFARI
(
	id				INTEGER(11) NOT NULL auto_increment,
	name			VARCHAR(80) NOT NULL,
	description		TEXT,
	header_media_id	INTEGER(30),
	footer_media_id	INTEGER(30),
	tile_media_id	INTEGER(30),
	PRIMARY KEY (id),
	Foreign Key (header_media_id) references MEDIA(id),
	Foreign Key (footer_media_id) references MEDIA(id),
	Foreign Key (tile_media_id) references MEDIA(id)
);

CREATE TABLE SAFARI_WAYPOINTS
(
	id				INTEGER(15) NOT NULL auto_increment,
	sequence		INTEGER(15) NOT NULL,
	latitude		DECIMAL(8,6) NOT NULL,
	longitude		DECIMAL(9,6) NOT NULL,
	safari_id		INTEGER(11) NOT NULL,
	PRIMARY KEY (id),
	Foreign Key (safari_id) references SAFARI(id)
);

CREATE TABLE SAFARI_POINTS_OF_INTEREST
(
	id				INTEGER(20) NOT NULL auto_increment,
	name			VARCHAR(80) NOT NULL,
	media_id        INTEGER(20) NOT NULL, 
    safari_id		INTEGER(255) NOT NULL,
	latitude		DECIMAL(8,6) NOT NULL,
	longitude		DECIMAL(9,6) NOT NULL,
	radius			INTEGER(11) NOT NULL,
	PRIMARY KEY (id),
	Foreign Key(safari_id) references SAFARI(id)
);
CREATE TABLE ANIMAL_GROUP
(
	id				INTEGER(11) NOT NULL auto_increment,
	name			VARCHAR(80) NOT NULL,
	description		TEXT,
	header_media_id	INTEGER(30),
	footer_media_id	INTEGER(30),
	tile_media_id	INTEGER(30),
	PRIMARY KEY (id),
	Foreign Key (header_media_id) references MEDIA(id),
	Foreign Key (footer_media_id) references MEDIA(id),
	Foreign Key (tile_media_id) references MEDIA(id)
);
CREATE TABLE ANIMAL_SPECIFIC
(
	id				INTEGER(20) NOT NULL auto_increment,
	name			VARCHAR(80) NOT NULL,
	description		TEXT,
	media_id        INTEGER(20) NOT NULL, 
    group_id		INTEGER(255) NOT NULL,
	PRIMARY KEY (id),
	Foreign Key(group_id) references ANIMAL_GROUP(id)
);
