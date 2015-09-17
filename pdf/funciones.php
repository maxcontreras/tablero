<?php


function crea_listaPeriodo($query, $BD){



		$lista ='<td>';
		$lista.='Selecciona periodo:';
		$lista.='</td>';

			$lista.= '
				<td>
				<select name="select_periodo" id="select_periodo" size ="1">
				<option selected value="-1"> Elige una opción </option>
			';
					$query = "
						SELECT idmes, mes 
						FROM "._TBL_MES." s 
						ORDER BY mes
					";

					$BD->setQuery($query);
					$periodos = $BD->loadObjectList();

					$numFu = count($periodos);

					for ($j=0; $j < $numFu; $j++) { 

						$lista.= "<option value=\"".$periodos[$j]->idmes."\">".$periodos[$j]->mes."</option>";	
						
					}
				
			$lista.='										
				</select></td>	
			';


			return $lista;

}


function crea_camposValor($id, $idesindicador, $BD){

	//REVISAR SI ES INDICADOR COMPUESTO 
		if ( strcmp($idesindicador, 1) == 0 ) {

			//echo "entra";

			//ID ES INDICADOR VALORES 2 = NO 1 = SI 
			$query_valores = "
					SELECT nombre_variable,referencia,u.unidad_medida
					FROM "._TBL_INDCOMP." i
					LEFT JOIN "._TBL_U_MEDIDA." u
					ON i.idunidad_medida = u.idunidad_medida
					WHERE idindicador = ".$id."
					ORDER BY referencia desc
			";

			//echo $query_valores;
			$BD->setQuery($query_valores);

			$campos = $BD->loadObjectList();

			//print_r($campos);

			
		
			$valor = '<tr>';
			$valor .= '<td>'.$campos[0]->nombre_variable.':</td>'; 
			$valor .= '<td><input type=text placeholder="Ingresar Valor" name="'.$campos[0]->nombre_variable.'" id="valorIndicador" value="'.$id.'"  size="12"> '.$campos[0]->unidad_medida.'</td>';
			$valor .='</tr>';

			$valor .= '<tr>';
			$valor .= '<td>'.$campos[1]->nombre_variable.':</td>';
			$valor .= '<td><input type=text placeholder="Ingresar Valor" name="'.$campos[1]->nombre_variable.'" id="valorIndicador" value="'.$id.'"  size="12"> '.$campos[1]->unidad_medida.'</td>';
			$valor .='</tr>';


			



		//SI NO LO ES	
		}else{

			$valor='<td>Valor: </td>';
			$valor.= '<td><input type=text placeholder="Ingresar Valor" name="valorIndicador" id="valorIndicador" value="'.$id.'"  size="12"></td>';


		}


		return $valor;




	
}



function crea_calendario(){

		//CREAR CALENDARIO 
		$calendario = '
			
			Fecha: <input type="text" name="fecha" id ="campofecha" class="campofecha" size="12">

		';

		return $calendario;
}

function mostrar_historico($id, $BD){


	$query_historico="SELECT anio_periodo,v.fre_periodo,v.idsecretaria,v.valor,v.idfrecuencia,CASE v.idfrecuencia 
	WHEN 1 THEN 'semana'  WHEN 2 THEN m.mes  ELSE CONCAT (v.idfrecuencia, ' ' ,SUBSTRING(f.frecuencia,1,3))   END as fre
	FROM "._TBL_VALORES." as v
	LEFT JOIN "._TBL_FRECUENCIA." as f ON f.idfrecuencia = v.idfrecuencia
	INNER JOIN "._TBL_MES." as m ON v.fre_periodo = m.idmes
	WHERE anio_periodo IN (SELECT MAX(anio_periodo) FROM "._TBL_VALORES." WHERE  idind_secretaria = ".$id.") 
	GROUP BY fre_periodo, idind_secretaria
	HAVING  idind_secretaria =".$id."
	order By fre_periodo";
	


	//echo $query_historico;
	
 	$BD->setQuery($query_historico);	
	$h = $BD->loadObjectList();
	$numh = count($h);

	//print_r($h);

 	"numero de h ".$numh;
  	$bandera=false;
  


  	echo "<table width='50%'>
  		<tr style='background: #B02320;'>
  			<td align='center'>Año</td>
  			<td align='center'>Periodo</td>
  			<td align='right' class='Estilo10' >Valor</td>
  		</tr>";
//	while ($rowH = $h->fetch()){
	for ($i=0; $i < $numh ; $i++) { 

  		if($bandera){
    		echo"<tr height='22'  style='background: #ffffff;'>";
    		$bandera=false;}
  		else{
    		echo"<tr height='22'  style='background: #dbdcdd;'>";
    		$bandera=true;
  		}
  		echo "<td align='center' class='Estilo3'>".$h[$i]->anio_periodo."</td>
		 	 <td align='center' class='Estilo3'>".$h[$i]->fre."</td>
		 	 <td align='right' class='Estilo3'>"; echo number_format($h[$i]->valor, 2, '.', ','); echo"</td>";
		echo "</tr>";
  	}


  	echo "</table>";

  	

}




?>