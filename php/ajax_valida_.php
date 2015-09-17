<?php
	require ("../lib/conexion.php");
	session_start();

			/*$qry = "SELECT id_usr
			FROM adm_usuario
			WHERE id_usr = ? AND passwd = ? AND status = '1'";*/

			$sql = "SELECT username, id_usr,  passwd FROM adm_usuario WHERE  (username = :usr)  AND (passwd = :psw) AND (status = 1)";
			
			    $stmt = $con->prepare($sql);
    			$stmt->execute(array(':usr' => $_SESSION['usr'], ':psw' => $_SESSION['passwd']));
				$row = $stmt->fetch();


	//$result = $con->prepare($qry);
	//$result->execute(array($_SESSION['usr']),$_SESSION['passwd']);

	if (!$stmt)
	{
		header ("Location: error.php");
		exit();
	}
?>