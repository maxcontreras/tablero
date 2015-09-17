<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<link rel="stylesheet" href="../css/navigator.css">
<link rel="stylesheet" type="text/css" href="../css/layout.css">
<link rel="stylesheet" type="text/css" href="../css/menu.css">
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
  <link rel="stylesheet" href="../css/jquery.treeview.css" />
  <link rel="stylesheet" href="../css/screen.css" />
  <script src="../js/jquery.js" type="text/javascript"></script>
  <script src="../js/jquery.cookie.js" type="text/javascript"></script>
  <script src="../js/jquery.treeview.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
      $("#browser").treeview();
    });
    function cargaCont(contID){     
        //Mensaje
    document.getElementById('contrato').src = "contrato.php?idContrato=" + contID;
    }
    function crece(size) {  
      size = (typeof size == 'undefined' || typeof size == 'object') ? 45: size;
      var the_height= document.getElementById('detalle').contentWindow.document.body.scrollHeight;
      document.getElementById('detalle').height= the_height + size;
}
    function creceDentro() {  
      var the_height = window.parent.document.getElementById('detalle').contentWindow.document.body.scrollHeight;
      window.parent.document.getElementById('detalle').height= the_height;
    }
    function muestraGranDiv(){
      document.getElementById('main').style.visibility = "visible";
      document.getElementById('cargando').style.visibility = "hidden";
    }

    $("a.cargar").live('click', function(event){
     event.preventDefault();
     var url = $(this).attr("href");
     var div = "#"+$(this).attr("name");
     $(div).load(url);
     return false;
});

  </script>
<style>
#izq{
  width:35%;
  float:left;
  /*border: 1px solid #B02320; */

}
a:link{
  text-decoration:none;
  
}
</style>    
<?php
@require ("main_valida.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$iduser = $_SESSION['usr'];

?>

<div id="alta"></div>
<div id="izq">
 
    <ul id="browser" class="filetree">
    <?php

    $sqlW = "SELECT   id_usr, idsecretaria FROM adm_usuario WHERE   (id_usr = ?)";
  //echo $sqlW;
  $queryH = $con->prepare($sqlW);
  $queryH->execute(array($_SESSION['usr']));
  $rowH = $queryH->fetch();

  $where = "";
  if ($rowH['idsecretaria'] == 99){
    $where = "";
  } else {
    $where = " WHERE idsecretaria IN ($rowH[idsecretaria])";
   } 



    $queryEj = $con->prepare("SELECT idsecretaria, secretaria FROM secretarias $where");
    $queryEj->execute();
    while($rowEj = $queryEj->fetch()){ 
      $idsecretaria = $rowEj['idsecretaria'];
  ?>
      <li class="closed" align="left"><span class="folder"  onclick="creceDentro()"><?php echo $rowEj['secretaria']; ?></span>
               <ul>
              <?php
        $queryProg = $con->prepare("SELECT distinct indicadores_secretarias.idtpo_indicador, tpo_indicador  
          FROM indicadores_secretarias 
          LEFT JOIN tpo_indicador ON tpo_indicador.idtpo_indicador = indicadores_secretarias.idtpo_indicador
         WHERE idsecretaria = ?");
        $queryProg->execute(array($idsecretaria));
        while($rowProg = $queryProg->fetch()){ 
          $idtpo_indicador = $rowProg['idtpo_indicador'];
        ?>
          <li class="closed"><span class="folder" onclick="creceDentro()"><?php echo utf8_encode($rowProg['tpo_indicador']); ?></span>
            <ul>
                        <?php
            $queryCont = $con->prepare("SELECT indicadores.idindicador, indicadores.indicador, indicadores_secretarias.idind_secretaria FROM indicadores_secretarias 
              LEFT JOIN indicadores ON indicadores.idindicador = indicadores_secretarias.idindicador
              WHERE idtpo_indicador = ? AND idsecretaria = ?");
            $queryCont->execute(array($idtpo_indicador, $idsecretaria));
            while($rowCont = $queryCont->fetch()){ 
              $idind_secretaria = $rowCont['idind_secretaria'];
            ?>
                          <li class="closed"><span class="file"><a href="alta.php?idind_secretaria=<?php echo $idind_secretaria; ?>" title="Formulario" class="cargar" name="alta"><?php echo $rowCont['indicador']; ?></a></span>

                              
                            </li>
                        <?php
            }
            ?>
                        </ul>
          </li>
              <?php
        }
        ?>
        </ul>
        </li>
  <?php
    }
  ?>  
  </ul>
 </div>  

