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

/**
 * Comprueba si se le ha pasado parámetro cliente_id
 * 
 * @var bool Ha recibido parámetro cliente_id?
 */
$hasClienteID = isset($_GET['cliente_id']);
if ($hasClienteID)
{
    $cliente_id = (int) $_GET['cliente_id']; // asigna el parámetro 
}
?>

<h1>FACTURAS</h1>

<br>

<h2>NUEVA FACTURA</h2>

<?php if ($hasClienteID):?>
    <form action="<?= URLSITE . 'index.php?c=factura&m=insertar&cliente_id=' . $cliente_id ?>" method="post">
<?php else: ?>
    <form action="<?= URLSITE . 'index.php?c=factura&m=insertar' ?>" method="post">
<?php endif; ?>

    
    <?php
    if ($clientes !== null && count($clientes) > 0) :
    ?>
        <label for="cliente_id" class="form-label">Cliente</label>
        <select class="form-select" aria-label="Default select example" name="cliente_id" id="cliente_id" required>
            <?php 
            // Si tiene Cliente ID, el dropdown ya tiene asignado un cliente por defecto
            if ($hasClienteID) :  ?>
                <?php
                    foreach($clientes as $c):
                        if ($c->id == $cliente_id): ?>
                            <option value="<?= (int) $c->id ?>" selected><?= htmlspecialchars($c->nombre) . ' ' . htmlspecialchars($c->apellidos) ?></option>
                        <?php else: ?>
                            <option value="<?= (int) $c->id ?>"><?= htmlspecialchars($c->nombre) . ' ' . htmlspecialchars($c->apellidos) ?></option>
                        <?php endif;?>
                <?php endforeach; ?>
            <?php else : ?>
                <option value="" disabled selected>Selecciona un cliente</option>
                <?php
                    foreach($clientes as $c):
                ?>
                    <option value="<?= (int) $c->id ?>"><?= htmlspecialchars($c->nombre) ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha" id="fecha">

        <br>
        <button type="submit" class="btn btn-primary">Aceptar</button>
    <?php else: ?>
        <p>No hay ningún cliente en la aplicación</p>
    <?php endif; ?>
    <?php 
    // Cancelar me devuelve a la vista de facturas del cliente
    if ($hasClienteID): ?>
        <a href="<?= URLSITE . 'index.php?c=factura&cliente_id=' . $cliente_id ?>">
            <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
        </a>
    <?php 
    // Cancelar me devuelve a la vista de todas las facturas
    else: ?>
        <a href="<?= URLSITE . 'index.php?c=factura' ?>">
            <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
        </a>
    <?php endif;?>
</form>

<?php require("view/layout/footer.php"); ?>