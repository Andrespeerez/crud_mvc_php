USE mvc_crud;

-- DROP TABLE IF EXISTS lineas_factura;

CREATE TABLE lineas_factura(
	id int(11) primary key auto_increment,
    factura_id int(11),
    referencia int(11),
    descripcion datetime,  -- tiene que estar mal
    cantidad decimal(10,3),
    precio decimal(10,2),
    iva decimal(5,2),
    importe decimal(10,2),

    FOREIGN KEY lineas_factura_factura_id_fk REFERENCES factura(id)
);