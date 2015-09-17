<?php
session_start();
/*$_SESSION['id_emp'] = $_GET['id_emp'];*/
$_SESSION['idmod'] = $_GET['idmod'];
$url = "../".$_GET['mod'];
?>
<html>
	<head>	
	</head>
	<body>
    <script>
		window.location = "<?php echo $url; ?>";
	</script>
    </body>
</html>