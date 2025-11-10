<?php 
/**
 * *VISTA FACTURA NUEVO*
 * 
 * *DESCRIPCIÓN*
 * Formulario de FACTURA nuevo
 * 
 * El formulario envía al enrutador index.php?c=factura&m=nuevo
 * el controlador FacturaControlador ejecuta insertar()
 * el modelo FacturaModelo ejecuta 
 * 
 * @author Andrés Pérez Guardiola 2º DAW Semi
 */
require("view/layout/header.php"); 
?>

<h1>FACTURAS</h1>

<br>

<h2>NUEVA FACTURA</h2>

<form action="<?= URLSITE . 'index.php?c=factura&m=insertar' ?>" method="post">

    
    <?php
    if ($clientes !== null && count($clientes) > 0) :
    ?>
        <label for="cliente_id" class="form-label">Cliente</label>
        <select class="form-select" aria-label="Default select example" name="cliente_id" id="cliente_id" required>
            <option selected>Selecciona un cliente</option>
            <?php
                foreach($clientes as $c):
            ?>
            <option value="<?= (int) $c->id ?>"><?= htmlspecialchars($c->nombre) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha" id="fecha">

        <br>
        <button type="submit" class="btn btn-primary">Aceptar</button>
    <?php else: ?>
        <p>No hay ningún cliente en la aplicación</p>
    <?php endif; ?>
    <a href="<?= URLSITE . 'index.php?c=factura' ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>
</form>

<?php require("view/layout/footer.php"); ?>