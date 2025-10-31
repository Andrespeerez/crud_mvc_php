<?php require("view/layout/header.php"); ?>

<h1>CLIENTES</h1>

<br>

<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>Nombre</th>
            <th>Email</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($cliente->filas) :
            foreach ($cliente->filas as $fila) :
        ?>
        <tr>
            <td style="text-align: right; width: 5%;"><?= htmlspecialchars($fila->id) ?></td>
            <td><?= htmlspecialchars($fila->nombre) ?></td>
            <td><?= htmlspecialchars($fila->email) ?></td>
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
            </td>
        </tr>
        <?php 
            endforeach;
        else:   
        ?>
        <tr>
            <td colspan="4">No hay clientes</td>
        </tr>
        <?php 
        endif;
        ?>
        <tfoot>
            <tr>
                <td colspan="4">
                    <a href="<?= URLSITE . '?c=cliente&m=nuevo' ?>">
                        <button type="button" class="btn btn-primary">
                            Nuevo
                        </button>
                    </a>
                </td>
            </tr>
        </tfoot>
    </tbody>
</table>

<?php require("view/layout/footer.php"); ?>