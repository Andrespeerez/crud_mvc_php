CREATE DATABASE mvc_crud;

CREATE USER IF NOT EXISTS 'mvcapp'@'localhost' IDENTIFIED BY '';

GRANT ALL PRIVILEGES ON mvc_crud.* TO 'mvcapp'@'localhost';

FLUSH PRIVILEGES;




