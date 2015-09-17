<?php
require_once('./lib/class.database.php');	
require_once('./lib/config.php');

$BD = new database(_BD_SERVIDOR.':'._BD_PUERTO, _BD_USUARIO, _BD_PASSWORD );	

$msg_login = "";
if (isset($_POST["login"])){
	$user = addslashes(htmlspecialchars($_POST["user"]));
	$password = addslashes(htmlspecialchars($_POST["password"]));
	
	if (empty($user) || empty($password)){
		return;
	}

	if (!preg_match("/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_]+$/", $user) && !preg_match("/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/", $user)){
		$msg_login = $lang_Login["user_error"];
		return;
	}

	if (!preg_match("/^([a-zA-Z]+[0-9]+)|([0-9]+[a-zA-Z]+)/i", $password)){
		$msg_login = $lang_Login["password_error"];
		return;
	}else if(strlen($password) < 8 || strlen($password) > 16){
		$msg_login = $lang_Login["password_error_char"];
		return;
	}

		$query = '
					SELECT id, nick, email, password, avatar 
					FROM '._TBL_USER.' 
					WHERE nick="'.$user.'"  
					AND password=\''.md5($password).'\'
					AND active=\'true\'
				';
/*				
		$result = $connection -> query($query);
		$row = $result -> mysql_fetch_array();
*/

		$BD->setQuery($query);	
		$row = $BD->loadObject();

	//	echo $query;
	//	print_r($row);
		
/*
			if (headers_sent()) {
			    echo "las cabeceras ya se han enviado, no intentar añadir una nueva";

			}
			else {
				
			   
			}	

*/			

		
		if (empty($row)){
			$msg_login = $lang_Login["login_error"];
			return;
		}else{

			//echo "entraaaaaa";
			@session_start();
			$_SESSION["user"] = true;
			$_SESSION["nick"] = $row->nick;
			$_SESSION["email"] = $row->email;
			$_SESSION["avatar"] = $row->avatar;
			$_SESSION["id"]= $row->id;
			echo "<meta http-equiv=refresh content=0;URL=modulos.php />";

 			//header("location: pestanias2.php");


			
		}
		
}
?>