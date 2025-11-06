<?php 
/**
 * *VISTA EDITAR FACTURA*
 * 
 * *DESCRIPCIÓN*
 * Vista de edición de factura
 * 
 * @author Andrés Pérez Guardiola
 */
require("view/layout/header.php")
?>

<h1>FACTURAS</h1>

<br>

<h2>EDITAR FACTURA</h2>

<form action="<?= URLSITE . "index.php?c=factura&m=modificar&id=" . $factura->getId() ?>" method="post">

    <?php
    if ($clientes->filas !== null && count($clientes->filas) > 0) :

        // cliente actual
        $id_cliente = (int) $factura->getClienteId();

        $resultado  = array_filter($clientes->filas, function($fila) use ($id_cliente) {
            return $fila->id === $id_cliente;
        });
    ?>
        <label for="cliente_id" class="form-label">Cliente</label>
        <select class="form-select" aria-label="Default select example" name="cliente_id" id="cliente_id" required>
            <option value="<?= (int) $resultado[0]->id ?>" selected><?= htmlspecialchars($resultado[0]->nombre) ?></option>
            <?php
                foreach($clientes->filas as $c):
            ?>
            <option value="<?= (int) $c->id ?>"><?= htmlspecialchars($c->nombre) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="fecha" class="form-label">Fecha</label>
        <input type="date" class="form-control" name="fecha" id="fecha" value="<?= htmlspecialchars($factura->getFecha()->format('Y-m-d')) ?>">       

        <br>
        <button type="submit" class="btn btn-primary">Aceptar</button>
    <?php endif; ?>
    <a href="<?= URLSITE . "index.php?c=factura" ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>
</form>

<?php require("view/layout/footer.php"); ?>