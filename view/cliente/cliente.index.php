<?php require("view/layout/header.php"); ?>

<h1>CLIENTES</h1>

<br>

<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>Población</th>
            <th>Provincia</th>
            <th>Fecha Nacimiento</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($clientes) :
            foreach ($clientes as $fila) :
        ?>
        <tr class="text-center">
            <td style="text-align: right; width: 5%;"><?= htmlspecialchars($fila->id) ?></td>
            <td><?= htmlspecialchars($fila->nombre) ?></td>
            <td><?= htmlspecialchars($fila->apellidos) ?></td>
            <td><?= htmlspecialchars($fila->email) ?></td>
            <td><?= htmlspecialchars($fila->direccion) ?></td>
            <td><?= htmlspecialchars($fila->poblacion) ?></td>
            <td><?= htmlspecialchars($fila->provincia) ?></td>
            <td><?= htmlspecialchars($fila->fecha_nacimiento) ?></td>
            <td>
                <a href="<?= URLSITE . 'index.php?c=cliente&m=editar&id=' . $fila->id ?>">
                    <button type="button" class="btn btn-success">
                        Editar
                    </button>
                </a>
                <a href="<?= URLSITE . 'index.php?c=cliente&m=borrar&id=' . $fila->id ?>">
                    <button type="button" class="btn btn-danger"
                            onclick="return confirm('¿Estás seguro de borrar el registro?')">
                            Borrar
                    </button>
                </a>
                <a href="<?= URLSITE . 'index.php?c=factura&cliente_id=' . $fila->id ?>">
                    <button type="button" class="btn btn-primary">
                            Ver Facturas
                    </button>
                </a>
            </td>
        </tr>
        <?php 
            endforeach;
        else:   
        ?>
        <tr>
            <td colspan="10" class="text-center">No hay clientes</td>
        </tr>
        <?php 
        endif;
        ?>
        <tfoot>
            <tr>
                <td colspan="9">
                    <a href="<?= URLSITE . '?c=cliente&m=nuevo' ?>">
                        <button type="button" class="btn btn-primary">
                            Nuevo
                        </button>
                    </a>

                    <a href="index.php?c=cliente&m=exportar">
                        <button type="button" class="btn btn-success">Exportar</button>
                    </a>

                    <a href="index.php?c=cliente&m=imprimir" target="_blank">
                        <button type="button" class="btn btn-warning">Imprimir</button>
                    </a>
                </td>
            </tr>
        </tfoot>
    </tbody>
</table>

<?php require("view/layout/footer.php"); ?>