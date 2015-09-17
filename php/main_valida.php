<?php 
session_start();

@require('./lib/conexion.php');


    $sql = "SELECT username, id_usr,  passwd FROM adm_usuario WHERE  (username = :usr)  AND (passwd = :psw) AND (status = 1)";
    $stmt = $con->prepare($sql);
    $stmt->execute(array(':usr' => $_SESSION['usr'], ':psw' => $_SESSION['passwd']));
    $row = $stmt->fetch();

	if (!$stmt)
	{
		include ("error.php");
		exit();
	}



/*
$qry = "SELECT id_usr
		FROM  adm_usuario
		WHERE (id_usr = $_SESSION[usr]) AND (passwd = N'$_SESSION[passwd]')";
	$query = $con->prepare($qry);
	$query->execute(array($_SESSION['usr'],$_SESSION['passwd']));
	if (!$query)
	{
		include ("error.php");
		exit();
	}*/

?>