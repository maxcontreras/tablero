<?php 
function verificaval($val) {
	$nada = "&nbsp;";
	$val = ($val != '' ? $val : $nada);
	return $val;
}

function verificasel($dato1,$dato2) {
	$sel = "selected";
	$resp = ($dato1 == $dato2 ? $sel : "");
	return $resp;
} 

?>
