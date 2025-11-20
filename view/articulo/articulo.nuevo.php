<?php require("view/layout/header.php");?>

<h1>ARTÍCULO</h1>

<br>

<h2>NUEVO ARTÍCULO</h2>

<form action="<?= URLSITE . 'index.php?c=articulo&m=insertar' ?>" method="post">

    <label for="referencia" class="form-label">Referencia</label>
    <input type="text" name="referencia" id="referencia" class="form-control" maxlength="5" required>

    <label for="descripcion" class="form-label">Descripción</label>
    <input type="text" name="descripcion" id="descripcion" class="form-control" maxlength="50" required>

    <label for="precio" class="form-label">Precio</label>
    <input type="number" name="precio" id="precio" class="form-control" min="0" step=".01" required>

    <label for="iva" class="form-label">Iva</label>
    <input type="number" name="iva" id="iva" class="form-control" min="0" step=".01" required>

    <br>
    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?= URLSITE . 'index.php?c=articulo' ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>

</form>