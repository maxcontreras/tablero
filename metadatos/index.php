<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TABLERO DE INDICADORES</title>
 <link rel="stylesheet" href="../css/navigator.css">
<link rel="stylesheet" type="text/css" href="../css/layout.css">
<link rel="stylesheet" type="text/css" href="../css/menu.css">
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
<script language="javascript">
function crece(size) {  
    size = (typeof size == 'undefined' || typeof size == 'object') ? 10: size;
    var the_height= document.getElementById('detalle').contentWindow.document.body.scrollHeight;
    document.getElementById('detalle').height= the_height + size;
}
function creceMod(bodyHeight, fix) {  
    document.getElementById('detalle').height= bodyHeight + fix;
}

</script>
</head>
<body>
<?php
@require ("main_valida.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$m = $_GET['m'];
$iduser = $_SESSION['usr'];
$idmod = $_SESSION['idmod'];

$sqlW = "SELECT     nom, ap_pat, ap_mat, id_usr
FROM    adm_usuario
WHERE   (id_usr = ?)";
//echo $sqlW;
$queryH = $con->prepare($sqlW);
$queryH->execute(array($_SESSION['usr']));
$rowH = $queryH->fetch();

$sqlE = "SELECT   empresa
FROM         adm_empresa
WHERE     (id_empresa = ?)	";
//echo $sqlW;
$queryE = $con->prepare($sqlE);
$queryE->execute(array($_SESSION['id_emp']));
$rowE = $queryE->fetch();
?>
<div id="header">
  <div id="barra">
    <div class="contenedor">
      <div id="nombreSes">
              <img src="../images/circ_verde.png" width="8" height="8"/>
              <span class="link1">BIENVENIDO(A)</span>             
      </div>        
            <div class="cerrarSesion">
                <a href="../logout.php" class="link1">
                  <span class="link1">
                CERRAR SESION &nbsp;
                </span>
                  <img src="../images/cerrar_sesion.png" width="29" height="30" class="vImagen"/>
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


<div id="content1">
  <div class="contenedor">
   <iframe id="detalle" width="100%" border="1" onload="crece(this)" frameborder="0" name="detalle" src="-----.php"></iframe> 
  </div>
</div>



<div id="footer">
  <div id="pie">
    <div id="centro">
      <div id="logo">
          <img src="../images/logo2.png" width="180" height="60" />
      </div>
      <div id="logoC">
        <img src="../images/logo3.png" width="130" height="55" />
      </div>
    </div>  
  </div>
  <div class="contenedor">                
        <div class="cerrarSesion">
          <a href="../logout.php" class="link1">
          <span class="link1">
          INSTITUTO DE INFORMACI&Oacute;N ESTAD&Iacute;STICA Y GEOGR&Aacute;FICA IIEG  | DERECHOS RESERVADOS 2015  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;             CERRAR SESION &nbsp;
          </span>
          <img src="../images/cerrar_sesion.png" class="vImagen" />
          </a>  
        </div>
    </div>

</div>
</body>
</html>
