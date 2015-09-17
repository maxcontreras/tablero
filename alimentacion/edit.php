<?php
session_start();
?>
<?php
@require ("main_valida.php");

sleep(1);
$data = $_POST['value'];
$field = $_POST['field'];
$idind_secretaria 	= $_POST['idind_secretaria'];


$update = "UPDATE indicadores_secretarias  SET $field ='".$data."' WHERE idind_secretaria=$idind_secretaria";
//echo $update;
 $resulti = $con->prepare($update);
 $resulti->execute();

//echo $data;

?>