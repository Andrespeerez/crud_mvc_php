<?php 
/**
 * *VISTA FACTURA*
 * 
 * *DESCRIPCIÓN*
 * SI recibe parámetro GET 'cliente_id', muestra solo las facturas de dicho cliente
 * SI no recibe parámetro GET 'cliente_id', muestra todas las facturas
 * 
 * Crear nuevo o editar propaga el parámetro cliente_id
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

<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>Nombre Cliente</th>
            <th>Número</th>
            <th>Fecha</th>
            <th>Base</th>
            <th>Importe</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($facturas) :
            foreach ($facturas as $fila):
        ?>
        <tr class="text-center">
            <td style="text-align: right; width: 5%;"><?= htmlspecialchars($fila->id) ?></td>
            <td><?= htmlspecialchars($fila->nombre_cliente) ?></td>
            <td><?= htmlspecialchars($fila->numero) ?></td>
            <td><?php 
                $fecha = date_create($fila->fecha);
                echo htmlspecialchars(date_format($fecha, 'd-m-Y'));
            ?></td>
            <td style="text-align: right;"><?= htmlspecialchars($fila->base) . ' €' ?></td>
            <td style="text-align: right;"><?= htmlspecialchars($fila->importe) . ' €' ?></td>
            <td>
                <?php if (isset($cliente_id)):?>
                    <a href="<?= URLSITE . 'index.php?c=factura&m=editar&id=' . $fila->id . '&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-success">
                            Editar
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=factura&m=borrar&id=' . $fila->id . '&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-danger" onclick="return confirm('¿Estás seguro de borrar el registro?');">
                            Borrar
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&factura_id=' . $fila->id . '&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-warning">
                            Ver Lineas Factura
                        </button>
                    </a>
                <?php else:?>
                    <a href="<?= URLSITE . 'index.php?c=factura&m=editar&id=' . $fila->id ?>">
                        <button type="button" class="btn btn-success">
                            Editar
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=factura&m=borrar&id=' . $fila->id ?>">
                        <button type="button" class="btn btn-danger" onclick="return confirm('¿Estás seguro de borrar el registro?');">
                            Borrar
                        </button>
                    </a>
                    <a href="<?= URLSITE . 'index.php?c=linea_factura&factura_id=' . $fila->id ?>">
                        <button type="button" class="btn btn-warning">
                            Ver Lineas Factura
                        </button>
                    </a>
                <?php endif;?>

            </td>
        </tr>
        <?php 
            endforeach;
        else:
        ?>
        <tr>
            <td colspan="5">No hay facturas</td>
        </tr>
        <?php 
        endif;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7">
                <?php if (isset($cliente_id)):?>
                    <a href="<?= URLSITE . 'index.php?c=factura&m=nuevo&cliente_id=' . $cliente_id ?>">
                        <button type="button" class="btn btn-primary">
                            Nuevo
                        </button>
                    </a>
                <?php else:?>
                    <a href="<?= URLSITE . 'index.php?c=factura&m=nuevo' ?>">
                        <button type="button" class="btn btn-primary">
                            Nuevo
                        </button>
                    </a>
                <?php endif;?>
            </td>
        </tr>
    </tfoot>
</table>

<?php require("view/layout/footer.php"); ?>