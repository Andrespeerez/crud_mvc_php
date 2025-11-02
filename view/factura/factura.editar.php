<?php 
/**
 * *VISTA EDITAR FACTURA*
 * 
 * *DESCRIPCIÓN*
 * Vista de edición de factura
 * 
 * @author Andrés Pérez Guardiola
 */
require("view/layout/header.php")
?>

<h1>FACTURAS</h1>

<br>

<h2>NUEVA EDITAR</h2>

<form action="<?= URLSITE . "index.php?c=factura&m=modificar&id=" . $factura->getId() ?>" method="post">
    <label for="cliente_id" class="form-label">Id Cliente</label>
    <input type="number" class="form-control" name="cliente_id" id="cliente_id" value="<?= $factura->getClienteId() ?>">

    <label for="numero" class="form-label">Número</label>
    <input type="number" class="form-control" name="numero" id="numero" value="<?= $factura->getNumero() ?>">

    <label for="fecha" class="form-label">Fecha</label>
    <input type="date" class="form-control" name="fecha" id="fecha" value="<?= $factura->getFecha()->format('Y-m-d') ?>">

    <br>
    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?= URLSITE . "index.php?c=factura" ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>
</form>

<?php require("view/layout/footer.php"); ?>