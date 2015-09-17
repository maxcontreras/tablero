<?php
session_start();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TABLERO DE INDICADORES</title>
<link rel="stylesheet" type="text/css" href="../css/Estilos.css">
<script type="text/javascript" src="../js/script_jq.js"></script>
<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../js/ajax_ord.js"></script>
<script type="text/javascript" src="../highcharts/js/jquery.min.js"></script>
<script src="../highcharts/js/highcharts.js"></script>
<script src="../highcharts/js/modules/exporting.js"></script>
</head>

<body>
<?php
@require ("main_valida.php");
if (empty($_SESSION['usr'])) {
header("Location: index.php");
exit();
}
$iduser = $_SESSION['usr'];


?>
VISTA DETALLADA

</body>
</html>