USE mvc_crud;

-- DROP TABLE IF EXISTS articulo;

CREATE TABLE articulo(
    id int(11) primary key auto_increment,
    referencia varchar(5),
    descripcion varchar(50),
    precio decimal(10,2),
    iva decimal(5,2)
);