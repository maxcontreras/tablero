<?php
	require_once('../lib/class.database.php');	
	require_once('../lib/config.php');
	
	$BD = new database(_BD_SERVIDOR.':'._BD_PUERTO, _BD_USUARIO, _BD_PASSWORD );	

	$query_indicadores = "
		SELECT s.secretaria,ins.idindicador, ins.idtpo_indicador, i.indicador, tpo_indicador
		FROM "._TBL_USUARIO." u
		LEFT JOIN "._TBL_INDSEC." ins
		ON u.idsecretaria = ins.idsecretaria
		LEFT JOIN "._TBL_IND." i
		ON ins.idindicador = i.idindicador
		LEFT JOIN "._TBL_TPOIND." t
		ON ins.idtpo_indicador = t.idtpo_indicador
		LEFT JOIN "._TBL_SEC." s
		ON u.idsecretaria = s.idsecretaria
		WHERE id_usr = 2
		ORDER BY t.tpo_indicador
	";
	//echo $query_indicadores;

$BD->setQuery($query_indicadores);	
$indicadores = $BD->loadObjectList();
$numInd = count($indicadores);



/*VARIABLES*/
$secretarianombre = "";

for ($i=0; $i < $numInd ; $i++) { 

	echo '<ul id="temas" class="filetree">';			
						echo '<li class="closed"><span class="folder">'.$indicadores[$i]->secretaria.'</span>';
								echo '<ul>';
							
										echo '<li class="closed">';
														echo '<span class="folder">TIPO INDICADOR</span>';
																	echo '<ul>';
																			echo '<li class="closed"><input name="subtema_id" type="radio" value="3000" />';
																						echo '<span>IND 1</span>';
																			echo '</li>';
																			echo '<li class="closed"><input name="subtema_id" type="radio" value="3000" />';
																						echo '<span>IND 2</span>';
																			echo '</li>';
																	echo '</ul>'; 
										echo '</li>';						
								echo '</ul>';

				    	echo '</li>';		

	echo '</ul>';
}


?>