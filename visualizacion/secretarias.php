<?php
session_start();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TABLERO DE INDICADORES</title>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<script type="text/javascript" src="../js/script_jq.js"></script>
<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../js/ajax_ord.js"></script>
<script type="text/javascript" src="../highcharts/js/jquery.min.js"></script>
<script src="../highcharts/js/highcharts.js"></script>
<script src="../highcharts/js/modules/exporting.js"></script>
</head>

<body>
<?php
@require ("main_valida.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$iduser = $_SESSION['usr'];

$sqlW = "SELECT   id_usr,idsecretaria
FROM    adm_usuario
WHERE   (id_usr = ?)";
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


?>
<table  border="0" width="100%">
  <tr> 
    <td align="left" class="Estilo7">&nbsp; </td>
    <td align="left" class="Estilo18"> SECRETARIAS </td>
  </tr>     
</table> 
  <?php 

  $sql ="SELECT idsecretaria, secretaria FROM secretarias $where";

      $result = $con->prepare($sql);
      $result->execute();
      $numrows = $result->rowCount(); 
?>
<table align="center" width="100%" border="0">
 
<?php
  $count = 0;
  $bandera=false;
  while ($row = $result->fetch()){

    $count = $count + 1;
    $idsecretaria = $row['idsecretaria'];
   
/*
    if($bandera){
    echo"<tr  style='background: #ffffff;'>";
    $bandera=false;}
    else{
      echo"<tr  style='background: #dbdcdd;'>";
      $bandera=true;
    }
*/
    // onClick=\"if (this.checked){ sumar(this.value);   arreglo(); tamano();  } else { restar(this.value); arreglo();}\"  onmouseover='this.style.background=\"#D8D8D8\"' onmouseout='this.style.background=\"#ffffff\"'
    echo "<tr><td height=30 class='Estilo3 border3'   onClick='sendsecretaria($idsecretaria)' style='cursor:hand'  onmouseover='this.style.background=\"#D8D8D8\"' onmouseout='this.style.background=\"#ffffff\"'>
      $count.    &nbsp; $row[secretaria]</td>";
      
      
    echo"</tr>";


  }
?>
</table>
 <form name="oculto" action="viewtablero.php" method="get"  >
  <input type="hidden" id ="idsecretariaHi" name="idsecretaria" />
</form>
</body>
</html>