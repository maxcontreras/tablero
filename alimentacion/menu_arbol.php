<div id="dialog-table" title="Detalles de Indicador">
</div>

<div id="contenedor">
        <div id="menu" class="menu">
          Indicadores:
<?php
	require_once('../lib/class.database.php');	
	require_once('../lib/config.php');
	$BD = new database(_BD_SERVIDOR.':'._BD_PUERTO, _BD_USUARIO, _BD_PASSWORD );	

	/*$pestania = $_GET['p'];
	$idInd = $_GET['i'];*/

	$idUsuario = '2';
//echo "indicador recibido: ".$idInd;

	$query_indicadores = "
		SELECT ins.idind_secretaria,s.secretaria,ins.idindicador, ins.idtpo_indicador, i.indicador, t.tpo_indicador
		FROM "._TBL_USUARIO." u
		LEFT JOIN "._TBL_INDSEC." ins
		ON u.idsecretaria = ins.idsecretaria
		LEFT JOIN "._TBL_IND." i
		ON ins.idindicador = i.idindicador
		LEFT JOIN "._TBL_TPOIND." t
		ON ins.idtpo_indicador = t.idtpo_indicador
		LEFT JOIN "._TBL_SEC." s
		ON u.idsecretaria = s.idsecretaria
		WHERE id_usr = ".$idUsuario."
		ORDER BY t.tpo_indicador
	";
/*
	$query_indicadores = "
		SELECT s.secretaria, ins.idindicador, i.indicador, t.tpo_indicador
		FROM "._TBL_INDSEC." ins
		LEFT JOIN "._TBL_IND." i
		ON ins.idindicador = i.idindicador
		LEFT JOIN "._TBL_TPOIND." t
		ON ins.idtpo_indicador = t.idtpo_indicador
		LEFT JOIN "._TBL_SEC." s
		ON ins.idsecretaria = s.idsecretaria
		ORDER BY s.secretaria,t.tpo_indicador, i.indicador
		limit 20 

	";
*/


	//echo $query_indicadores;

$BD->setQuery($query_indicadores);	
$indicadores = $BD->loadObjectList();
$numInd = count($indicadores);



/*VARIABLES*/
$secretarianombre = "";
$tipoIndicador = "";
$numVuelta = "";
echo '<ul id="temas" class="filetree">';	
for ($i=0; $i < $numInd ; $i++) { 


		

						//VALIDAR SI LA SECRETARIA ES DIFERENTE
						if ( strcmp($secretarianombre, $indicadores[$i]->secretaria) !== 0 ) {
						//SE ASIGNAN VARIABLES
						$secretarianombre = $indicadores[$i]->secretaria;
						echo '<li class="closed"><span class="folder">'.$indicadores[$i]->secretaria.'</span>';
							echo '<ul>';
						}
								  		//echo $tipoIndicador ."  =  ".$indicadores[$i]->tpo_indicador;
														
										//VALIDAR SI LA SECRETARIA ES DIFERENTE
										if ( strcmp($tipoIndicador, $indicadores[$i]->tpo_indicador) !== 0 ) {		

																if($i > $numVuelta ){
																	echo '</ul>'; 
																
																}

										$tipoIndicador = $indicadores[$i]->tpo_indicador;				
										$numVuelta = $i;									
										echo '<li class="closed"><span class="folder">'.$indicadores[$i]->tpo_indicador.'</span>';
																	echo '<ul>';
										}
																	


																			echo '<li class="closed"><input name="rad_ind_secretaria" id= "'.$indicadores[$i]->idind_secretaria.'" type="radio" value="'.$indicadores[$i]->idind_secretaria.'" />';
																						echo '<span>'.$indicadores[$i]->indicador.'</span> <img src="../images/captura/c_rojo.png" alt="rojo" height="15" width="15"> ';
																			echo '</li>';
										if ( strcmp($tipoIndicador, $indicadores[$i]->tpo_indicador) !== 0 ) {			
																if($i > $numVuelta ){
																	
																	echo '</li>';
																}
										
										
										}
																	
						if ( strcmp($secretarianombre, $indicadores[$i]->secretaria) !== 0 ) {										
								
								echo '</ul>';

				    	echo '</li>';		

				    }






}
	echo '</ul>';

	
/*
echo '<ul id="temas" class="filetree">';			

						echo '<li class="closed"><span class="folder">SECRETARIA</span>';
								echo '<ul>';
							
										echo '<li class="closed">';
														echo '<span class="folder">TIPO INDICADOR</span>';
																	echo '<ul>';
																			echo '<li class="file"><input name="subtema_id" type="radio" value="3000" />';
																						echo '<span>IND 1</span>';
																			echo '</li>';
																			echo '<li class="file"><input name="subtema_id" type="radio" value="3000" />';
																						echo '<span>IND 2111</span>';
																			echo '</li>';
																	echo '</ul>'; 
										echo '</li>';						
								echo '</ul>';

				    	echo '</li>';		

	echo '</ul>';
*/



?>
                                                        </div>
                                                        <div id="contenido_alimentacion">
                                                          <div id='divresultado' class='divresultado'>resultado</div>
                                                        </div>
                                                </div>
<script type="text/javascript">

var id = "<?php echo $idInd;?>";
var cad = "#"+id;
jQuery(cad).attr('checked', true);
/*Manda llamar la función del tree*/


</script>