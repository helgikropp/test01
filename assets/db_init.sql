CREATE DATABASE IF NOT EXISTS test01;

USE test01;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT NOT NULL auto_increment PRIMARY KEY,
    `login` VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(32) NOT NULL,
    email VARCHAR(100) NOT NULL,
    is_admin INT NOT NULL DEFAULT 0
);

-- DELETE FROM users;

INSERT INTO users (`login`,pass,email,is_admin) VALUES ('user',MD5('puser'),'test1@ukr.net',0);
INSERT INTO users (`login`,pass,email,is_admin) VALUES ('admin',MD5('padmin'),'test2@ukr.net',1);

DROP TABLE IF EXISTS events;

CREATE TABLE events (
    id INT NOT NULL auto_increment PRIMARY KEY,
    user_id INT NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    type_id INT NOT NULL,
    `target` VARCHAR(50) NOT NULL
);

DROP TABLE IF EXISTS event_types;

CREATE TABLE event_types (
    id INT NOT NULL auto_increment PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL
);

INSERT INTO event_types (`name`) VALUES ('Login');
INSERT INTO event_types (`name`) VALUES ('Logout');
INSERT INTO event_types (`name`) VALUES ('Registration');
INSERT INTO event_types (`name`) VALUES ('Page view');
INSERT INTO event_types (`name`) VALUES ('Button click');
