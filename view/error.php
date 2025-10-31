<?php 
require_once('../config.php');

if (session_status() == PHP_SESSION_NONE)
{
    session_start();
}
?>

<?php require('./layout/header.php'); ?>

<h1>ERROR</h1>

<p>Se ha producido un error Inesperado</p>

<p><?= $_SESSION['CRUDMVC_ERROR'] ?></p>

<button type="button" class="btn btn-primary" onclick="window.history.back()">
    Volver
</button>


<?php require('./layout/footer.php'); ?>