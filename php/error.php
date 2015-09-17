<?php
	session_start();
	session_unset();
	session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Error</title>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body {
	background-color: #a82b2b;
	background-image: url(../images/fondo.png);
}
</style>
</head>
<script language="JavaScript" type="text/JavaScript">
function volver(){
window.location.href="../index.php"
}
</script>
<body>
<div class="Estilo10" id="content">
  <div style="margin-top:5px; width:20%; ">
    <?php
echo"<script language=\"javascript\">
alert('Su sesion a caducado');
window.parent.location.href='index.php'; 

</script>"; 
     ?>   </div>
</div>
<table width="352" height="331"  border="0" align="center"  background="../images/error.png" >
  <tr>
    <td width="352"><p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
