<?php
if (isset($_GET["confirm"]))
{
$confirm = addslashes(htmlspecialchars($_GET["confirm"]));

$query = "SELECT confirm FROM adm_usuario WHERE confirm='$confirm'";
$result = $connection -> query($query);
$row = $result -> fetch_array();
if (!empty($row))
{
$query_active = "UPDATE users SET active='true' WHERE confirm='$confirm'";
$result_active = $connection -> query($query_active);
$msg_login = "<span style='color: blue;'>".$lang_Confirm["confirm"]."</span>";
}
else
{
header("location: login.php");
}
}
?>