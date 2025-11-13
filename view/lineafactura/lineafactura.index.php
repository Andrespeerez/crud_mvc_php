<?php 
/**
 * *VISTA LINEA FACTURA*
 * 
 * *DESCRIPCIÓN*
 * Para una factura dada, podemos ver las lineas factura
 * 
 * @author Andrés Pérez Guardiola
 */

require("view/layout/header.php");

$factura_id = (int) $_GET['factura_id'];

/**
 * Comprueba si se le ha pasado parámetro cliente_id
 * 
 * @var bool Ha recibido parámetro cliente_id?
 */
$hasClienteId = isset($_GET['cliente_id']);
if ($hasClienteId)
{
    $cliente_id = $_GET['cliente_id'];
}

?>

<h1>Línea Factura</h1>

<br>

<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>ID Factura</th>
            <th>Referencia</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>IVA</th>
            <th>Importe</th>
            <th></th>
        </tr>
    </thead>
    <tbody class="text-center">
        <?php 
        if ($lineasFactura) :
            foreach ($lineasFactura as $fila):
        ?>
        <tr>
            <td style="text-align: right; width: 5%;"><?= htmlspecialchars($fila->id) ?></td>
            <td><?= htmlspecialchars($factura_id ) ?></td>
            <td><?= htmlspecialchars($fila->referencia) ?></td>
            <td><?= htmlspecialchars($fila->descripcion) ?></td>
            <td><?= htmlspecialchars($fila->cantidad) ?></td>
            <td><?= htmlspecialchars($fila->precio) ?></td>
            <td><?= htmlspecialchars($fila->iva) ?></td>
            <td><?= htmlspecialchars($fila->importe) ?></td>
            <td>
                <?php if ($hasClienteId): ?>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&m=editar&id=' . $fila->id . "&factura_id=" . $factura_id . '&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-success">
                            Editar
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&m=borrar&id=' . $fila->id . "&factura_id=" . $factura_id . '&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-danger" onclick="return confirm('¿Estás seguro de borrar el registro?');">
                            Borrar
                        </button>
                    </a>
                <?php else: ?>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&m=editar&id=' . $fila->id . "&factura_id=" . $factura_id ?>">
                        <button type="button" class="btn btn-success">
                            Editar
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&m=borrar&id=' . $fila->id . "&factura_id=" . $factura_id  ?>">
                        <button type="button" class="btn btn-danger" onclick="return confirm('¿Estás seguro de borrar el registro?');">
                            Borrar
                        </button>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            endforeach;
        else:
        ?>
        <tr>
            <td colspan="9">No hay lineas factura</td>
        </tr>
        <?php 
        endif;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9">
                <?php if ($hasClienteId): ?>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&m=nuevo&factura_id=' . $factura_id . '&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-primary">
                            Nuevo
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=factura&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-secondary">
                            Volver
                        </button>
                    </a>
                <?php else: ?>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&m=nuevo&factura_id=' . $factura_id ?>">
                        <button type="button" class="btn btn-primary">
                            Nuevo
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=factura' ?>">
                        <button type="button" class="btn btn-secondary">
                            Volver
                        </button>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
    </tfoot>
</table>

<?php require("view/layout/footer.php");?>