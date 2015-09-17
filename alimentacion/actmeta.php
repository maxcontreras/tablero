<?php
session_start();
?>
<?php
@require ("main_valida.php");
$iduser = $_SESSION['usr'];

$idind_secretaria 	= $_POST['idind_secretaria'];
$anio 				= $_POST['anio'];
$valor 				= $_POST['valor'];



$sql="INSERT INTO metas (idind_secretaria, valor, anio, iduser) VALUES ($idind_secretaria, $valor,$anio, $iduser)";
	 $result = $con->prepare($sql);
	 $result->execute();


	echo"<script language=\"javascript\">
		document.location = 'meta.php?idind_secretaria=$idind_secretaria'; //recargar registro
	</script>";

?>