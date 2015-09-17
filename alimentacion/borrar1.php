<!-- @ author Agustín Baraza (contacto@nosolocss.com)
	 @ Copyright 2013 nosolocss.com. All rights reserved
	 @ http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
	 @ link http://www.nosolocss.com */ -->

<!DOCTYPE html>
<html lang="es">
<head>
<title>Ejemplo Dialogos Emergentes</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
<link rel="stylesheet" href="../css/jquery-ui.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
</head>

<style type="text/css"> 




.boton {
	float:left;
	margin-right:10px;
	margin-top:200px;
	width:130px;
	height:40px;
	background:#222;
	color:#fff;
	padding:16px 6px 0 6px;
	cursor:pointer;
	text-align:center;
}

.boton:hover{color:#01DF01}

.ventana{

	display:none;      <!-- -------------------------> es importante ocultar las ventanas previamente -->
	font-family:Arial, Helvetica, sans-serif;
	color:#808080;
	line-height:28px;
	font-size:15px;
	text-align:justify;


}



</style>

<body> 
	<div class="contenido">
		<div id="b1" class="boton">Dialogo modal</div>
		<div id="b2" class="boton">Dialogo no modal</div>
		<div id="b3" class="boton">Otra animación</div>
	

		<div id="dialogo" class="ventana" title="Dialogo Modal">
			
			<p>Esto es un dialogo modal, por lo que la web queda bloqueada mientras esta abierta</p>
		
		</div>
		<div id="dialogo2" class="ventana"  title="Dialogo no modal">
			
			<p>Esto es un dialogo no modal, por lo que la web no queda bloqueada al abrir la ventana. También se pueden introducir fotos, videos o cualquer cosa en las ventanas. </p>
			<img src="jquery-mark-dark.gif" alt="jquery" />
		
		</div>
		<div id="dialogo3" class="ventana"  title="Otra animación">
			
			<p>Incluye multiples animaciones y opciones. Para cambiar la apariencia basta con modificar el css. Mas información en <a href="http://api.jqueryui.com/dialog/">http://api.jqueryui.com/dialog/</a></p>
		
		</div>
	</div>
	<script type="text/javascript"> 
	
		
$(document).ready(function(){ <!-- --------> ejecuta el script jquery cuando el documento ha terminado de cargarse -->
	$("#b1").click(function() { <!-- ------> al pulsar (.click) el boton 1 (#b1) -->
		$("#dialogo").dialog({ <!--  ------> muestra la ventana  -->
			width: 590,  <!-- -------------> ancho de la ventana -->
			height: 350,<!--  -------------> altura de la ventana -->
			show: "scale", <!-- -----------> animación de la ventana al aparecer -->
			hide: "scale", <!-- -----------> animación al cerrar la ventana -->
			resizable: "false", <!-- ------> fija o redimensionable si ponemos este valor a "true" -->
			position: "center",<!--  ------> posicion de la ventana en la pantalla (left, top, right...) -->
			modal: "true" <!-- ------------> si esta en true bloquea el contenido de la web mientras la ventana esta activa (muy elegante) -->
		});
	});
$("#b2").click(function() {
	$("#dialogo2").dialog({
			width: 590,
			height: 350,
			show: "scale",
			hide: "scale",
			resizable: "false",
			position: "center"		
		});
	});
$("#b3").click(function() {
		$("#dialogo3").dialog({
			width: 590,
			height: 350,
			show: "blind",
			hide: "shake",
			resizable: "false",
			position: "center"		
		});
	});
});
	
	
	</script>
	
</body>


</html>