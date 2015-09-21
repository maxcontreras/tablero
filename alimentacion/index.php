<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TABLERO DE INDICADORES</title>




<!-- Agrego silvia 01092015-->
<!-- Estilos de pestañas -->



<link href="../css/pestanias.css" type="text/css" rel="STYLESHEET">
<link href="../css/divsprincipales.css" type="text/css" rel="STYLESHEET">
<!-- lib requeridas -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/jquery.treeview.css" />
<link rel="stylesheet" href="../css/screen.css" />

<!-- JS -->
<script src="../lib/jquery_.js" type="text/javascript"></script>
<script src="../lib/jquery.treeview.js" type="text/javascript"></script>


<!-- librerias para las ventas jquery  -->
<link rel="stylesheet" href="../css/jquery-ui.css" />
<script src="../lib/jquery_ventanas/jquery.min.js" type="text/javascript"></script>
<script src="../lib/jquery_ventanas/jquery-ui.min.js" type="text/javascript"></script>


<!-- scripts de funciones ready -->
<script type="text/javascript" src="../js/document_ready.js"></script>
<script type="text/javascript" src="../js/funciones_alimentacion.js"></script>


<!--  FIN Agrego silvia 01092015-->



<!-- CSS -->
<link rel="stylesheet" type="text/css" href="../css/layout.css"> <!-- algunos estilos de las capas-->
<!--link rel="stylesheet" type="text/css" href="../css/Estilos.css"--><!-- quien los usa?-->




<script language="javascript">
  /* revisar si se puede quitar si ya no esta el iframe
    function crece(size) {  
    size = (typeof size == 'undefined' || typeof size == 'object') ? 45: size;

    var the_height= document.getElementById('detalle').contentWindow.document.body.scrollHeight;

      document.getElementById('detalle').height= the_height + size;
    }
        function creceDentro() {  
          var the_height = window.parent.document.getElementById('detalle').contentWindow.document.body.scrollHeight;
         // alert(the_height);
          window.parent.document.getElementById('detalle').height= the_height;
        }
    function creceMod(bodyHeight, fix) {  
      document.getElementById('detalle').height= bodyHeight + fix;
    }
   */ 

 


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
WHERE     (id_empresa = ?)  ";
//echo $sqlW;
$queryE = $con->prepare($sqlE);
$queryE->execute(array($_SESSION['id_emp']));
$rowE = $queryE->fetch();
?>
<div id="header">
  <div id="barra">
    <div class="contenedor"><!-- Esta clase esta en layout.css y solo maneja un width:1250px;  -->
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


<div id="contenido1"> <!-- esta en layout.css position: relative;  padding-top: 120px;-->
  <div id="contenedor_pestanias" name="contenedor_pestanias" class="resize">
   

          <div id="tabs" class="tabs">
              <ul class= "menu_tabs">
                  <li class= "menu_tabs"><a href="#tab-1" id="1">Alimentación</a></li>
              </ul>
              <div class="tabscontent">

                <div id="tab-1">
                  <div class="content1" id="content1">

                    <?php
                      include( '../alimentacion/menu_arbol.php' ); 
                    ?>
                                                    
                  </div>
                </div>
              </div>

          </div>
  </div>
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
