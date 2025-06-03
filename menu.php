<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include_once("modelo/Menu.php");
?>

<nav>
    <ul>
        <?php if (!Menu::usuarioAutenticado()): ?>
            <li><a href="index.php">Inicio</a></li>
        <?php endif; ?>

        <?php if (Menu::usuarioAutenticado()): ?>
            <li><a href="mybooks.php">Mis Libros</a></li>
            <li><a href="eventos.php">Eventos</a></li>
            <li><a href="comentarios.php">Foro</a></li>

            <?php if (Menu::rolEsAdmin()): ?>
                <li><a href="crudU.php">Gestionar Usuarios</a></li>
            <?php endif; ?>
        <?php endif; ?>

        <li><a href="contacto.php">Contacto</a></li>
    </ul>
</nav>

<?php if (Menu::usuarioAutenticado()): ?>
    <a href="logout.php" class="btn-green">Cerrar Sesión</a>
<?php else: ?>
    <a href="sesion.php" class="btn-green">Iniciar Sesión</a>
<?php endif; ?>

</header>
<div class="content-wrapper">
<main>
