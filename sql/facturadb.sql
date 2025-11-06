USE mvc_crud;

-- DROP TABLE IF EXISTS factura;

CREATE TABLE factura(
	id int(11) primary key auto_increment,
    cliente_id int(11),
    numero int(11),
    fecha datetime,

    CONSTRAINT factura_cliente_id_fk FOREIGN KEY (cliente_id) REFERENCES cliente(id)
);