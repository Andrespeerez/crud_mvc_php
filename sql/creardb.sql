CREATE DATABASE mvc_crud;

CREATE USER IF NOT EXISTS 'mvcapp'@'localhost' IDENTIFIED BY '';

GRANT ALL PRIVILEGES ON mvc_crud.* TO 'mvcapp'@'localhost';

FLUSH PRIVILEGES;

USE mvc_crud;

--DROP TABLE IF EXISTS cliente;

CREATE TABLE cliente(
	id int(11) primary key auto_increment,
    nombre varchar(32),
    email varchar(100)
);
