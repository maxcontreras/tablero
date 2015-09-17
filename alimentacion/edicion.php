<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<link rel="stylesheet" type="text/css" href="../css/layouts.css">

<script type="text/javascript" src="../js/jquery.js"></script>

<script type="text/javascript">
function EnvioConsulta(ID){
	var Aux=ID.value;
	
	$.ajax({
		type: "post",
		url: "actedit.php",
		data: $("#FormularioContacto").serialize(),
		beforeSend: function(objeto){
			ID.value='Aguarde...';
			$(ID).attr("disabled", "disabled");
        },
		complete: function(objeto, exito){
			ID.value=Aux;
			$(ID).removeAttr("disabled");
        },
		error: function(objeto, quepaso, otroobj){
            alert("Hubo un error. Reintente. Si el problema persiste, comuniquese con el webmaster");
        },
		success: function(datos){
			lista = datos.split(":::");
			if(lista[0]=='ok'){
				alert(unescape(lista[1]));
				ID.value='Información guardada...';
				$("#dialog-table").close();
				}
			else if(lista[0]=='error' && lista[1])
				{
				alert(unescape(lista[1]));
				}
			else
				{
				alert(unescape(datos));
				}
		}

	});

}
</script>

<?php
@require ("main_valida.php");
@require ("../php/verifica.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$iduser = $_SESSION['usr'];




if(isset($_POST['idIndicador'])) $idind_secretaria=$_POST['idIndicador']; 
if(isset($_GET['idind_secretaria'])) $idind_secretaria=$_GET['idind_secretaria']; 

	$sqlW = "SELECT
indicadores_secretarias.idind_secretaria,
secretarias.secretaria,
indicadores_secretarias.idsecretaria,
indicadores_secretarias.idindicador,
indicadores.indicador,
indicadores_secretarias.idsemaforizacion,
semaforizacion.semaforizacion,
semaforizacion.nom_semaforo,
indicadores_secretarias.idesindicador,
indicadores_secretarias.valor_min,
indicadores_secretarias.valor_max,
indicadores_secretarias.idformula,
formulas.formula,
formulas.descripcion AS des_formula,
indicadores_secretarias.idfrecuencia,
frecuencia_act.frecuencia,
indicadores_secretarias.idtema_elemental,
tema_elementales.tema_elemental,
tema_elementales.snieg,
indicadores_secretarias.idtpo_indicador,
tpo_indicador.tpo_indicador,
indicadores_secretarias.idunidad_medida,
unidad_medidas.unidad_medida,
indicadores_secretarias.descripcion AS descripcion,
indicadores_secretarias.metodologia,
indicadores_secretarias.idtendencia,
tendencias.tendencia,
indicadores_secretarias.idprocedencia,
procedencias.procedencia,
procedencias.descripcion AS des_procedencia,
indicadores_secretarias.fuente,
indicadores_secretarias.palabra,
indicadores_secretarias.notas,
indicadores_secretarias.idmet_recoleccion,
met_recoleccion_datos.recoleccion,
met_recoleccion_datos.descripcion AS des_recoleccion,
tpo_indicador.tpo_indicador
FROM
indicadores
Inner Join indicadores_secretarias ON indicadores_secretarias.idindicador = indicadores.idindicador
Inner Join tema_elementales ON indicadores_secretarias.idtema_elemental = tema_elementales.idtema_elemental
Inner Join semaforizacion ON indicadores_secretarias.idsemaforizacion = semaforizacion.idsemaforizacion
Inner Join unidad_medidas ON indicadores_secretarias.idunidad_medida = unidad_medidas.idunidad_medida
Inner Join tendencias ON indicadores_secretarias.idtendencia = tendencias.idtendencia
Inner Join procedencias ON indicadores_secretarias.idprocedencia = procedencias.idprocedencia
Inner Join met_recoleccion_datos ON met_recoleccion_datos.idmet_recoleccion = indicadores_secretarias.idmet_recoleccion
Inner Join frecuencia_act ON indicadores_secretarias.idfrecuencia = frecuencia_act.idfrecuencia
Inner Join tpo_indicador ON tpo_indicador.idtpo_indicador = indicadores_secretarias.idtpo_indicador
Inner Join secretarias ON secretarias.idsecretaria = indicadores_secretarias.idsecretaria
Inner Join formulas ON indicadores_secretarias.idformula = formulas.idformula
WHERE idind_secretaria = ?";
  	//echo $sqlW;
  	$queryH = $con->prepare($sqlW);
  	$queryH->execute(array($idind_secretaria));
  	

  

	while ($row = $queryH->fetch()){
		$descripcion = $row['descripcion'];
		$metodologia = $row['metodologia'];
		$fuente 	 = $row['fuente'];
		$palabras 	 = $row['palabra'];
		$notas	 	 = $row['notas'];


		
		?>
		<form id="FormularioContacto" name="FormularioContacto" method="post" >
			<?php echo "<input type='hidden' name='idind_secretaria' value='$idind_secretaria' />
						<input type='hidden' name='idindicador' value='$row[idindicador]' />"; ?>
			<table border="0">
				<tr>
					<td colspan= "2" class="Estilo13"><?php echo $row['secretaria']; ?></td>
				</tr>
				<tr>
					<td class="Estilo13">Indicador</td>
					<td class="Estilo13"><?php echo $row['tpo_indicador']. ' - '.$row['indicador']; ?></td>
				</tr>
				<tr>
					<td class="Estilo13">Tema Elemental:</td>
					<td><?php 
						echo "<select name='tema' size='1' id='tema' class='Estilo3' style='width:270px;'>";
		    			$sqlcc="SELECT     idtema_elemental, tema_elemental FROM  tema_elementales";
              			$querycc = $con->prepare($sqlcc);
  						$querycc->execute();
			     		while ($rowcc = $querycc->fetch()){
							$sel = verificasel($rowcc[0],$row['idtema_elemental']);
			    			print"<option value='$rowcc[0]' $sel >$rowcc[1]</option>";
			  			}
						echo "</select>";
			  		?></td>
				</tr>
				<tr>
					<td class="Estilo13">Unidad de Medida:</td>
					<td><?php 
						echo "<select name='unidad' size='1' id='unidad' class='Estilo3' style='width:270px;'>";
		    			$sqlcc="SELECT  idunidad_medida, unidad_medida FROM  unidad_medidas";
              			$querycc = $con->prepare($sqlcc);
  						$querycc->execute();
			     		while ($rowcc = $querycc->fetch()){
							$sel = verificasel($rowcc[0],$row['idunidad_medida']);
			    			print"<option value='$rowcc[0]' $sel >$rowcc[1]</option>";
			  			}
						echo "</select>";
			  		?></td>
				</tr>
				<tr>
					<div id="content_name">
						<td class="Estilo13">Descripcíón:</td>
						<td> <?php echo"<textarea name='descripcion' id='descripcion' cols='50' rows='4' class='Estilo3'>$descripcion</textarea>"; ?></td>
					</div>
				</tr>
				<tr>
					<div id="content_lastname">
						<td class="Estilo13">Metodología:</td>
						<td> <?php echo"<textarea name='metodologia' id='metodologia' cols='50' rows='4' class='Estilo3'>$metodologia</textarea>"; ?></td>
					</div>
				</tr>
			 	<tr>
					<td class="Estilo13">Tendencia:</td>
					<td><?php 
						echo "<select name='tendencia' size='1' id='tendencia' class='Estilo3' style='width:270px;'>";
		    			$sqlcc="SELECT  idtendencia, tendencia FROM  tendencias";
              			$querycc = $con->prepare($sqlcc);
  						$querycc->execute();
			     		while ($rowcc = $querycc->fetch()){
							$sel = verificasel($rowcc[0],$row['idtendencia']);
			    			print"<option value='$rowcc[0]' $sel >$rowcc[1]</option>";
			  			}
						echo "</select>";
			  		?></td>
				</tr>
				<tr>
					<td class="Estilo13">Procedencia:</td>
					<td><?php 
						echo "<select name='procedencia' size='1' id='procedencia' class='Estilo3' style='width:270px;'>";
		    			$sqlcc="SELECT  idprocedencia, descripcion, procedencia FROM  procedencias";
              			$querycc = $con->prepare($sqlcc);
  						$querycc->execute();
			     		while ($rowcc = $querycc->fetch()){
							$sel = verificasel($rowcc[0],$row['idprocedencia']);
			    			print"<option value='$rowcc[0]' $sel >$rowcc[1]</option>";
			  			}
						echo "</select>";
			  		?></td>
				</tr>
				<tr>
					<td class="Estilo13">Fuente:</td>
					<td> <?php echo"<textarea name='fuente' id='fuente' cols='50' rows='4' class='Estilo3'>$fuente</textarea>"; ?></td>
				</tr>
				<tr>
					<td class="Estilo13">Palabras Claves:</td>
					<td> <?php echo"<textarea name='palabras' id='palabras' cols='50' rows='4' class='Estilo3'>$palabras</textarea>"; ?></td>
				</tr>
				<tr>
					<td class="Estilo13">Notas:</td>
					<td> <?php echo"<textarea name='notas' id='notas' cols='50' rows='4' class='Estilo3'>$notas</textarea>"; ?></td>
				</tr>
				<tr>
					<td class="Estilo13">Metodo de recolección de datos:</td>
					<td><?php 
						echo "<select name='recoleccion' size='1' id='recoleccion' class='Estilo3' style='width:270px;'>";
		    			$sqlcc="SELECT  idmet_recoleccion, descripcion, recoleccion FROM  met_recoleccion_datos";
              			$querycc = $con->prepare($sqlcc);
  						$querycc->execute();
			     		while ($rowcc = $querycc->fetch()){
							$sel = verificasel($rowcc[0],$row['idmet_recoleccion']);
			    			print"<option value='$rowcc[0]' $sel >$rowcc[1]</option>";
			  			}
						echo "</select>";
			  		?></td>
				</tr>
				<tr>
					<td colspan= "2" align="center"><input type="submit" name="Guardar" id="Guardar" onclick="JavaScript:EnvioConsulta(this)" value="Actualizar Información" class="Estilo8" style="width:200px;"  /></td>
				</tr>
			</table>
		</form>
		<?php
	}

?>
