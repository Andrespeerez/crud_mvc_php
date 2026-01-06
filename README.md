<a id="readme-top"></a>

# CRUD MVC PHP

## DESCRIPCIÓN DEL PROYECTO

Aplicación web desarrollada en PHP que implementa el patrón Modelo-Vista-Controlador (MVC) para la gestión completa de clientes y facturas

Desarrollada dentro de la asignatura de Desarrollo de Aplicaciones en entorno Servidor.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## FUNCIONALIDADES

- [x] Crear, leer, actualizar y eliminar Clientes, Facturas, Líneas Factura y Artículos
- [x] Separación de lógica en tres capas: Presentación, Modelo y Controlador
- [x] Enrutamiento sencillo mendiante parámetros en URL (c=controlador, m=método)
- [ ] Implementar seguridad básica como:
  - [x] Consultas seguras a base de datos mediante PreparedStatements
  - [x] Escape de salida mediante htmlspecialchars()
  - [ ] Añadir tokens en formularios para evitar CSRF
  - [ ] Añadir cabeceras para impedir que se reproduzca en iFrames, etc.
- [x] Documentación empleando PHPDocs
- [ ] Proteger las rutas por Autentificación y Roles

Muchas de las funcionalidades faltantes se han soventado al implementarlo en laravel (otro proyecto). 

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## REQUISITOS PREVIOS

- PHP >= 8.0
- PDO y PDO_MYSQL
- MySQL / MariaDB
- Servidor Apache / Nginx / etc.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## INSTALACIÓN

1. Clonar el repositorio:

```zsh
git clone https://github.com/Andrespeerez/crud_mvc_php.git
```

2. Configura datos necesarios:

El archivo `config.php` contiene los datos necesarios para la conexión con base de datos, así como la dirección raíz del proyecto dentro del servidor. 

3. Crear el servidor:

Como ejemplo, vamos a plantearlo para un docker con apache:

Instalar un stack con Apache + PHP + MySQL

### docker-compose.yml
```yml
services:
    web:
        build: .
        ports:
            - "8080:80"
        volumes:
            - ./mvc:/var/www/html
        depends_on:
            - db
    
    db:
        image: mysql:8.0
        environment:
            MYSQL_ROOT_PASSWORD: changeme
            MYSQL_DATABASE: mvc_crud
            MYSQL_USER: mvcapp
            MYSQL_PASSWORD: 
        volumes:
            - db_data: /var/lib/mysql
    
    volumes:
        db_data:
```

### Dockerfile
```dockerfile
FROM php:8.3-apache
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
WORKDIR /var/www/html
```

El contenido de este repositorio va dentro del directorio de trabajo `/var/www/html/`

<p align="right">(<a href="#readme-top">back to top</a>)</p>

4. Construye las tablas:

Las tablas están definidas en la carpeta `sql/`. Si fuera necesario, configura el docker para que cuando se cree el servicio inicie también la creación de las tablas

## ESTRUCTURA DEL PROYECTO

```
/
|--- controller/                            # Controladores de la aplicación
|    |-- app.controlador.php
|    |-- cliente.controlador.php
|    |-- factura.controlador.php
|    |-- lineafactura.controlador.php
|    |-- articulo.controlador.php
|
|--- model/                                 # Capa de persistencia
|    |--- bd/
|    |    |-- bd.php                        # Conexión con Base de Datos
|    |
|    |-- cliente.modelo.php
|    |-- factura.modelo.php
|    |-- lineafactura.modelo.php
|    |-- articulo.modelo.php
|
|--- view/                                  # Vistas
|    |--- layout/                           # Plantillas generales reutilizables
|    |    |-- footer.php
|    |    |-- header.php
|    |    |-- menu.php
|    |
|    |--- cliente/                          # Vistas del cliente
|    |    |-- cliente.editar.php
|    |    |-- cliente.index.php
|    |    |-- cliente.nuevo.php
|    |
|    |--- factura/                          # Vistas de factura
|    |    |-- factura.nuevo.php
|    |    |-- factura.nuevo.php
|    |    |-- factura.nuevo.php
|    |
|    |--- lineafactura/                     # Vistas del lineafatura
|    |    |-- lineafactura.nuevo.php
|    |    |-- lineafactura.nuevo.php
|    |    |-- lineafactura.nuevo.php
|    |
|    |--- articulo/                         # Vistas de artículo
|    |    |-- articulo.nuevo.php
|    |    |-- articulo.nuevo.php
|    |    |-- articulo.nuevo.php
|    |
|    |-- app.php                            # Vista de página principal
|    |-- error.php                          # Vista para mostrar errores
|
|--- pdfs/                                  # Servicios para mostrar tablas exportadas a PDFs 
|    |-- clientespdf.php
|    |-- facturapdf.php
|    |-- mc_table.php
|
|--- docs/                                  # Documentación generada por PHPDocumentor (Reto 3.1)
|    |-- .build/index.html
|
|-- config.php                              # Configuración del proyecto
|-- index.php                               # Archivo de entrada (Enrutador)
```

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## ACCESO

Acceso mediante [http://localhost:8080/index.php](http://localhost:8080/index.php)

Enrutamiento mediante los parámetros `c` (controlador) y `m` (método)

- `c` : `cliente`, `factura`, `lineafactura`, `articulo`
- `m` : `index`, `editar`, `nuevo`, `borrar`
    - `insertar`, `modificar` <-- SOLO PETICIONES POST

Ejemplos:

http://localhost:8080/index.php?c=cliente                   # Equivalente a c=cliente&m=index

http://localhost:8080/index.php?c=cliente&m=nuevo

http://localhost:8080/index.php?c=cliente&m=editar&id=1     # Editar cliente con Id=1

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## CONTRIBUCIÓN

Este proyecto se ha desarrollado con objetivo de aprendizaje Formación Profesional DAW.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

## AUTORÍA

Andrés Pérez Guardiola

AndresPeerez (GitHub)

<p align="right">(<a href="#readme-top">back to top</a>)</p>
