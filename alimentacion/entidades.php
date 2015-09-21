<?php
@require('../lib/conexion.php');

$sql = "SELECT id_periodo,periodo,mes FROM periodo";
$stmt = $con->prepare($sql);
$stmt->execute();
$entidades = $stmt->fetchAll();
$stmt->closeCursor();

if ( isset($_POST["submit"]) ) {
	if ( isset($_FILES["file"])) {
	    //if there was an error uploading the file
	    if ($_FILES["file"]["error"] > 0) {
	    	echo "Error: " . $_FILES["file"]["error"];
	    }
	    else {

	        //if file already exists
	        if (file_exists("../upload/" . $_FILES["file"]["name"])) {
	        	echo $_FILES["file"]["name"] . " ya existe. ";
	        }
	        else{
	            //Store file in directory "upload" with the name of "uploaded_file.txt"
	        	move_uploaded_file($_FILES["file"]["tmp_name"], "../upload/" . $_FILES["file"]["name"]);
	        
	        	$file = fopen( "../upload/".$_FILES["file"]["name"],'r');
	        	$firstline = fgets ($file, 4096 );
	        	$num = strlen($firstline) - strlen(str_replace(";", "", $firstline));

	        	$fields = array();
   				$fields = explode( ";", $firstline,($num+1));

   				$line = array();
    			$i = 0;

    			while ( $line[$i] = fgets ($file, 4096) ) {
			        $data[$i] = array();
			        $data[$i] = explode( ";", $line[$i], ($num+1) );
			        $i++;
			    }
				
				$query = "INSERT INTO calificacion_entidades 
				(entidad,calificacion,anio,id_periodo)
				VALUES
				(:entidad,:calificacion,:anio,:id_periodo)";
			    $stmt = $con->prepare($query);
				

			    foreach ($data as $key => $number) {
			    	foreach ($number as $k => $content) {
			    		$info = array(
			    			':entidad'=>utf8_encode($fields[$k]),
			    			':calificacion'=>$content,
			    			':anio'=>$_POST["year"],
			    			':id_periodo'=>$_POST["period"]
			    		);
		            	$stmt->execute($info);

		            	if($fields[$k] == "Jalisco"){
		            		$query_jalisco = "INSERT INTO valores 
							(idsecretaria,idind_secretaria,idindicador,iduser,anio_periodo,valor,id_periodo,fec_insert)
							VALUES
							(6,130,320,1,$_POST[year],$content,$_POST[period],CURDATE())";
						    $stmt_jalisco = $con->prepare($query_jalisco);
						    $stmt_jalisco->execute();
		            	}
		        	}
    			}

				$stmt->closeCursor();
    			
    			echo "Datos guardados!";
	        }
	    }
	}else{
	    echo "No hay archivos seleccionados.";
	}
}
?>

<html>
	<table width="600">
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" enctype="multipart/form-data">
			<tr>
				<td width="20%">Archivo</td>
				<td width="80%"><input type="file" name="file" id="file" /></td>
			</tr>
			<tr>
				<td width="20%">A&ntilde;o</td>
				<td width="80%">
					<select name="year">
						<option value="2005">2005</option>
						<option value="2006">2006</option>
						<option value="2007">2007</option>
						<option value="2008">2008</option>
						<option value="2009">2009</option>
						<option value="2010">2010</option>
						<option value="2011">2011</option>
						<option value="2013">2013</option>
						<option value="2014">2014</option>
						<option value="2015">2015</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="20%">Periodo</td>
				<td width="80%">
					<select name="period">
						<?php
						foreach ($entidades as $key => $entidad) {
							echo "<option value='$entidad[id_periodo]'>
									$entidad[periodo] - $entidad[mes]
								</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" /></td>
			</tr>
		</form>
	</table>
	<a href="csv.php">Descargar csv</a>
</html>