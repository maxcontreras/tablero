<?php
session_start();
?>
  <!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <link rel="shortcut icon" href="../favicon.ico"> 
<link rel="stylesheet" type="text/css" href="css/inicio.css">
<link rel="stylesheet" type="text/css" href="css/layout.css">

<title>TABLERO INDICADORES</title>
<style type="text/css">
<!--
body {

  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
}

-->
</style>
</head>
<body>
<?php
@require ("php/main_valida.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}

$iduser = $_SESSION['usr'];


$qry = "SELECT * FROM adm_usuario WHERE id_usr = $iduser";
$rst = $con->prepare($qry);
    $rst->execute();
    $row = $rst->fetch();




  $queryMod = "SELECT
modulos.idmodulo,
modulos.modulo,
modulos.url,
adm_mod_usuario.id_mod_emp
FROM
modulos
Inner Join adm_mod_usuario ON modulos.idmodulo = adm_mod_usuario.idmodulo
where id_mod_emp = $iduser";
$queryMod = $con->prepare($queryMod);
$queryMod->execute();
$numMod = $queryMod->rowCount();



//echo "num ".$numMod;
  ?>
  <div id="header">
  <div id="barra">
    <div class="contenedor">
      <div id="nombreSes">
              <img src="images/circ_verde.png" width="8" height="8"/>
              <span class="link1">BIENVENIDO(A): <?php echo $row['nom'].' '.$row['ap_pat'].' '.$row['ap_mat']; ?></span>
             
      </div>        
            <div class="cerrarSesion">
                <a href="logout.php" class="link1">
                  <span class="link1">
                CERRAR SESION &nbsp;
                </span>
                  <img src="images/cerrar_sesion.png" width="29" height="30" class="vImagen"/>
                </a>
            </div>
      </div>
  </div>
  <div id="encabezado">
      <div class="contenedor">
          <div id="logo">
                
            </div>

        </div>
  </div>
</div>  

  


<div id="content">
  <div class="contenedor">
    <table width="70%" align="center" border="0">
      <tr>
        <td align="center" class="Estilo15"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="justify" class="Estilo13">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
      </tr>

    </table>

          <table border="0" width="75%" align="center">
       
            
              <?php
                  while($row = $queryMod->fetch())
                  {
                      echo "<tr><td>&nbsp;</td>";
                      echo "<td height='80' align='center'><a class='btnmodulos' href='submodulos.php?idmod=".$row['idmodulo']."'>$row[modulo]</a></td></tr>"; 

                      ?>
            
                      <?php
                        //echo "<a href='php/sesionEmp.php?id_emp=".$row['id_empresa']."&bd=".$row['bd']."'>".$row['empresa']."</a></br>";
                  }
          ?>
          </table>
  </div>
</div>
<div id="footer">
  <div id="pie">
    <div id="centro">
      <div id="logo">
          <img src="images/logo2.png" width="180" height="60" />
      </div>
      <div id="logoC">
        <img src="images/logo3.png" width="130" height="55" />
      </div>
    </div>  
  </div>
    <div class="contenedor">                
        <div class="cerrarSesion">
          <a href="logout.php" class="link1">
          <span class="link1">
          INSTITUTO DE INFORMACI&Oacute;N ESTAD&Iacute;STICA Y GEOGR&Aacute;FICA IIEG  | DERECHOS RESERVADOS 2015  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;             CERRAR SESION &nbsp;
          </span>
          <img src="images/cerrar_sesion.png" class="vImagen" />
          </a>  
        </div>
    </div>

</div>
</body>
</html>