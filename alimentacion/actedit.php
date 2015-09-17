<?php
@require ("main_valida.php");

$idind_secretaria 	= $_POST['idind_secretaria'];
$idindicador 		= $_POST['idindicador'];

$tema 				= $_POST['tema'];
$unidad 			= $_POST['unidad'];
$descripcion 		= $_POST['descripcion'];
$metodologia 		= $_POST['metodologia'];
$tendencia 			= $_POST['tendencia'];
$procedencia 		= $_POST['procedencia'];
$fuente 			= $_POST['fuente'];
$palabras 			= $_POST['palabras'];
$notas 				= $_POST['notas'];
$recoleccion 		= $_POST['recoleccion'];


$sql="UPDATE indicadores_secretarias
	SET idtema_elemental = $tema,
	idunidad_medida = $unidad,
	descripcion ='$descripcion',
	metodologia = '$metodologia',
	idtendencia = $tendencia, 
	idprocedencia = $procedencia,
	fuente = '$fuente', 
	palabra = '$palabras', 
	notas = '$notas',
	idmet_recoleccion = $recoleccion
	WHERE idind_secretaria = '$idind_secretaria'";
	 $result = $con->prepare($sql);
	 $result->execute();

die("ok:::La información se actualizo correctamente");
?>