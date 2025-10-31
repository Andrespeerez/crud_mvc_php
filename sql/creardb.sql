CREATE DATABASE mvc_crud;

CREATE USER IF NOT EXISTS 'mvcapp'@'localhost' IDENTIFIED BY '';

GRANT ALL PRIVILEGES ON mvc_crud.* TO 'mvcapp'@'localhost';

FLUSH PRIVILEGES;

USE mvc_crud;

DROP TABLE IF EXISTS cliente;

CREATE TABLE cliente(
	id int(11) primary key auto_increment,
    email varchar(100) unique not null,
    contrasena varchar(255) not null,
    nombre varchar(32),
    apellidos varchar(100),
    direccion varchar(100),
    poblacion varchar(32),
    provincia varchar(32),
    fecha_nacimiento datetime
);
