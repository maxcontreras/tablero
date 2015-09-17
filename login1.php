<?php
include "login/config.php";
include "login/login/Confirm.php";
?>
<!-- Estilos de divs principales -->
<link href="css/login.css" type="text/css" rel="STYLESHEET">
<script src="lib/jquery_.js" type="text/javascript"></script>

<div id="container">
  <div id="arriba"></div>
  <div id="medio">
			<center>
			<h3><?php echo $lang_login["login"]; ?>:</h3>
			<strong style="color: red;"><?php echo $msg_login; ?></strong>
			<form method="post">
			<table class="table table-striped" border = 0>
			<tr>
			<td style="text-align: right;"><?php echo $lang_login["user"]; ?>:</td><td><input type="text" placeholder="<?php echo $lang_login["user"]; ?>" name="user"></td>
			</tr>
			<tr>
			<td style="text-align: right;"><?php echo $lang_login["password"]; ?>:</td><td><input type="password" placeholder="<?php echo $lang_login["password"]; ?>" name="password"></td>
			</tr>
			<tr>
				<td colspan = 2>&nbsp;</td>
			</tr>
			<tr>
				<td colspan = 2 align = "center"><input type="hidden" name="login">
			<button type="submit" class="btn"><?php echo $lang_login["login"]; ?></button></td>
			</tr>
			</table>


			</form>
			</center>
  </div>
</div>
