<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TABLERO INDICADORES</title>
<link rel="stylesheet" type="text/css" href="css/Estilos.css">
<link rel="stylesheet" type="text/css" href="css/login.css">
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
<script language="javascript" type="text/javascript" src="js/enter.js" ></script>
<script language="javascript" type="text/javascript" src="js/ajax.js" ></script>
<script language="javascript">
function crece() {  
var the_height=
  document.getElementById('detalle').contentWindow.document.body.scrollHeight;

  document.getElementById('detalle').height= the_height;
}
function data_check(data)
{
	if (!data)
	{
		var usr = document.getElementById("usr");
		var psw = document.getElementById("psw");
		var img_error = "<img src=\"images/exclamation.png\" title=\"Error\" />";
		document.getElementById("eusr").innerHTML = "";
		document.getElementById("epsw").innerHTML = "";
		var band = false;
		if (usr.value == "")
		{
			document.getElementById("eusr").innerHTML = img_error;
			band = true;
		}
		if (psw.value == "")
		{
			document.getElementById("epsw").innerHTML = img_error;
			band = true;
		}
		if (!band)
		{
			var vars = null;
			vars = "user="+usr.value+"&pass="+psw.value;
			Ajax.receive("php/lgn_valida.php", vars, "data_check(Ajax.data)");
		}
	}
	else
	{
		if (data.indexOf("php") != -1)
			window.location = data;
			
		else
			document.getElementById("msg").innerHTML = "Usuario ó Contrase&ntilde;a Incorrecta";
	}
}
window.onload= function()
{
	var usr = document.getElementById('usr');
	usr.focus();
}
</script>
</head>
<body>
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
      <td width="95" height="43" align="right" valign="center"  class="Estilo1">Usuario&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td width="253" align="left" valign="bottom"><input type="text" id="usr" value="" onkeydown="intro(event, 'psw');" class="Estilo1" style="height:36px; border:1px solid #dcdcdc;" size="30"/>
        <span id="eusr">&nbsp;</span></td>
      </tr>
    <tr>
      <td height="38" align="right" class="Estilo1">Contraseña</td>
      <td align="left" ><input type="password" id="psw" value="" onkeydown="intro(event, 'btn_send');" class="Estilo1" style="height:36px; border:1px solid #dcdcdc;" size="30"/>
        <span id="epsw"></span></td>
    </tr>
    <tr>
      <td height="72" align="center"  class="Estilo2"><div id="msg" class="msg_error"></div></td>
      <td height="72" align="center" ><input type="button" id="btn_send" value="Entrar"  onclick="data_check(false)" class="btnenviar" /></td>
    </tr>
  </table>
</div>
</td>
</tr>
</table>

</body>
</html>

