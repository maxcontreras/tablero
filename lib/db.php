<?php
class Db
{
	//Link de conexión a la BD
	var $link = NULL;
	
	/**
	 * Constructor, se establece la conexión a la base de datos
	 *
	 * @return mixed This is the return value description
	 *
	 */
	 
	function Db()
	{

        $dsn = 'mysql:host=localhost;dbname=localhost_tablero';
        $nombre_usuario = 'root';
        $contraseña = '';
        $opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ); 

        try{

            $this->con = new PDO($dsn, $nombre_usuario, $contraseña, $opciones);

        }catch(PDOException $e){

            echo "ERROR: " . $e->getMessage();

        }

			          
	}
	function query ($qry)
	{
        $rst = $this->con->prepare($qry);
        $rst->execute();
		return $rst;
	}
	function fetch_array ($rst)
	{
        $row = $rst->fetch();
		return $row;
	}

	function num_rows ($rst)
	{
		$num = mssql_num_rows ($rst);
		return $num;
	}
        
        function generar_valor($qry)
        {
            $rst = mssql_query($qry) or die($qry);
            $row = mssql_fetch_array($rst);
            return $row[0];
        }

        function rellenar_combo($qry)
        {
            $rst = mssql_query($qry) or die ($qry);
            echo "<option value='-1'>Seleccione una opci&oacute;n</option>";
            while($row = mssql_fetch_array($rst))
            {
                echo "<option value='$row[value]'>".htmlentities($row['label'], ENT_QUOTES)."</option>";
            }
        }

        function rellenar_combo_default($qry, $default)
        {
            $rst = mssql_query($qry) or die ($qry);
            echo "<option value='-1'>Seleccione una opci&oacute;n</option>";
            while($row = mssql_fetch_array($rst))
            {
                if($row["value"]==$default)
                    echo "<option value='$row[value]' selected>".htmlentities($row['label'], ENT_QUOTES)."</option>";
                else
                    echo "<option value='$row[value]'>".htmlentities($row['label'], ENT_QUOTES)."</option>";
            }
        }
         function rellenar_combo_programa($qry, $default)
        {
            $rst = mssql_query($qry) or die ($qry);
            while($row = mssql_fetch_array($rst))
            {
                if($row["value"]==$default)
                    echo "<option value='$row[value]' selected>".htmlentities($row['label'], ENT_QUOTES)."</option>";
                else
                    echo "<option value='$row[value]'>".htmlentities($row['label'], ENT_QUOTES)."</option>";
            }
        }
}
?>
