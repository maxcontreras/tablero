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
<!-- icono de refresh -->
<!--link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"-->
<!-- tablas -->
<!-- funcion auto ajusta la capa -->
<script type="text/javascript">


</script>
</head>
<body>
<div id="contenedor">
<form id="formcaptura" class = "formcaptura" enctype="multipart/form-data">
<!--form id="formcaptura" class = "formcaptura" enctype="application/x-www-form-urlencoded"-->	
  <div id="menu" class="menu">
  	aqui menu
  	<?php

       include( 'menu_arbol.php' ); 
    ?>
  </div>
  <div id="contenido">
  	<div id='divresultado' class='divresultado'>resultado</div>
  	<div id='form_captura' name='form_captura'>
  		form captura
  		<?php

        // include('form_captura.php'); 
      ?>
  	</div>
  </div>
</form>
</div>
</body>
</html>






  

