<?php
/*
    require_once('lib/class.database.php'); 
    require_once('lib/config.php');
    require_once('php/funciones.php');
    

    $BD = new database(_BD_SERVIDOR.':'._BD_PUERTO, _BD_USUARIO, _BD_PASSWORD );    

    //print_r($_POST['idContenido']);
*/
/*
    require_once('lib/class.database.php'); 
    require_once('lib/config.php');

    $db = new Db;



    $dsn = 'mysql:host=localhost;dbname=tablero';
    $nombre_usuario = 'root';
    $contraseña = 'iieg';
    $opciones = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ); 

    try{

        $con = new PDO($dsn, $nombre_usuario, $contraseña, $opciones);

    }catch(PDOException $e){

        echo "ERROR: " . $e->getMessage();

    }

$sql="SELECT *
        FROM adm_usuario ";


  //echo"<br>sql:".$sql;


    $Consulta = $con->prepare($sql);
    $Consulta->execute();
    $numrows = $Consulta->rowCount();   
      
        echo "rows: ".$numrows;
        */

            require_once('lib/db.php');
            $db =  new Db();


                $qry = "SELECT *
                        FROM adm_usuario";
                $rst = $db->query($qry) or die ($qry);
                while($row = $db->fetch_array($rst))
                {
                    echo "rom ".$row[1];
                }
            

?>
