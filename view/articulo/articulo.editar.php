<?php require_once("view/layout/header.php");?>

<h1>ARTÍCULOS</h1>

<br>

<h2>EDITAR ARTÍCULO</h2>

<form action="<?= URLSITE . "index.php?c=articulo&m=modificar&id=" . $articulo->id ?>" method="post">
    <label for="referencia"  class="form-label">Referencia</label>
    <input type="text" name="referencia" id="referencia" maxlength="5" class="form-control" required value="<?= htmlspecialchars($articulo->referencia) ?>">

    <label for="descripcion" class="form-label">Descripción</label>
    <input type="text" name="descripcion" id="descripcion" maxlength="50" class="form-control" required value="<?= htmlspecialchars($articulo->descripcion) ?>">

    <label for="precio" class="form-label">Precio</label>
    <input type="number" name="precio" id="precio" min="0" step=".01" class="form-control" required value="<?= htmlspecialchars($articulo->precio) ?>">

    <label for="iva" class="form-label">IVA</label>
    <input type="number" name="iva" id="iva" min="0" step=".01" class="form-control" required value="<?= htmlspecialchars($articulo->iva) ?>">

    <br>
    <button type="submit" class="btn btn-primary">Aceptar</button>

    <a href="<?= URLSITE . 'index.php?c=articulo' ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>

</form>

<?php require_once("view/layout/footer.php");?>