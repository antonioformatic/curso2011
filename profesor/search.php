<?php
/*
Busca en una tabla un valor dado y devuelve un array 
en formato json con los registros en los que el campo
a buscar contiene el valor dado. Para cada registro 
encontrado, devuelve el campo a buscar como "label" y
el campo a devolver como "ret".
*/
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once ('funciones.php');
require_once ('connect.php');

$database = $_GET['database'];
$table = $_GET['table'];
$fieldSearch = $_GET['fieldSearch'];
$valueSearch = '%';
$valueSearch.= $_GET['term'];
$valueSearch.='%';
$fieldRet = $_GET['fieldRet'];

mysql_select_db($database, $connection);

$query_conexion = sprintf("SELECT * FROM %s WHERE %s LIKE '%s'", $table, $fieldSearch, $valueSearch);
$conexion = mysql_query($query_conexion, $connection) or die(mysql_error());
$row = mysql_fetch_assoc($conexion);

$result = array();

do {
	array_push(
		$result, 
		array(
			"ret"    => $row[$fieldRet], 
			"label" => $row[$fieldSearch]
		)
	);
} while ($row= mysql_fetch_assoc($conexion));
echo array_to_json($result);
mysql_free_result($conexion);
?>