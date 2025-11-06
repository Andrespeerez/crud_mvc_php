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


echo "<p>{$lineafactura->getId()}</p>";
?>

<h1>LINEA FACTURA</h1>

<br>

<h2>EDITAR LINEA FACTURA</h2>

<form action="<?= URLSITE . 'index.php?c=linea_factura&m=modificar&id=' . $lineafactura->getId() . '&factura_id=' . $_GET['factura_id'] ?>" method="post">


    <label for="descripcion" class="form-label">Descripción</label>
    <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?= $lineafactura->getDescripcion() ?>" require>

    <label for="cantidad" class="form-label">Cantidad</label>
    <input type="number" class="form-control" name="cantidad" id="cantidad" step="any" value="<?= htmlspecialchars($lineafactura->getCantidad()) ?>" require>

    <label for="precio" class="form-label">Precio</label>
    <input type="number" class="form-control" name="precio" id="precio" step="any" value="<?= htmlspecialchars($lineafactura->getPrecio()) ?>" require>

    <label for="iva" class="form-label">IVA</label>
    <input type="number" class="form-control" name="iva" id="iva" step="any" value="<?= htmlspecialchars($lineafactura->getIva()) ?>" require>

    <br>
    <button type="submit" class="btn btn-primary">Aceptar</button>

    <a href="<?= URLSITE . 'index.php?c=linea_factura&factura_id=' . $_GET['factura_id'] ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>

</form>

<?php require("view/layout/footer.php"); ?>