<?php
 require ("../lib/conexion.php");

	$usr = $_POST['user'];
	$psw = $_POST['pass'];
	
	$usr = trim($usr);
	$psw = trim($psw);
	$passwd = sha1($psw);
	


    $sql = "SELECT username, id_usr,  passwd FROM adm_usuario WHERE  (username = :usr)  AND (passwd = :psw) AND (status = 1)";
    $stmt = $con->prepare($sql);
    $stmt->execute(array(':usr' => $usr, ':psw' => $psw));
    $row = $stmt->fetch();

    //echo $row['id_usr']." ".$row['username'];

	if ($row)
	{
		session_start();
		$_SESSION['usr'] = $row['id_usr'];
		$_SESSION['passwd'] = $psw;
		echo "modulos.php";
		//echo "login.php";
	}
	else
		echo md5("error");

?>