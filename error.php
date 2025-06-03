<?php
// Archivo:  error.php
// Objetivo: Manejo de errores
// Autor: 
?>

<?php
include_once("cabecera.html");
include_once("menu.php");
include_once("aside.php");
?>
        <section>
			<h1>Error</h1>
			<h4><?php echo((isset($_REQUEST["sError"]))? $_REQUEST["sError"]: "Otro error"); ?></h4>
			<?php
				if (isset($_SESSION["oUsu"])){
			?>
				<a href="inicio.php">Regresar al inicio</a>
			<?php
				}else{
			?>
				<a href="index.php">Regresar al inicio</a>
			<?php
				}
			?>
		</section>
<?php
include_once("pie.html");
?>