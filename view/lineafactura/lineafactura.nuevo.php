<?php 
/**
 * *VISTA LINEA FACTURA NUEVO*
 * 
 * *DESCRIPCIÓN*
 * Formulario de FACTURA nuevo
 * 
 * El formulario envía al enrutador index.php?c=linea_factura&m=nuevo
 * el controlador FacturaControlador ejecuta insertar()
 * el modelo LineaFacturaModelo ejecuta 
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */
require("view/layout/header.php"); 
?>

<h1>LINEA FACTURA</h1>

<br>

<h2>NUEVA LINEA FACTURA</h2>

<form action="<?= URLSITE . 'index.php?c=linea_factura&m=insertar&factura_id=' . $_GET['factura_id'] ?>" method="post">


    <?php
    if ($facturas !== null && count($facturas) > 0) :
    ?>

        <label for="descripcion" class="form-label">Descripción</label>
        <input type="text" class="form-control" name="descripcion" id="descripcion" require>

        <label for="cantidad" class="form-label">Cantidad</label>
        <input type="number" class="form-control" name="cantidad" id="cantidad" step="any" require>

        <label for="precio" class="form-label">Precio</label>
        <input type="number" class="form-control" name="precio" id="precio" step="any" require>

        <label for="iva" class="form-label">IVA</label>
        <input type="number" class="form-control" name="iva" id="iva" step="any" require>

        <br>
        <button type="submit" class="btn btn-primary">Aceptar</button>
    <?php else: ?>
        <p>La factura no existe</p>
    <?php endif; ?>

    <a href="<?= URLSITE . 'index.php?c=linea_factura&factura_id=' . $_GET['factura_id'] ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>

</form>

<?php require("view/layout/footer.php"); ?>