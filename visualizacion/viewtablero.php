<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<script type="text/javascript" src="../js/funciones.js"></script>
<?php
@require ("main_valida.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$iduser = $_SESSION['usr'];
$idsecretaria = $_GET['idsecretaria'];
//echo $idsecretaria;

  $sql ="SELECT
		secretarias.idsecretaria,
		secretarias.secretaria,
		secretarias.nom_titular,
		secretarias.periodo
		FROM
		secretarias
		where idsecretaria = $idsecretaria";

      	$result = $con->prepare($sql);
      	$result->execute();
    	$rowS = $result->fetch();

?>
<table border="0" align="center" width="100%">

	<tr>
		<td rowspan="3"><?php 
		 echo "<img src='../images/imgsecretarios/$idsecretaria.png'/>";
		 ?></td>
		<td class="Estilo13">Nombre: <span class="Estilo7"><?php echo $rowS['nom_titular']; ?></span></td>
		<td rowspan="3" align="right"><?php 
		 echo "<img src='../images/logo2.png'/>";
		 ?>
		</td>
	</tr>
	<tr>
		<td class="Estilo13">Secretaria: <span class="Estilo7"><?php echo $rowS['secretaria']; ?></span></td>
	</tr>
		<tr>	
		<td class="Estilo13">Periodo: <span class="Estilo7"><?php echo $rowS['periodo']; ?></span></td>
	</tr>
</table>
<button type="button" class="btnvarios" onClick="window.open('pdf_indicadores.php?idsecretaria=<?php echo $idsecretaria; ?>','_newtab');" >PDF  </button>
<?php
	$sql1 ="SELECT v.idind_secretaria, FORMAT(CASE idformula WHEN 1 THEN v.valor  WHEN 2 THEN avg(v.valor) WHEN 3 THEN sum(v.valor) WHEN 4 THEN vmax.valor  ELSE sum(v.valor) END,2) AS valor, 
	FORMAT(prom,2) AS prom, idformula, m.anio_periodo, indicador, unidad_medida,
idtpo_indicador, ind.idsecretaria FROM (
SELECT * FROM vw_max_anio_val) as m
INNER JOIN 
(SELECT * FROM 
valores) as v 
INNER JOIN 
(SELECT avg(valor) AS prom, idind_secretaria FROM valores 
GROUP BY idind_secretaria) AS p
INNER JOIN (SELECT idind_secretaria, idformula FROM indicadores_secretarias) AS i
INNER JOIN (SELECT valores.valor, valores.idind_secretaria, valores.anio_periodo, valores.fre_periodo
FROM
vw_max_fre_periodo
INNER join valores ON vw_max_fre_periodo.idind_secretaria = valores.idind_secretaria AND vw_max_fre_periodo.anio_periodo = valores.anio_periodo AND vw_max_fre_periodo.fre_periodo = valores.fre_periodo) AS vmax
INNER JOIN (SELECT
indicadores_secretarias.idind_secretaria,
indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida) AS ind
ON p.idind_secretaria = v.idind_secretaria AND i.idind_secretaria = p.idind_secretaria
AND  m.idind_secretaria = v.idind_secretaria AND m.anio_periodo = v.anio_periodo
AND v.idind_secretaria = vmax.idind_secretaria AND v.anio_periodo = vmax.anio_periodo
AND v.idind_secretaria = ind.idind_secretaria
GROUP BY v.idind_secretaria
HAVING  ind.idsecretaria = $idsecretaria AND ind.idtpo_indicador = 1
UNION ALL
SELECT
indicadores_secretarias.idind_secretaria,
' ' as valor,
' ' as prom, 
indicadores_secretarias.idformula,
' ' as anio_periodo,
 indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores_secretarias
Inner Join indicadores ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
WHERE idind_secretaria NOT IN (SELECT idind_secretaria FROM valores) AND idsecretaria = $idsecretaria AND indicadores_secretarias.idtpo_indicador = 1";
	$result1 = $con->prepare($sql1);
    $result1->execute(); 


    $sql2 ="SELECT v.idind_secretaria, FORMAT(CASE idformula WHEN 1 THEN v.valor  WHEN 2 THEN avg(v.valor) WHEN 3 THEN sum(v.valor) WHEN 4 THEN vmax.valor  ELSE sum(v.valor) END,2) AS valor, 
    FORMAT(prom,2) AS prom, idformula, m.anio_periodo, indicador, unidad_medida,
idtpo_indicador, ind.idsecretaria FROM (
SELECT * FROM vw_max_anio_val) as m
INNER JOIN 
(SELECT * FROM 
valores) as v 
INNER JOIN 
(SELECT avg(valor) AS prom, idind_secretaria FROM valores 
GROUP BY idind_secretaria) AS p
INNER JOIN (SELECT idind_secretaria, idformula FROM indicadores_secretarias) AS i
INNER JOIN (SELECT valores.valor, valores.idind_secretaria, valores.anio_periodo, valores.fre_periodo
FROM
vw_max_fre_periodo
INNER join valores ON vw_max_fre_periodo.idind_secretaria = valores.idind_secretaria AND vw_max_fre_periodo.anio_periodo = valores.anio_periodo AND vw_max_fre_periodo.fre_periodo = valores.fre_periodo) AS vmax
INNER JOIN (SELECT
indicadores_secretarias.idind_secretaria,
indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida) AS ind
ON p.idind_secretaria = v.idind_secretaria AND i.idind_secretaria = p.idind_secretaria
AND  m.idind_secretaria = v.idind_secretaria AND m.anio_periodo = v.anio_periodo
AND v.idind_secretaria = vmax.idind_secretaria AND v.anio_periodo = vmax.anio_periodo
AND v.idind_secretaria = ind.idind_secretaria
GROUP BY v.idind_secretaria
HAVING  ind.idsecretaria = $idsecretaria AND ind.idtpo_indicador = 2
UNION ALL
SELECT
indicadores_secretarias.idind_secretaria,
' ' as valor,
' ' as prom, 
indicadores_secretarias.idformula,
' ' as anio_periodo,
 indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores_secretarias
Inner Join indicadores ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
WHERE idind_secretaria NOT IN (SELECT idind_secretaria FROM valores) AND idsecretaria = $idsecretaria AND indicadores_secretarias.idtpo_indicador = 2";
	$result2 = $con->prepare($sql2);
    $result2->execute(); 

    $sql3 ="SELECT v.idind_secretaria, FORMAT(CASE idformula WHEN 1 THEN v.valor  WHEN 2 THEN avg(v.valor) WHEN 3 THEN sum(v.valor) WHEN 4 THEN vmax.valor  ELSE sum(v.valor) END,2) AS valor, 
	FORMAT(prom,2) AS prom, idformula, m.anio_periodo, indicador, unidad_medida,
idtpo_indicador, ind.idsecretaria FROM (
SELECT * FROM vw_max_anio_val) as m
INNER JOIN 
(SELECT * FROM 
valores) as v 
INNER JOIN 
(SELECT avg(valor) AS prom, idind_secretaria FROM valores 
GROUP BY idind_secretaria) AS p
INNER JOIN (SELECT idind_secretaria, idformula FROM indicadores_secretarias) AS i
INNER JOIN (SELECT valores.valor, valores.idind_secretaria, valores.anio_periodo, valores.fre_periodo
FROM
vw_max_fre_periodo
INNER join valores ON vw_max_fre_periodo.idind_secretaria = valores.idind_secretaria AND vw_max_fre_periodo.anio_periodo = valores.anio_periodo AND vw_max_fre_periodo.fre_periodo = valores.fre_periodo) AS vmax
INNER JOIN (SELECT
indicadores_secretarias.idind_secretaria,
indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida) AS ind
ON p.idind_secretaria = v.idind_secretaria AND i.idind_secretaria = p.idind_secretaria
AND  m.idind_secretaria = v.idind_secretaria AND m.anio_periodo = v.anio_periodo
AND v.idind_secretaria = vmax.idind_secretaria AND v.anio_periodo = vmax.anio_periodo
AND v.idind_secretaria = ind.idind_secretaria
GROUP BY v.idind_secretaria
HAVING  ind.idsecretaria = $idsecretaria AND ind.idtpo_indicador = 3
UNION ALL
SELECT
indicadores_secretarias.idind_secretaria,
' ' as valor,
' ' as prom, 
indicadores_secretarias.idformula,
' ' as anio_periodo,
 indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores_secretarias
Inner Join indicadores ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
WHERE idind_secretaria NOT IN (SELECT idind_secretaria FROM valores) AND idsecretaria = $idsecretaria AND indicadores_secretarias.idtpo_indicador = 3";
	$result3 = $con->prepare($sql3);
    $result3->execute(); 

    $sql4 ="SELECT v.idind_secretaria, FORMAT(CASE idformula WHEN 1 THEN v.valor  WHEN 2 THEN avg(v.valor) WHEN 3 THEN sum(v.valor) WHEN 4 THEN vmax.valor  ELSE sum(v.valor) END,2) AS valor, 
	FORMAT(prom,2) AS prom, idformula, 
    m.anio_periodo, indicador, unidad_medida,
idtpo_indicador, ind.idsecretaria FROM (
SELECT * FROM vw_max_anio_val) as m
INNER JOIN 
(SELECT * FROM 
valores) as v 
INNER JOIN 
(SELECT avg(valor) AS prom, idind_secretaria FROM valores 
GROUP BY idind_secretaria) AS p
INNER JOIN (SELECT idind_secretaria, idformula FROM indicadores_secretarias) AS i
INNER JOIN (SELECT valores.valor, valores.idind_secretaria, valores.anio_periodo, valores.fre_periodo
FROM
vw_max_fre_periodo
INNER join valores ON vw_max_fre_periodo.idind_secretaria = valores.idind_secretaria AND vw_max_fre_periodo.anio_periodo = valores.anio_periodo AND vw_max_fre_periodo.fre_periodo = valores.fre_periodo) AS vmax
INNER JOIN (SELECT
indicadores_secretarias.idind_secretaria,
indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida) AS ind
ON p.idind_secretaria = v.idind_secretaria AND i.idind_secretaria = p.idind_secretaria
AND  m.idind_secretaria = v.idind_secretaria AND m.anio_periodo = v.anio_periodo
AND v.idind_secretaria = vmax.idind_secretaria AND v.anio_periodo = vmax.anio_periodo
AND v.idind_secretaria = ind.idind_secretaria
GROUP BY v.idind_secretaria
HAVING  ind.idsecretaria = $idsecretaria AND ind.idtpo_indicador = 4
UNION ALL
SELECT
indicadores_secretarias.idind_secretaria,
' ' as valor,
' ' as prom, 
indicadores_secretarias.idformula,
' ' as anio_periodo,
 indicadores.indicador,
unidad_medidas.unidad_medida,
indicadores_secretarias.idtpo_indicador,
indicadores_secretarias.idsecretaria
FROM
indicadores_secretarias
Inner Join indicadores ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
WHERE idind_secretaria NOT IN (SELECT idind_secretaria FROM valores) AND idsecretaria = $idsecretaria AND indicadores_secretarias.idtpo_indicador = 4";
	$result4 = $con->prepare($sql4);
    $result4->execute(); 

?>
<table border="0" width="100%">
	<tr>
		<td align="left" valign="top">
			<table border="0">
				<tr>
					<td height="25" colspan="5" align="center" class="Estilo10" BGCOLOR="#404041">Impacto</td>
				</tr>
				<tr>
					<td height="25" class="Estilo8" BGCOLOR="#dcdbdd">Indicador</td>
					<td class="Estilo8" BGCOLOR="#dcdbdd">Unidad Medida</td>
					<td width="12%" BGCOLOR="#dcdbdd" class="Estilo8">Valor</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Promedio</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Fecha</td>
				</tr>
				<?php
				 while ($row1 = $result1->fetch()){

				 		$img1 = "rojo.png";
				 		if ($row1['valor'] > 0)
				 		{
							$semaforo = (($row1['valor'] * 100) / $row1['prom']);
					 	
					 		if ($semaforo <= 85) $img1 = "rojo.png";
					 		if ($semaforo >= 86 && $semaforo <=99) $img1 = "amarillo.png";
					 		if ($semaforo >99) $img1 = "verde.png";
				 		}

				 		

				 	echo "
					<tr onClick='vwdetalle($idsecretaria)' style='cursor:hand'  onmouseover='this.style.background=\"#D8D8D8\"' onmouseout='this.style.background=\"#ffffff\"'>
						<td height='25' class='Estilo3 border3'>$row1[indicador]</td>
						<td class='Estilo3 border3'>$row1[unidad_medida]</td>
						<td class='Estilo3 border3' align='right'>$row1[valor] <img src='../images/$img1' width='12' height='12'></td>
						<td class='Estilo3 border3' align='right'>$row1[prom]</td>
						<td class='Estilo3 border3' align='center'>$row1[anio_periodo]</td>
					</tr>
				 	";
				 }
				?>

			</table>
		</td>
		
		<td align="right" valign="top">
			<table border="0">
				<tr>
					<td height="25" colspan="5" align="center" class="Estilo10" BGCOLOR="#404041">Proceso</td>
				</tr>
				<tr>
					<td height="25" BGCOLOR="#dcdbdd" class="Estilo8">Indicador</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Unidad Medida</td>
					<td width="12%" BGCOLOR="#dcdbdd" class="Estilo8">Valor</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Promedio</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Fecha</td>
				</tr>
				<?php
				 while ($row2 = $result2->fetch()){

				 		$img2 = "rojo.png";
				 	
				 		if ($row2['valor'] > 0)
				 		{
				 			$semaforo = (($row2['valor'] * 100) / $row2['prom']);
					 		
					 		if ($semaforo <= 85) $img2 = "rojo.png";
					 		if ($semaforo >= 86 && $semaforo <=99) $img2 = "amarillo.png";
					 		if ($semaforo >99) $img2 = "verde.png";
				 		} 
				 	echo "
					<tr>
						<td height='25' class='Estilo3 border3'>$row2[indicador]</td>
						<td class='Estilo3 border3'>$row2[unidad_medida]</td>
						<td class='Estilo3 border3' align='right'>$row2[valor]<img src='../images/$img2' width='12' height='12'></td>
						<td class='Estilo3 border3' align='right'>$row2[prom]</td>
						<td class='Estilo3 border3' align='center'>$row2[anio_periodo]</td>
					</tr>
				 	";
				 }
				?>

			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="left" valign="top">
			<table border="0">
				<tr>
					<td height="25" colspan="5" align="center" class="Estilo10" BGCOLOR="#404041">Producto</td>
				</tr>
				<tr>
					<td height="25" BGCOLOR="#dcdbdd" class="Estilo8">Indicador</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Unidad Medida</td>
					<td width="12%" BGCOLOR="#dcdbdd" class="Estilo8">Valor</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Promedio</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Fecha</td>
				</tr>
				<?php
				 while ($row3 = $result3->fetch()){
				 		
				 		$img3 = "rojo.png";
				 	
				 		if ($row3['valor'] > 0)
				 		{
				 			$semaforo = (($row3['valor'] * 100) / $row3['prom']);
					 		
					 		if ($semaforo <= 85) $img3 = "rojo.png";
					 		if ($semaforo >= 86 && $semaforo <=99) $img3 = "amarillo.png";
					 		if ($semaforo >99) $img3 = "verde.png";
				 		} 

				 	echo "
					<tr>
						<td height='25' class='Estilo3 border3'>$row3[indicador]</td>
						<td class='Estilo3 border3'>$row3[unidad_medida]</td>
						<td class='Estilo3 border3' align='right'>$row3[valor] <img src='../images/$img3' width='12' height='12'></td>
						<td class='Estilo3 border3' align='right'>$row3[prom]</td>
						<td class='Estilo3 border3' align='center'>$row3[anio_periodo]</td>
					</tr>
				 	";
				 }
				?>

			</table>
		</td>
		<td align="right" valign="top">
			<table border="0">
				<tr>
					<td height="25" colspan="5" align="center" class="Estilo10" BGCOLOR="#404041">Resultado</td>
				</tr>
				<tr>
					<td height="25" BGCOLOR="#dcdbdd" class="Estilo8">Indicador</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Unidad Medida</td>
					<td width="12%" BGCOLOR="#dcdbdd" class="Estilo8">Valor</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Promedio</td>
					<td BGCOLOR="#dcdbdd" class="Estilo8">Fecha</td>
				</tr>
				<?php
				 while ($row4 = $result4->fetch()){

				 		$img4 = "rojo.png";
				 	
				 		if ($row4['valor'] > 0)
				 		{
							$semaforo = (($row4['valor'] * 100) / $row4['prom']);
					 		
					 		if ($semaforo <= 85) $img4 = "rojo.png";
					 		if ($semaforo >= 86 && $semaforo <=99) $img4 = "amarillo.png";
					 		if ($semaforo >99) $img4 = "verde.png";
				 		} 
				 	echo "
					<tr>
						<td height='25' class='Estilo3 border3'>$row4[indicador]</td>
						<td class='Estilo3 border3'>$row4[unidad_medida]</td>
						<td class='Estilo3 border3' align='right'>$row4[valor]<img src='../images/$img4' width='12' height='12'></td>
						<td class='Estilo3 border3' align='right'>$row4[prom]</td>
						<td class='Estilo3 border3' align='center'>$row4[anio_periodo]</td>
					</tr>
				 	";
				 }
				?>

			</table>
		</td>
	</tr>
</table>
<br><br><br><br><br><br><br>
<form name="oculto" action="viewdetalle.php" method="get">
	<input type="hidden" id ="idind_secretatiaHi" name="idind_secretaria" />
</form>