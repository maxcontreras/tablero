<?php
//global $PAG, $BD, $USUARIO;
class database {
     /*@autor Silvia Torres Naranjo y colaboradores
	/*variables propias*/
	/** @var string Internal variable to hold the query sql */
	var $_sql			= '';
	/** @var int Internal variable to hold the database error number */
	var $_errorNum		= 0;
	/** @var string Internal variable to hold the database error message */
	var $_errorMsg		= '';
	/** @var Internal variable to hold the connector resource */
	var $_resource		= '';
	/** @var Internal variable to hold the last query cursor */
	var $_cursor		= null;
	/** @var boolean Debug option */
	var $_debug			= 1;
	/** @var int The limit for the query */
	var $_limit			= 0;
	/** @var int The for offset for the limit */
	var $_offset		= 0;
	
	
	var $_nameQuote = '``';
	
	/*CONSTRUCTOR*/
	function database($host='localhost', $user, $pass) {

/*
		if (!function_exists( 'pdo' ))
			die('No esta configurado pdo');

		if (!($this->_resource = @mysql_connect( $host, $user, $pass ))) 							
			die('No se pudo realizar la conexion a la Base de Datos:::: '.$host);
		mysql_set_charset("utf8", $this->_resource);

*/


		 $dsn = 'mysql:host=localhost;dbname=tablero';
        $nombre_usuario = 'root';
        $contraseña = 'iieg';
        $opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ); 

        try{

            $this->_resource = new PDO($dsn, $nombre_usuario, $contraseña, $opciones);

        }catch(PDOException $e){

            echo "ERROR: " . $e->getMessage();

        }



	}
	
	/**
	* @return int EL NUMERO DE ERROR DE LA MAS RECIENTE CONSULTA(INT).
	*/

	function query($qry) {

		$rst = $this->_resource->prepare($qry);
        $rst->execute();
		return $rst;
	}

	function fetch_array ($rst){
	   	$row = $rst->fetch();
		//$row = mssql_fetch_array ($rst);
		return $row;
	}

	function getErrorNum() {
		return $this->_errorNum;
	}
	
	/**
	* @return string UN MENSAJE DE ERROR DE LA MAS RECIENTE CONSULTA(STRING).
	*/
	function getErrorMsg() {
		return str_replace( array( "\n", "'" ), array( '\n', "\'" ), $this->_errorMsg );
	}
	
	/**
	* @param CADENA  DE TEXTO
	* @return CADENA ESCAPADA PARA SER UTILIZADA EN UNA CONSULTA 
	*/
	function getEscaped( $text ) {
		return mysql_escape_string( $text );
	}
			
	/**
	* Establece las sentencias de una Transaccion 
	*
	*/
	function transaccion($accion, $identificador=""){
		switch ($accion) {
			//INICIO DE TRANSACCION 
			 case 'start':
				$this->_sql = "START TRANSACTION";   //establece la sentencia sql
				$this->query(); 					 //ejecuta la sentencia sql 	
				notice("TRANSACTION: START");
				break;
			 //ESTABLECE EL NIVEL DE BLOQUEO DE LA SESSION 
			 case 'setlevel':
				if(empty($identificador))
					error("no se establecio un nivel para la session de la transaccion");
				else {
					$this->_sql= "SET SESSION TRANSACTION ISOLATION LEVEL ".$identificador;
					$this->query();
					notice("TRANSACTION: SET LEVEL SESSION".$identificador);
				}
				break;
			 //ESTABLECE UN PUNTO PARA EL ROLLBACK
			 case 'setSavePoint':
				if(empty($identificador))
					error("no se puede establecer el punto para el rollback");
				else{
					$this->_sql="SAVEPOINT ".$identificador;
					$this->query();
					notice("TRANSACTION: SET SAVEPOINT".$identificador);
					}
			 break;
			 //CONFIRMACION DE TRANSACCION
			 case 'commit':
				$this->_sql="COMMIT";
				$this->query();
				notice("TRANSACTION: COMMIT");
			 break;
			 //ABORTAR 
			 case 'abort':
				debug("TRANSACTION: ABORT");
			 break;
			 // NO APLICAR TRANSACCION 
			 case 'rollback':
				//ER_WARNING_NOT_COMPLETE_ROLLBACK  REGRESAR ERRORES
				if(empty($identificador)){ 
					// DESHACE TRANSACCION COMPLETA
					$this->_sql ="ROLLBACK";  			
					$this->query();						
					notice("TRANSACTION: ROLLBACK");
				}else{
					// REGRESO DE TRANSACCION HASTA UN PUNTO
					$this->_sql="ROLLBACK TO SAVEPOINT ".$identificador;
					$this->query();
					notice("TRANSACTION: ROLLBACK AL PUNTO ".$identificador);
					//NOTA PENDIENTE REGRESAR ERROR CUANDO NO SE EXISTA NINGUN PUNTO OCN EL NOMBRE ESPECIFICADO 
					
				}
			 break;
			default:
				error("No especificaron un aaccion valida para la transaccion");
				return false;
			break;
		}
	}
	
			/**
			* Establece la consulta para despues la ejecución
			*
			* @param string sql consulta
			* @param string offset inicio de seleccion
			* @param string numero de resultados pata retornar  
			*/
			function setQuery( $sql, $offset = 0, $limit = 0) {
				$this->_sql= $sql;
				$this->_limit = intval( $limit );
				$this->_offset = intval( $offset );
			}
			
			/**
			* @return string el valor actual en la variable interna _sql
			*/
			function getQuery() {
//				return "<pre>" . htmlspecialchars( $this->_sql ) . "</pre>";
				return  htmlspecialchars( $this->_sql ) ;
			}
			/*
			* @return resource con los datos o False en caso de no porder ejecutar la consulta
			*/


			function explain() {
				$temp = $this->_sql;
				$this->_sql = "EXPLAIN $this->_sql";
				$this->query();
		
						if (!($cur = $this->query())) {
							return null;
						}
				$first = true;
		
				$buf = "<table cellspacing=\"1\" cellpadding=\"2\" border=\"0\" bgcolor=\"#000000\" align=\"center\">";
				$buf .= $this->getQuery();
				while ($row = mysql_fetch_assoc( $cur )) {
					if ($first) {
						$buf .= "<tr>";
						foreach ($row as $k=>$v) {
							$buf .= "<th bgcolor=\"#ffffff\">$k</th>";
						}
						$buf .= "</tr>";
						$first = false;
					}
					$buf .= "<tr>";
					foreach ($row as $k=>$v) {
						$buf .= "<td bgcolor=\"#ffffff\">$v</td>";
					}
					$buf .= "</tr>";
				}
				$buf .= "</table><br />&nbsp;";
				mysql_free_result( $cur );
				
				$this->_sql = $temp;
		
				return "<div style=\"background-color:#FFFFCC\" align=\"left\">$buf</div>";
			}
			
			
			/** 20DIC2011**/
			/*
			 FUNCION OBTIENE EL TEMA APARTIR DE UN SUBTEMA (IDSUBTEMA) 
			*/

			function obtenerTema($IdSubtema){
				
				$query='
						SELECT t.tema, t.IdTema
						FROM '._TBL_SUBTEMA.' s
						LEFT JOIN '._TBL_TEMASUBTEMA.' ts
						ON s.IdSubtema = ts.IdSubtema
						LEFT JOIN '._TBL_TEMA.' t
						ON ts.IdTema = t.IdTema
						where s.IdSubtema = "'.$IdSubtema.'";
				
				';
				
					
					$this->setQuery( $query );	
					if (!$this->query()) {
						return false;
					}else{
						$registros = $this->loadObjectList();
						return $registros;
					}
			
				}
			/*
				FUNCTION OBTENER CONSULTAS DINAMICAS
				LIMITA A LOS 5 ESPACIOS DISPONIBLES 
			*/
			function obtieneRegSeccion($IdSeccion){
					$query='
					SELECT c.`Titulo`, c.`Descripcion`, c.`liga`,c.`imagen`
					FROM '._TBL_CONTENIDO.' c
					WHERE c.IdSeccion = '.$IdSeccion.'
					ORDER BY posicion
					LIMIT 5
					';
//	echo $query;
					$this->setQuery( $query );	
					if (!$this->query()) {
						return false;
					}else{
						$registros = $this->loadObjectList();
						return $registros;
					}
				}
				
			/* 
				FUNCION AMARRADA A LA POSICION MIENTRAS SE RESUELVE LO DE LAS PUBLICACIONES EXTERNAS 
				FUNCTION OBTENER CONSULTAS DINAMICAS
				LIMITA A LOS 5 ESPACIOS DISPONIBLES  
			*/
			function obtieneRegSeccionM($IdSeccion){
					/* OJO SILVIA SE actualizo ESTA FUNCION a estandares*/
								
				$query='
					SELECT c.titulo as Titulo, c.descripcion as Descripcion, c.liga, c.imagen, c.fecha_descripcion as Fecha
					FROM '._TBL_CONTENIDO.' c
					WHERE c.seccion_id = '.$IdSeccion.'
					AND posicion is not null
					ORDER BY posicion
					LIMIT 5
				';
				//	echo $query;
					$this->setQuery( $query );	
					if (!$this->query()) {
						return false;
					}else{
						$registros = $this->loadObjectList();
						return $registros;
					}
				}
				
				
				
				
			/*
				FUNCION QUE OBTIENE DATOS DE LOS BANNER DE LA PLANTILLA PRINCIPAL 
			*/
			function obtenerbanners(){
			
				$query ='
					SELECT b.`Titulo`, b.`Imagen`, b.`liga`, b.`status`
					FROM '._TBL_BANNERS.' b
					WHERE status = \'P\'
					ORDER BY posicion
				';
				
			
					$this->setQuery( $query );	
					if (!$this->query()) {
						return false;
					}else{
						$registros = $this->loadObjectList();
						return $registros;
					}
			}				
			
			
			
			
			/*FUNCION OBTIENE LOS TEMAS Y SUS HIJOS HASTA EL CONTENIDO O LIGA DEL MENU GRAL*/
			function obtener_MenuGral (){
				$query='
				SELECT t.`IdTema`, t.`tema`,t.clasificacion, p.`IdSubtema` AS idPadre, p.`subtema`as SubtemaPadre,
				 h.IdSubtema As idHijo, h.subtema as SubtemaHijo,h.orden,c.`IdContenido`
				FROM '._TBL_TEMA.' t
				LEFT JOIN '._TBL_SUBTEMA.' p
				ON t.IdTema = p.IdTema
				LEFT JOIN '._TBL_SUBTEMA.' h
				ON h.padre = p.IdSubtema
				LEFT JOIN '._TBL_CONTENIDO.' c
				ON h.IdSubtema = c.IdSubtema
				WHERE h.IdSubtema IS NOT NULL
				ORDER BY p.padre,h.padre, h.orden
				';
				
				
					$this->setQuery( $query );	
					if (!$this->query()) {
						return false;
					}else{
						$registros = $this->loadObjectList();
						return $registros;
					}

				
			}
			
			
			/*FUNCION OBTIENE LOS TEMAS Y SUS HIJOS HASTA EL CONTENIDO O LIGA DEL MENU SNIEG*/
			function obtener_MenuSnieg(){
				$query='
				SELECT t.`IdTema`, t.`tema`,t.clasificacion, p.`IdSubtema` AS idPadre, p.`subtema`as SubtemaPadre,
				 h.IdSubtema As idHijo, h.subtema as SubtemaHijo,h.clasificacion,h.orden,c.`IdContenido`
				FROM '._TBL_TEMA.' t
				LEFT JOIN '._TBL_SUBTEMA.' p
				ON t.IdTema = p.IdTemaSNIEG
				LEFT JOIN '._TBL_SUBTEMA.' h
				ON h.padre = p.IdSubtema
				LEFT JOIN '._TBL_CONTENIDO.' c
				ON h.IdSubtema = c.IdSubtema
				WHERE h.IdSubtema IS NOT NULL
				AND h.clasificacion =\'snieg\'
				ORDER BY t.`IdTema`,p.padre,h.padre, h.orden
				';
				
				
					$this->setQuery( $query );	
					if (!$this->query()) {
						return false;
					}else{
						$registros = $this->loadObjectList();
						return $registros;
					}

				
			}
			

			/*FUNCION QUE OBTIENE ARBOL DE TEMAS*/
			function obtener_temas_subtemas(){
				$query='
						SELECT t.`IdTema`, t.`tema`, p.`IdSubtema` AS idPadre, p.`subtema`as SubtemaPadre,
						h.IdSubtema As idHijo, h.subtema as SubtemaHijo,h.orden
						FROM '._TBL_TEMA.' t
						LEFT JOIN '._TBL_SUBTEMA.' p
						ON t.IdTema = p.IdTema
						LEFT JOIN '._TBL_SUBTEMA.' h
						ON h.padre = p.IdSubtema
						WHERE h.IdSubtema IS NOT NULL
						ORDER BY p.padre,h.padre, h.orden;
				';
			
						$this->setQuery( $query );	
						if (!$this->query()) {
							return false;
						}else{
							$registros = $this->loadObjectList();
							return $registros;
						}
			
			}
	

			
			/*FUNCION QUE OBTIENE TEMAS Y SUBTEMAS DEPENDIENDO DE LA DEPENDENCIA */	
			function obtener_ts_porperfil($iddependencia){
					$query = '
						SELECT t.`IdTema`, t.`tema`, p.`IdSubtema` AS idPadre, p.`subtema`as SubtemaPadre,
						h.IdSubtema As idHijo,
						h.subtema as SubtemaHijo,h.orden,
						h.subtema as SubtemaHijo,c.`IdContenido`, f.dependencia
						FROM '._TBL_TEMA.' t
						LEFT JOIN '._TBL_SUBTEMA.' p
						ON t.IdTema = p.IdTema
						LEFT JOIN '._TBL_SUBTEMA.' h
						ON h.padre = p.IdSubtema
						LEFT JOIN '._TBL_CONTENIDO.' c
						ON h.IdSubtema = c.IdSubtema
						LEFT JOIN  '._TBL_FUENTE.' f
						ON c.`IdFuente` = f.IdFuente
						WHERE h.IdSubtema IS NOT NULL
						AND f.IdFuente ='.$iddependencia.'
						ORDER BY p.padre,h.padre, h.orden
					';
					
					
		
						$this->setQuery( $query );	
						$registros = $this->loadObjectList();
						
						return $registros;
					
					
			
			}

			/**
			* @return int el numero de registros retornados por la mas reciente consulta.
			*/
			function getNumRows( $cur=null ) {
				return mysql_num_rows( $cur ? $cur : $this->_cursor );
			}
			
			
			/**
			* @return  EL VALOR DEL PRIMER CAMPO DEL PRIMER REGISTRO RETORNADO POR LA CONSULTA O NULL SI  ES FALLIDA LA CONSULTA
			*/
			function loadResult() {
				if (!($cur = $this->query())) {
					return null;
				}
				$ret = null;
				if ($row = mysql_fetch_row( $cur )) {
					$ret = $row[0];
				}
				mysql_free_result( $cur );
				return $ret;
			}
			/**
			* Load an array of single field results into an array
			*
			*@param int NUMERO DE POSICION DEL CAMPO QUE SE DESEE QUE REGRESE , POR DEFAULT TOMA EL 0
			*@return REGRESA UN ARREGLO CON LOS DATOS DEL CAMPO QUE SE ENVIO POR PARAMETRO
			*/
			function loadResultArray($numinarray = 0) {
				if (!($cur = $this->query())) {
					return null;
				}
				$array = array();
				while ($row = mysql_fetch_row( $cur )) {
					$array[] = $row[$numinarray];
				}
				mysql_free_result( $cur );
				return $array;
			}
			
			/**
			* @return REGRESA UN ARREGLO CON LOS DATOS DEL PRIMER REGISTRO DE LA CONSULTA EJECUTADA.
			*/
			
			function loadRow() {
				if (!($cur = $this->query())) {
					return null;
				}
				$ret = null;
				if ($row = mysql_fetch_row( $cur )) {
					$ret = $row;
				}
				mysql_free_result( $cur );
				return $ret;
			}
			
			/**
			* @return REGRESA UN OBJETO CON LOS DATOS DEL PRIMER REGISTRO DE LA CONSULTA EJECUTADA.
			*/
			
			function loadObject() {
				if (!($cur = $this->query())) {
					return null;
				}
				$ret = null;
				
				//if ($row = mysql_fetch_object( $cur )) {
				if ($row = $cur->fetch(PDO::FETCH_OBJ)) {
					$ret = $row;
				}
				//mysql_free_result( $cur );
				$cur->closeCursor();
				return $ret;
			}
			/**
			* Carga una lista de Objetos de una base de datos
			* @param NOMBRE DE CAMPO O LLAVE PRIMARIA POR DEFAUL TOMA  ''
			* @return REGRESA UN ARRAY  DE OBJETOS CON INDEX SECUENCIAL SI KEY ES VACIA SI NO REGRESA UN ARRAY CON EL INDEX DEL VALOR DEL KEY
						  CON LOS DATOS DE LA CONSULTA	
			*/
			
			function loadObjectList( $key='' ) {
				if (!($cur = $this->query())) {
					return null;
				}
				$array = array();
				while ($row = mysql_fetch_object( $cur )) {
					if ($key) {
						$array[$row->$key] = $row;
					} else {
						$array[] = $row;
					}
				}
				mysql_free_result( $cur );
				return $array;
			}
					
					
			/**
			* Load a list of database rows (numeric column indexing)
			* Carga una lista de registros de un bd 
			* @param string NOMBRE DE CAMPO O LLAVE PRIMARIA POR DEFAUL TOMA  ''
			* @return  REGRESA UN ARRAY DE ARRAY CON INDEX SECUENCIAL SI KEY ES VACIA SI NO REGRESA UN ARRAY CON EL INDEX DEL VALOR DEL KEY
						  CON LOS DATOS DE LA CONSULTA		
			*/
			
			function loadRowList( $key='' ) {
				if (!($cur = $this->query())) {
					return null;
				}
				$array = array();
				while ($row = mysql_fetch_array( $cur )) {
					if ($key) {
						$array[$row[$key]] = $row;
					} else {
						$array[] = $row;
					}
				}
				mysql_free_result( $cur );
				return $array;
			}
			
			/**
			* Document::db_insertObject()
			* @param
			* @param string NOMBRE DE LA TABLA A LA QUE SE VA A INSERTAR LOS DATOS
			* @param object OBJETO CON DATOS QUE SE VA A INSERTAR
			* @param String NOMBRE DEL CAMPO LLAVE POR DEFAULT TIENE NULL
			* @param Boolean BANDERA PAAR EJECUTAR LA INSERCCION
			*
			* @return TRUE  SI SE REALIZA LA INSERCCION
			*		  FALSE	SI NO SE REALIZA LA INSERCCION
			*/
			
			function insertObject( $table, &$object, $keyName = NULL, $verbose=false ) {
				$fmtsql = "INSERT INTO $table ( %s ) VALUES ( %s ) ";
				$fields = array();
					foreach (get_object_vars( $object ) as $k => $v) {
							if (is_array($v) or is_object($v) or $v === NULL) {
								continue;
							}
							if ($k[0] == '_') { // internal field
								continue;
							}
								$fields[] = $this->NameQuote( $k );;
								$values[] = $this->Quote( utf8_decode( $v ) );  // entre comillas
					}
					//$this->setQuery( sprintf( $fmtsql, implode( ", ", $fields ) ,  strtoupper(implode( ", ", $values )) ) ); //modifique paar que inserte en mayusculas
					$consulta = sprintf( $fmtsql, implode( ", ", $fields ) ,  implode( ", ", $values ) );
//					debug('consulta InsertObject '.$consulta);
					$this->setQuery( sprintf( $fmtsql, implode( ", ", $fields ) ,  implode( ", ", $values ) ) ); //modifique paar que inserte en mayusculas				
					($verbose) && print "$sql<br />\n";
					if (!$this->query()) {
						return false;
					}
						$id = mysql_insert_id( $this->_resource );
						($verbose) && print "id=[$id]<br />\n";
					if ($keyName && $id) {
						$object->$keyName = $id;
					}
					return true;
			}
		
			/*
			*	INSERT ON DUPLICATE KEY OBJECT 
			*/
			function insertUpdateObject($table, &$object, $keyName){
							$query= "
									  INSERT INTO $table SET 
							";
							foreach(get_object_vars($object) as  $c => $v){
									$query.= $this->NameQuote($c) ."= ".$this->Quote(utf8_decode($v)).",";
							}
			
							$query= substr($query,0,strlen($query)-1);
							
							$query.=" ON DUPLICATE KEY UPDATE";
							foreach(get_object_vars($object) as $c => $v){
									if($c != $keyName)
									$query.= $this->NameQuote($c)."= ".$this->Quote(utf8_decode($v)).",";
							}
						
							$query= substr($query,0,strlen($query)-1);
							debug('consulta onDuplicateKey: '.$query);
						
							$this->setQuery($query);
							if (!$this->query()) {
								return false;
							}
							$id = mysql_insert_id( $this->_resource );
						($verbose) && print "id=[$id]<br />\n";
					if ($keyName && $id) {
						$object->$keyName = $id;
					}
							return true;
			}

		
			/**
			* Document::db_updateObject()
			* @param
			* @param string NOMBRE DE LA TABLA A LA QUE SE VA A INSERTAR LOS DATOS
			* @param object OBJETO CON DATOS QUE SE VA A INSERTAR
			* @param String NOMBRE DEL CAMPO LLAVE POR DEFAULT TIENE NULL
			* @param Boolean BANDERA PAAR EJECUTAR LA INSERCCION
			*
			* @return TRUE  SI SE REALIZA LA INSERCCION
			*		  FALSE	SI NO SE REALIZA LA INSERCCION
			*/
			
			function updateObject( $table, &$object, $keyNames, $updateNulls=true ) {
				$fmtsql = "UPDATE $table SET %s WHERE %s";

				$tmp = array();
				$keyName = explode(",",$keyNames);
				$where = '';
				foreach( $keyName as &$key )
					$key = trim( $key );
				foreach (get_object_vars( $object ) as $k => $v) {					
					if( is_array($v) or is_object($v) or $k[0] == '_' ) { // internal or NA field
						continue;
					}
					if( in_array( $k, $keyName ) ) { // PK not to be updated
						$where .= ($where?' AND ':' ').$k . '=' . $this->Quote( utf8_decode($v) );
						continue;
					}
					if ($v === NULL && !$updateNulls) {
						continue;
					}
					if( $v == '' ) {
						$val = "''";
					} else {
						$val = $this->Quote( utf8_decode($v) );
					}
					$tmp[] = $this->NameQuote( $k ) . '=' . $val;
				}
				$c=  sprintf( $fmtsql, implode( ", ", $tmp ), $where );				
				$this->setQuery( sprintf( $fmtsql, implode( ", ", $tmp ), $where ) );

				//echo "consulta update: ".$c."</br>";
				return $this->query();
			}
						
			/**
			* @param boolean BANDERA QUE DETERMINA SI REGRESA O NO
			* @return string MENSAJE Y NUM DE ERROR
			*/
			function stderr( $showSQL = false ) {
				return "DB function failed with error number $this->_errorNum"
				."<br /><font color=\"red\">$this->_errorMsg</font>"
				.($showSQL ? "<br />SQL = <pre>$this->_sql</pre>" : '');
			}
			
			/**
			* 
			* @return int  EL ID DEL ULTIMO REGISTRO INSERTADO
			*/
			
			function insertid() {
				return mysql_insert_id( $this->_resource );
			}
		
			/**
			* 
			* @return string  LA VERSION DEL MYSQL UTILIZADO
			*/
			function getVersion() {
				return mysql_get_server_info( $this->_resource );
			}
		
			/**
			 * @param array ARREGLO DE CON EL NOMBRE DE LAS TABLAS
			 * @return array UNA ARREGLO DE ARREGLOS CON LOS CAMPOS DE LAS TABLAS
			 */
			function getTableFields( $tables ) {
				$result = array();
				foreach ($tables as $tblval) {
					$this->setQuery( 'SHOW FIELDS FROM ' . $tblval );
					$fields = $this->loadObjectList();
					foreach ($fields as $field) {
						$result[$tblval][$field->Field] = preg_replace("/[(0-9)]/",'', $field->Type );
					}
				}
		
				return $result;
			}
			
			function getNumRegistros(){
					if($this->_resource){
						$num = mysql_num_rows($cur = $this->query());
						return $num;
					}else{
						return false;
					}
			}
			
			
			/**
			 * Quote an identifier name (field, table, etc)
			 * @param string The name
			 * @return string The quoted name
			 */
			function NameQuote( $s ) {
				$q = $this->_nameQuote;
				if (strlen( $q ) == 1) {
					return $q . $s . $q;
				} else {
					return $q{0} . $s . $q{1};
				}
			}
			/**
			* Get a quoted database escaped string
			* @return string
			*/
			function Quote( $text ) {
				return '\'' . $this->getEscaped( $text ) . '\'';
			}
			


/***METODOS AGREGADOS***/
			/**
			 * 
			 * @return INT NUMERO DE REGISTROS AFECTADOS O FALSE EN CASO CONTRARIO
			 */ //lista
			function sql_affectedrows(){
				if($this->_resource){
					$result = mysql_affected_rows($this->_resource);
					return $result;
				}else{
					return false;				
				}
			}

			/**
			 * 
			 * @return INT NUMERO DE CAMPOS DEL RESULTADO DE UNA CONSULTA ANTERIOR
			 */
			function sql_numfields()
			{
				if($this->_resource)
				{
					$result = mysql_num_fields($this->query());
					return $result;
				}
				else
				{
					return false;
				}
			}


			/**
			 * 
			 * @return NOMBRE DE CAMPOS DEL RESULTADO DE UNA CONSULTA ANTERIOR
			 */
			function sql_fieldname($offset)
			{
				if($this->_resource)
				{
					$result = @mysql_field_name($this->query(),$offset);
					return $result;
				}else{
					return false;
				}
			}

			/**
			 * 
			 * @return string CON EL TIPO DE LOS CAMPOS DEL RESULTADO DE UNA CONSULTA ANTERIOR
			 */
			function sql_fieldtype($offset)
			{
				if($this->_resource)
				{
					$result = @mysql_field_type($this->query(), $offset);
					return $result;
				}
				else
				{
					return false;
				}
			}
			
			/**
			 * @param $rownum = num de campo
			 * @return SE DESPLAZA HASTA LA FILA DE RESULTADOS ESPECIFICADA
			 *//*falta probar */
		
			function sql_rowseek($rownum){
				
				if($this->_resource)
				{
					$result = mysql_data_seek($this->query(), $rownum);
					return $result;
				}
				else
				{
					return false;
				}
			}


			/**
			 * 
			 * @return TRUE SI LIBERA EL ESPACIO DE MEMORIA
			 */
		
			function sql_freeresult(){
			
				if ( $this->_resource )
				{
					@mysql_free_result($this->query());
					return true;
				}
				else
				{
					return false;
				}
			}
			/**
			*@param query_id 
			*@return TRUE SI LIBERA EL ESPACIO DE MEMORIA
			*/
			   function fieldLen($offset) {
				if ( $this->_resource ){
					     return @mysql_field_len($this->query, $fieldIndex);
	 				}else{
						 return false;
					}
			   }
			   
/**	funciones SQL ***/		
			/**
			*@param $id VALOR DEL CAMPO  A BORRAR 
			*@param $idFieldName STRING NOMBRE DEL CAMPO REALCIONADO PARA BORRAR
			*@param $table string NOMBRE DE LA TABLA  A AFECTAR 
			*@return REGISTROS AFECTADOS
			*/
			   function erase($id, $idFieldName, $table) {
						if ( $this->_resource ){
								 $sql = "DELETE FROM $table WHERE $idFieldName = ".$this->Quote( $id );
								 $this->setQuery($sql);
								 if ( $this->query() ) 
								 	return $this->sql_affectedrows();
								else
								 	return false;
						}else{
							error("No hay una conexion con la BD");
							return false;
						}
			   }

			/**
			*@param $array ARRAY DE VALORES DEL CAMPO  A BORRAR 
			*@param $idFieldName STRING NOMBRE DEL CAMPO REALCIONADO PARA BORRAR
			*@param $table string NOMBRE DE LA TABLA  A AFECTAR 
			*@return TRUE SI LIBERA EL ESPACIO DE MEMORIA
			*/
			
		function erases($array, $idFieldName, $table) {		
			if($this->_resource){
				sort($array); //ordena en forma ascendente
				$array_ids = join(", ",$array);
				$sql = "DELETE FROM $table WHERE $idFieldName IN ($array_ids)";
				$this->setQuery($sql);
				if ( $this->query() ) 
					return $this->sql_affectedrows();
				else
					return false;
			}
			else{
				return false;
			}
		
		}
			
	
/****/
	 
	 
	 /*
	 *	FUNCION VERIFICA EL TIPO DE UN PARAMETRO
	 */
	 function get_type($param, $tipo){
	 			if(gettype($param)==$tipo)
					return true;
				else
					return false;
	 }
	 /*
	 *	FUNCION VERIFICA LA LONGITUD DE UN PAARMETRO
	 */
	 function get_leng($param){
			$tamanio = strlen($param);	 
		if($tamanio > 0)
			return false;
		else
			return true;			
	 }
	 
	 /**
	  * ESTE METODO SIRVE PARA CONCATENAR TODOS LOS ARGUMENTOS RECIBIDOS
	  * 
	  */
	 function concat_ws(){
	 	$num_args = func_num_args();
		
		// DOS CAMPOS Y EL SEPARADOR
		if( $num_args < 3 )
			return "";			
		else {
			$args = func_get_args();
			$separador = $args[0];
			unset($args[0]);
			return "CONCAT_WS($separador, ".implode(", ", $args).")";		
		}
		
	 }
	 
	 /**
	  * ESTE METODO SIRVE PARA CONCATENAR TODOS LOS ARGUMENTOS RECIBIDOS
	  * 
	  */
	 function concat(){
	 	$num_args = func_num_args();
		
		// DOS CAMPOS Y EL SEPARADOR
		if( !$num_args )
			return "";		
		$args = func_get_args();
		return "CONCAT(".implode(", ", $args).")";		
	 }
	  /**
	  * ESTE METODO SIRVE PARA CONCATENAR TODOS LOS ARGUMENTOS RECIBIDOS
	  * 
	  */
	 function date_format( $fecha, $formato=_BD_FORMATO_FECHA ){
	 	if( !$fecha || !$formato ){
			error("faltan parametros para darle formato a la fecha. ");
			return "";
		}
		return 'DATE_FORMAT('.$fecha.', "'.$formato.'")';		
	 }	
}//find e clase
	//Versiones anteriores de PHP
	if (!function_exists('mysql_set_charset')) {
	  function mysql_set_charset($charset,$dbh)
	  {
		return mysql_query("set names $charset",$dbh);
	  }
	}
?>
