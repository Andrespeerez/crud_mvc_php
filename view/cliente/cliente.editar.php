<?php require("view/layout/header.php");?>

<h1>CLIENTES</h1>

<br>

<h2>EDITAR CLIENTE</h2>

<form action="<?= URLSITE . 'index.php?c=cliente&m=modificar&id=' . $cliente->getId() ?>" 
      method="post">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control" maxlength="32" 
    value="<?= htmlspecialchars($cliente->getNombre()) ?>" required>

    <label for="apellidos" class="form-label">Apellidos</label>
    <input type="text" name="apellidos" id="apellidos" class="form-control" maxlength="100" 
    value="<?= htmlspecialchars($cliente->getApellidos()) ?>" required>

    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" name="direccion" id="direccion" class="form-control" maxlength="100" 
    value="<?= htmlspecialchars($cliente->getDireccion()) ?>" required>

    <label for="poblacion" class="form-label">Población</label>
    <input type="text" name="poblacion" id="poblacion" class="form-control" maxlength="32" 
    value="<?= htmlspecialchars($cliente->getPoblacion()) ?>" required>

    <label for="provincia" class="form-label">Provincia</label>
    <input type="text" name="provincia" id="provincia" class="form-control" maxlength="32" 
    value="<?= htmlspecialchars($cliente->getProvincia()) ?>" required>
    
    <label for="fecha_nacimiento" class="form-label">Fecha nacimiento</label>
    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"  
    value="<?= htmlspecialchars($cliente->getFechaNacimiento()->format('Y-m-d')) ?>" required>

    <br>
    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?= URLSITE . 'index.php?c=cliente' ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>
</form>

<?php require("view/layout/footer.php"); ?>