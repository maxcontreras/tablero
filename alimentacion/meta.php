<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<link rel="stylesheet" type="text/css" href="../css/layouts.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
 $(document).ready(function (){
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
        });
</script>
<?php
@require ("main_valida.php");

if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$iduser = $_SESSION['usr'];

if(isset($_POST['idIndicador'])) $idind_secretaria=$_POST['idIndicador']; 
if(isset($_GET['idind_secretaria'])) $idind_secretaria=$_GET['idind_secretaria']; 


	$sqlW = "SELECT
		indicadores_secretarias.idind_secretaria,
		indicadores_secretarias.idindicador,
		indicadores.indicador,
		indicadores.idind_compuesto,
		indicadores_secretarias.idsemaforizacion,
		indicadores_secretarias.fuente,
		indicadores_secretarias.descripcion,
		indicadores_secretarias.valor_min,
		indicadores_secretarias.valor_max,
		indicadores_secretarias.idesindicador,
		indicadores_secretarias.idformula,
		indicadores_secretarias.idfrecuencia,
		secretarias.secretaria,
		tpo_indicador.tpo_indicador,
		frecuencia_act.frecuencia, 
		tema_elementales.tema_elemental,
		semaforizacion.nom_semaforo,
		esindicador.esindicador,
		unidad_medidas.unidad_medida,
		tendencias.tendencia,
		procedencias.descripcion AS procedencia
		FROM
		indicadores
		Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
		Inner Join secretarias ON indicadores_secretarias.idsecretaria = secretarias.idsecretaria
		Inner Join tpo_indicador ON indicadores_secretarias.idtpo_indicador = tpo_indicador.idtpo_indicador
		Inner Join frecuencia_act ON indicadores_secretarias.idfrecuencia = frecuencia_act.idfrecuencia
		Inner Join tema_elementales ON indicadores_secretarias.idtema_elemental = tema_elementales.idtema_elemental
		Inner Join semaforizacion ON indicadores_secretarias.idsemaforizacion = semaforizacion.idsemaforizacion
		Inner Join esindicador ON indicadores_secretarias.idesindicador = esindicador.idesindicador
		Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
		Inner Join tendencias ON indicadores_secretarias.idtendencia = tendencias.idtendencia
		Inner Join procedencias ON indicadores_secretarias.idprocedencia = procedencias.idprocedencia
		WHERE idind_secretaria = ?";
  	//echo $sqlW;
  	$queryH = $con->prepare($sqlW);
  	$queryH->execute(array($idind_secretaria));
  	$rowH = $queryH->fetch();
	$idindicador 		= $rowH['idindicador'];

?>

<table border="0" width="100%">
	<tr>
		<td class="Estilo5" colspan="2"><?php echo $rowH['secretaria']; ?></td>
	</tr>

	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Tipo de Indicador: <br></span> <?php echo $rowH['tpo_indicador']; ?></td>	
		<td rowspan="11" valign="top" class="Estilo8" width="50%">
			<form id="form1" name="form1" method="post" action="actmeta.php" enctype="multipart/form-data">
						<?php echo "<input type='hidden' name='idind_secretaria' value='$idind_secretaria' />"; ?>
				<table border="0">
					<tr>
						<td>
							<?php

								$sqlc="SELECT anio, valor FROM metas
								WHERE  idind_secretaria = ?
								ORDER BY anio";

							 	$queryc = $con->prepare($sqlc);
							  	$queryc->execute(array($idind_secretaria));

							  	$bandera=false;

							  	echo "<table width='50%'>
							  		<tr style='background: #B02320;'>
							  			<td class='Estilo10'>Año</td>
							  			<td class='Estilo10' align='center'>META</td>
							  		</tr>";
								while ($rowc = $queryc->fetch()){
							  		if($bandera){
							    		echo"<tr height='22'  style='background: #ffffff;'>";
							    		$bandera=false;}
							  		else{
							    		echo"<tr height='22'  style='background: #dbdcdd;'>";
							    		$bandera=true;
							  		}
							  		echo "<td align='center' class='Estilo3'>$rowc[anio]</td>
									  	  <td align='right' class='Estilo3'>"; echo number_format($rowc['valor'], 2, '.', ','); echo"</td>";
									echo "</tr>";
							  	}
							  	echo "</table>";
							?>
						</td>
						
					</tr>
					<tr>
						<td class="Estilo14">Seleccione el año:<?php 
						echo "<select name='anio' size='1' id='anio' class='Estilo3' style='width:100px;'>";
		    			$sqlcc="SELECT anio FROM anios
								WHERE anio NOT IN (SELECT anio FROM metas)";
              			$querycc = $con->prepare($sqlcc);
  						$querycc->execute();
			     		while ($rowcc = $querycc->fetch()){
			    			print"<option value='$rowcc[0]'>$rowcc[0]</option>";
			  			}
						echo "</select>";
			  		?></td>
					</tr>
					<tr>
						<td class="Estilo14">Meta:<input type="text" name="valor" class="solo-numero" /></td>
					</tr>
					<tr>
						<td><input type="submit" name="Guardar" id="Guardar" value="Agregar Meta" class="Estilo8" style="width:200px;"  /></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Indicador: <br></span> <?php echo $rowH['indicador']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Tema Elemental:<br></span><?php echo $rowH['secretaria']; ?> <?php echo $rowH['tema_elemental']; ?></td>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Semaforización: <br></span> </td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Es Indicador: <br></span> <?php echo $rowH['esindicador']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Unidad de Medida: <br></span> <?php echo $rowH['unidad_medida']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Descripción: <br></span> <?php echo $rowH['descripcion']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Tendencia: <br></span> <?php echo $rowH['tendencia']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Procedencia: <br></span> <?php echo $rowH['procedencia']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Frecuencia: <br></span> <?php echo $rowH['frecuencia']; ?></td>
	</tr>
	<tr>
		<td  class="Estilo8 border3"><span class="Estilo14">Fuente: <br></span> <?php echo $rowH['fuente']; ?></td>
	</tr>
</table>