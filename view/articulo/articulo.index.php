<?php require("view/layout/header.php"); ?>

<h1>Artículos</h1>

<table class="table table-striped table-hover" id="tabla">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            <th>Referencia</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>IVA</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($articulos) :
            foreach ($articulos as $articulo) :
        ?>
        <tr class="text-center">
            <td style="text-align: right; width: 5%;"><?= htmlspecialchars($articulo->id) ?></td>
            <td><?= htmlspecialchars($articulo->referencia) ?></td>
            <td><?= htmlspecialchars($articulo->descripcion) ?></td>
            <td><?= htmlspecialchars($articulo->precio) ?></td>
            <td><?= htmlspecialchars($articulo->iva) ?></td>
            <td>
                <a href="<?= URLSITE . 'index.php?c=articulo&m=editar&id=' . $articulo->id ?>">
                    <button type="button" class="btn btn-success">
                        Editar
                    </button>
                </a>
                <a href="<?= URLSITE . 'index.php?c=articulo&m=borrar&id=' . $articulo->id ?>">
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
            <td colspan="6" class="text-center">No hay artículos</td>
        </tr>
        <?php 
        endif;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                <a href="<?= URLSITE . '?c=articulo&m=nuevo' ?>">
                    <button type="button" class="btn btn-primary">
                        Nuevo
                    </button>
                </a>
            </td>
        </tr>
    </tfoot>
</table>

<?php require_once("view/layout/footer.php");?>