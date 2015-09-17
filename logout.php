<?php
	session_start();
	session_unset();
	session_destroy();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TABLERO</title>
<link rel="stylesheet" type="text/css" href="css/Estilos.css">
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
function volver(){
window.location.href="index.php"
}
</script>
<style type="text/css">
<!--
body {
	background-size: auto;
	background-position:right bottom;
}
#bg {
  position: fixed;
  z-index: -1;
  top: 0;
  left: 0;
  width: 100%;
  height:100%;
}
	
#contenedor {
	width:720px;
	height:420px;
	margin:10px auto;
	position:relative;
}

#contenido {

	width: 760px;
	height: 320px;
	position: absolute;
	top: 10px;
	left: 10px;
	padding: 10px 20px 10px 20px;
	overflow: hidden;
}

/* invisible para IE 5 \*/
#contenedor {
	position:absolute;
	margin:-210px 0 0 -360px;
	left:50%;
	top:50%;
}
/* fin hack */
-->
</style></head>
<body>
<!--<img src="images/iieg-140.png" id="bg" />-->
	<div id="contenedor">
	    <br><br><br><br><br><br><br><br><br><br><br><br><br>
        <td height="72" align="center" ><input type="button"  value="Volver a Autentificarse"  onClick="volver();" class="btnenviar" /></td>	
	</div>
<table width="28%" height="411"  align="center" border="0" >
<tr>
  <td height="100" align="left" valign="bottom"><p>&nbsp;</p></td>
  </tr>
<tr>
  <td  align="center" valign="top" height="439px" width="510px"><div class="login" height="439px" widht="510px">
  	<table   border="0"  align="center">
    <tr>
      <td height="108" colspan="2" align="center" valign="top"></td>
    </tr>
    <tr>
      <td width="95" height="43" align="right" valign="center"  class="Estilo1"></td>
      <td width="253" align="left" valign="bottom"></td>
      </tr>
    <tr>
      <td height="38" align="right" class="Estilo1"></td>
      <td align="left" ></td>
    </tr>
    <tr>
      <td height="72" align="center"  class="Estilo2"><div id="msg" class="msg_error"></div></td>
      <td height="72" align="center" ></td>
    </tr>
  </table>
</div>
</td>
</tr>
</table>
</body>
</html>

