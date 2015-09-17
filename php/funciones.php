<?php
function creaListaAnual($idind_secretaria, $frecuencia, $BD, $idfrecuencia, $leyenda){
	

		//SI REQUIERE LEYENDA 
if ( strcmp($leyenda, '') == 0 ) {

		$lista ='<td>';
		$lista.='Selecciona periodo '.$frecuencia.' :';
		$lista.='</td>';
}

			$lista.= '
				<td>
				<select name="select_periodo" id="select_periodo" size ="1">
				<option selected value="-1">Elige el Año </option>
			';

					/*
					$query = "
							SELECT idanio, anio
							FROM "._TBL_ANIO." a
							ORDER BY anio
					";
					*/

			//VER EL TIPO DE FRECUENCIA Y AUMENTAR LOS AÑOS CORRESPONDIENTES

					
					//ANUAL 
					//BIENAL
					//TRIANUAL
					echo "frecuencia".$frecuencia."<br>";
					switch ($frecuencia) {
					                case "Anual":
					                	$incremento = 1;
				                    break;
					                case "Bienal":
					                	$incremento = 2;					                
				                    break;
					                case "Trianual":
					                	$incremento = 3;
				                    break;
				                	default:
					                	$incremento = 1;
				                 }				                

					$query = "
							Select v.anio_periodo, (v.anio_periodo + ".$incremento.") as siguiente
							FROM "._TBL_VALORES." v
							WHERE v.idind_secretaria = ".$idind_secretaria."
							ORDER BY v.anio_periodo desc limit 1
					";


					//echo $query;
					$BD->setQuery($query);
					$periodos = $BD->loadObjectList();

					$numFu = count($periodos);

					//SI NO TIENE REGISTROS INICIA EN EL AÑO ACTUAL
					if ( strcmp($numFu, 0) === 0 ) {
							//AÑO ACTUAL 
							$anio = date ("Y"); 
							$lista.= "<option value=\"".$anio."\">".$anio."</option>";	
						}
					

					for ($j=0; $j < $numFu; $j++) { 


							$lista.= "<option value=\"".$periodos[$j]->siguiente."\">".$periodos[$j]->siguiente."</option>";								

						
					}




				
			$lista.='										
				</select></td>	
			';
			
			//CAMPO OCULTO CON DETALLE DE INDICADOR 
			$lista.='<td><input type="hidden" name="frecuencia" id = "frecuencia" value="'.$idfrecuencia.'"></td>';

			return $lista;

}

function crea_listaPeriodo($idind_secretaria, $frecuencia, $BD, $idfrecuencia){

		//OBTIENE EL VALOR MAXIMO DEL PERIODO 
		$valor_maximo = "
						SELECT p.numero
						FROM "._TBL_PERIODO." p
						WHERE idfrecuencia = ".$idfrecuencia."
						ORDER BY numero desc
						LIMIT 1
		";

		$BD->setQuery($valor_maximo);
		$vm = $BD->loadObject();

		//OBTIENE EL ÚLTIMO PERIODO ACTUALIZADO 
		$query_ultimo = "
						Select p.numero
						FROM "._TBL_VALORES." v
						LEFT JOIN "._TBL_PERIODO." p
						ON v.id_periodo  = p.id_periodo
						WHERE v.idind_secretaria = ".$idind_secretaria."
						ORDER BY v.anio_periodo desc
						LIMIT 1
						";

						//echo "query :".$query_ultimo;

		$BD->setQuery($query_ultimo);
		$numero = $BD->loadObject();


		//echo "valores: ".$vm->numero." otro:  ".$numero->numero;


		$lista ='<tr><td>';
		$lista.='Selecciona periodo '.$frecuencia.' :';
		$lista.='</td></tr>';

			$lista.= '
				<tr>
				<td>
				<select name="select_periodo" id="select_periodo" size ="1">
				<option selected value="-1"> Elige el periodo</option>
			';

					$query = "
							SELECT id_periodo, periodo , mes , numero
							FROM "._TBL_PERIODO." p 
							WHERE idfrecuencia = '".$idfrecuencia."' ";

				//SI 
				if ( strcmp($vm->numero, $numero->numero) !== 0 ) {

					$query.="
							AND numero > ".$numero->numero."";
				}

				//echo "consulta: ".$query;


					//echo $query;
					$BD->setQuery($query);
					$periodos = $BD->loadObjectList();

					$numFu = count($periodos);

					for ($j=0; $j < $numFu; $j++) { 

						$lista.= "<option value=\"".$periodos[$j]->id_periodo."\">".$periodos[$j]->mes."</option>";	
						
					}
				
			$lista.='										
				</select></td>	
			';

			$lista.=''.creaListaAnual($idind_secretaria,$frecuencia, $BD, $idfrecuencia,'NO').'';

			$lista.='
					<td>Valor:</td>
                    <td><input type=text placeholder="Ingresar Valor" name="valorIndicador" id="valorIndicador"></td>
			';



			//CAMPO OCULTO CON DETALLE DE INDICADOR 
			$lista.='<td><input type="hidden" name="frecuencia" id = "frecuencia" value="'.$idfrecuencia.'"></td></tr>';

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
			$valor.= '<td><input type=text placeholder="Ingresar Valor" name="valorIndicador" id="valorIndicador" size="12"></td>';


		}


		return $valor;




	
}



function crea_calendario($frecuencia, $BD, $idfrecuencia){


		$calendario ='<td>';
		$calendario.='Selecciona periodo '.$frecuencia.' :';
		$calendario.='</td><td>';


		//CAMPO OCULTO CON DETALLE DE INDICADOR 
		$calendario.='<input type="hidden" name="frecuencia" id = "frecuencia" value="'.$frecuencia.'">';


		//CREAR CALENDARIO 
		$calendario.= '
			
			Fecha: <input type="text" name="fecha" id ="campofecha" class="campofecha" size="12">

		';



		$calendario.='										
				</td>	
			';
			$calendario.='
					<td>Valor:</td>
                    <td><input type=text placeholder="Ingresar Valor" name="valorIndicador" id="valorIndicador"></td>
			';
			//CAMPO OCULTO CON DETALLE DE INDICADOR 
			$calendario.='<td><input type="hidden" name="frecuencia" id = "frecuencia" value="'.$idfrecuencia.'"></td>';





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