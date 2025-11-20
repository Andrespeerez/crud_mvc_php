<?php 
/**
 * *VISTA EDITAR FACTURA*
 * 
 * *DESCRIPCIÓN*
 * Vista de edición de factura
 * 
 * @author Andrés Pérez Guardiola
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

<h2>EDITAR FACTURA</h2>

<?php if ($hasClienteID):?>
    <form action="<?= URLSITE . "index.php?c=factura&m=modificar&id=" . $facturas[0]->id . '&cliente_id=' . $cliente_id?>" method="post">
<?php else: ?>
    <form action="<?= URLSITE . "index.php?c=factura&m=modificar&id=" . $facturas[0]->id ?>" method="post">
<?php endif; ?>

        <label for="cliente_id" class="form-label">Cliente</label>
        <select class="form-select" aria-label="Default select example" name="cliente_id" id="cliente_id" required>
            <?php foreach($clientes as $c): ?>
                <?php if ($c->id == $cliente_id): ?>
                    <option value="<?= (int) $cliente_id ?>" selected><?= htmlspecialchars($c->nombre_cliente) ?></option>
                <?php else: ?>
                    <option value="<?= (int) $c->id ?>"><?= htmlspecialchars($c->nombre_cliente) ?></option>
                <?php endif;?>
            <?php endforeach; ?>
        </select>

        <label for="fecha" class="form-label">Fecha</label>
        <?php 
        if (! $facturas[0]->fecha == null)
        {
            $fecha = new DateTime($facturas[0]->fecha);
            $fechaString = $fecha->format("Y-m-d");
        }
            
        ?>
        <input type="date" class="form-control" name="fecha" id="fecha" value="<?= htmlspecialchars($fechaString) ?>">       

        <br>
        <button type="submit" class="btn btn-primary">Aceptar</button>

    
        <?php 
        // Cancelar me devuelve a la vista de las facturas del cliente
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