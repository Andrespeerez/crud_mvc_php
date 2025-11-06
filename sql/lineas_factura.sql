USE mvc_crud;

-- DROP TABLE IF EXISTS lineas_factura;

CREATE TABLE lineas_factura(
	id int(11) primary key auto_increment,
    factura_id int(11),
    referencia int(11),
    descripcion varchar(32),  
    cantidad decimal(10,3),
    precio decimal(10,2),
    iva decimal(5,2),
    importe decimal(10,2),

    CONSTRAINT lineas_factura_factura_id_fk FOREIGN KEY (factura_id) REFERENCES factura(id)
);