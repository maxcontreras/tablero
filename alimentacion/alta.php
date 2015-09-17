<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<link rel="stylesheet" type="text/css" href="../css/layouts.css">
<?php
@require ("main_valida.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$iduser = $_SESSION['usr'];
$idind_secretaria = $_GET['idind_secretaria'];


	$sqlW = "SELECT
indicadores_secretarias.idind_secretaria,
indicadores_secretarias.idindicador,
indicadores.indicador,
indicadores.idind_compuesto,
indicadores_secretarias.idsemaforizacion,
indicadores_secretarias.valor_min,
indicadores_secretarias.valor_max,
indicadores_secretarias.idesindicador,
indicadores_secretarias.idformula,
indicadores_secretarias.idfrecuencia,
secretarias.secretaria,
tpo_indicador.tpo_indicador,
frecuencia_act.frecuencia
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join secretarias ON indicadores_secretarias.idsecretaria = secretarias.idsecretaria
Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
Inner Join frecuencia_act ON indicadores_secretarias.idfrecuencia = frecuencia_act.idfrecuencia
WHERE idind_secretaria = ?";
  	//echo $sqlW;
  	$queryH = $con->prepare($sqlW);
  	$queryH->execute(array($idind_secretaria));
  	$rowH = $queryH->fetch();

  	
?>
<table border="0" width="100%">
	<tr>
		<td align="right" class="Estilo3"><?php 		 
		 echo $rowH['idsemaforizacion']==2 ? "Meta": "NO";
		 //echo weekofyear(getdate()). "  -- Editar";

		 $fecha="2009-01-14" ; // fecha.
		#separas la fecha en subcadenas y asignarlas a variables
		#relacionadas en contenido, por ejemplo dia, mes y anio.
		$dia   = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anio = substr($fecha,0,4);  
		$semana = date('W',  mktime(0,0,0,$mes,$dia,$anio));  
		//donde:		        
		#W (mayúscula) te devuelve el número de semana
		#w (minúscula) te devuelve el número de día dentro de la semana (0=domingo, #6=sabado)
		echo $semana." EDITAR";  

		?></td>
	</tr>
	<tr>
		<td class="Estilo5"><?php echo $rowH['secretaria']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8">Indicador: <?php echo $rowH['tpo_indicador'].' - '.$rowH['indicador']; ?></td>
	</tr>
	<tr>
		<td class="Estilo3"><?php 		 
		 echo "Frecuencia de Actualización: ".$rowH['frecuencia'];
		?></td>
	</tr>
</table>
<br>
<table>
	<tr>
		<td>hola</td>
	</tr>
</table>