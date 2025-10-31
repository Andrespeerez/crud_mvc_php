<?php 
/**
 * *VISTA CLIENTE NUEVO*
 * 
 * *DESCRIPCIÓN*
 * Formulario de cliente nuevo
 * 
 * El formulario envía al enrutador index.php?c=cliente&m=nuevo
 * el controlador ClienteControlador ejecuta insertar()
 * el modelo ClienteModelo ejecuta 
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */

require("view/layout/header.php");

?>

<h1>CLIENTES</h1>

<br>

<h2>NUEVO CLIENTE</h2>



<form action="<?= URLSITE . 'index.php?c=cliente&m=insertar' ?>" 
      method="post">

    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" maxlength="100" required>

    <label for="contrasena" class="form-label">Contraseña</label>
    <input type="password" name="contrasena" id="contrasena" class="form-control" maxlength="255" required>

    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control" maxlength="32">

    <label for="apellidos" class="form-label">Apellidos</label>
    <input type="text" name="apellidos" id="apellidos" class="form-control" maxlength="100">

    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" name="direccion" id="direccion" class="form-control" maxlength="100">

    <label for="poblacion" class="form-label">Población</label>
    <input type="text" name="poblacion" id="poblacion" class="form-control" maxlength="32">

    <label for="provincia" class="form-label">Provincia</label>
    <input type="text" name="provincia" id="provincia" class="form-control" maxlength="32">

    <label for="fecha_nacimiento" class="form-label">Fecha Nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">

    <br>
    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?= URLSITE . 'index.php?c=cliente' ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>
</form>

<?php require("view/layout/footer.php"); ?>