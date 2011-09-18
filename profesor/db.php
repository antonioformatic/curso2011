<?php
require_once ('connect.php');
require_once ('funciones.php');

$colname_conexion = "-1";
if (isset($_GET['id'])) {
	$colname_conexion = $_GET['id'];
}
mysql_select_db($database_hhh, $hhh);
$query_conexion = sprintf("SELECT * FROM cds WHERE id = %s", GetSQLValueString($colname_conexion, "int"));
$conexion = mysql_query($query_conexion, $hhh) or die(mysql_error());
$row_conexion = mysql_fetch_assoc($conexion);
$totalRows_conexion = mysql_num_rows($conexion);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Untitled Document</title>
	</head>
	<body>
		<table border="1">
			<tr>
				<td>titel</td>
				<td>interpret</td>
				<td>jahr</td>
				<td>id</td>
			</tr>
			<?php do {
			?>
			<tr>
				<td><?php echo $row_conexion['titel'];?></td>
				<td><?php echo $row_conexion['interpret'];?></td>
				<td><?php echo $row_conexion['jahr'];?></td>
				<td><?php echo $row_conexion['id'];?></td>
			</tr>
			<?php } while ($row_conexion = mysql_fetch_assoc($conexion));?>
		</table>
	</body>
</html>
<?php
mysql_free_result($conexion);
?>