
<?php
	require_once('../lib/class.database.php');	
	require_once('../lib/config.php');
	global  $BD;
?>
<html>
<head>
<!-- Estilos de divs principales -->
<link href="../css/divsprincipales.css" type="text/css" rel="STYLESHEET">
<title>Alimentación</title>
</head>
<body>
<div id="contenedor">
<form id="formcaptura" class = "formcaptura" enctype="multipart/form-data">
<!--form id="formcaptura" class = "formcaptura" enctype="application/x-www-form-urlencoded"-->	
  <div id="menu" class="menu">
  	Indicadores:
  	<?php

       include( 'menu_arbol.php' ); 
    ?>
  </div>
  <div id="contenido_alimentacion">
    <div id='divresultado' class='divresultado'>resultado</div>
  </div>
</form>
</div>
</body>
</html>







  

