<?php require("view/layout/header.php"); ?>

<h1>FACTURAS</h1>

<br>

<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>Nombre Cliente</th>
            <th>Número</th>
            <th>Fecha</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($factura->filas) :
            foreach ($factura->filas as $fila):
        ?>
        <tr class="text-center">
            <td style="text-align: right; width: 5%;"><?= htmlspecialchars($fila->id) ?></td>
            <td><?= htmlspecialchars($fila->nombre_cliente) ?></td>
            <td><?= htmlspecialchars($fila->numero) ?></td>
            <td><?php 
                $fecha = date_create($fila->fecha);
                echo htmlspecialchars(date_format($fecha, 'd-m-Y'));
            ?></td>
            <td>
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
            <td colspan="5">
                <a href="<?= URLSITE . 'index.php?c=factura&m=nuevo' ?>">
                    <button type="button" class="btn btn-primary">
                        Nuevo
                    </button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>

<?php require("view/layout/footer.php"); ?>