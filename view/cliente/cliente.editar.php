<?php require("view/layout/header.php");?>

<h1>CLIENTES</h1>

<br>

<h2>EDITAR CLIENTE</h2>

<form action="<?= URLSITE . 'index.php?c=cliente&m=modificar&id=' . $cliente->getId() ?>" 
      method="post">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control" maxlength="32" value="<?= htmlspecialchars($cliente->getNombre()) ?>" required>
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control" maxlength="100" value="<?= htmlspecialchars($cliente->getEmail()) ?>" required>
    <br>
    <button type="submit" class="btn btn-primary">Aceptar</button>
    <a href="<?= URLSITE . 'index.php?c=cliente' ?>">
        <button type="button" class="btn btn-outline-secondary float end">Cancelar</button>
    </a>
</form>

<?php require("view/layout/footer.php"); ?>