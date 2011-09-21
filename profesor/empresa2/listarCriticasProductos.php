<?php require_once('../../Connections/conexionEmpresa.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "usuario,administrador";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_criticasDeUsuarios = 10;
$pageNum_criticasDeUsuarios = 0;
if (isset($_GET['pageNum_criticasDeUsuarios'])) {
  $pageNum_criticasDeUsuarios = $_GET['pageNum_criticasDeUsuarios'];
}
$startRow_criticasDeUsuarios = $pageNum_criticasDeUsuarios * $maxRows_criticasDeUsuarios;

mysql_select_db($database_conexionEmpresa, $conexionEmpresa);
$query_criticasDeUsuarios = "SELECT criticasproductos.id, criticasproductos.comentario, usuario.nombre, producto.descripcion FROM criticasproductos        JOIN usuario           ON usuario.id = criticasproductos.usuario_id  JOIN producto ON producto.id = criticasproductos.producto_id";
$query_limit_criticasDeUsuarios = sprintf("%s LIMIT %d, %d", $query_criticasDeUsuarios, $startRow_criticasDeUsuarios, $maxRows_criticasDeUsuarios);
$criticasDeUsuarios = mysql_query($query_limit_criticasDeUsuarios, $conexionEmpresa) or die(mysql_error());
$row_criticasDeUsuarios = mysql_fetch_assoc($criticasDeUsuarios);

if (isset($_GET['totalRows_criticasDeUsuarios'])) {
  $totalRows_criticasDeUsuarios = $_GET['totalRows_criticasDeUsuarios'];
} else {
  $all_criticasDeUsuarios = mysql_query($query_criticasDeUsuarios);
  $totalRows_criticasDeUsuarios = mysql_num_rows($all_criticasDeUsuarios);
}
$totalPages_criticasDeUsuarios = ceil($totalRows_criticasDeUsuarios/$maxRows_criticasDeUsuarios)-1;

$queryString_criticasDeUsuarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_criticasDeUsuarios") == false && 
        stristr($param, "totalRows_criticasDeUsuarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_criticasDeUsuarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_criticasDeUsuarios = sprintf("&totalRows_criticasDeUsuarios=%d%s", $totalRows_criticasDeUsuarios, $queryString_criticasDeUsuarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/profesorEmpresa2.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="css/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
</head>
 
<body>

<div class="container">
  <div class="header">
  <h1>
  <a href="#">
    <img 
        src="camello.jpg" 
        alt="Insertar logotipo aquí" 
        name="Insert_logo" 
        width="120" 
        height="100" 
        id="Insert_logo" 
        style="background: #C6D580; " 
      />
    </a>Web básica 2</h1>
    <!-- end .header --></div>
  <div class="sidebar1">

<ul id="MenuBar1" class="MenuBarVertical">
    <li><a href="listarUsuarios.php">Usuarios</a></li>
    <li><a href="listarCriticasProductos.php">Cr&iacute;ticas de productos</a></li>
    <li><a href="listarFirmas.php">Libro de firmas</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
<!-- end .sidebar1 --></div>
  <div class="content">
    <!-- InstanceBeginEditable name="contenido" -->
<table border="0">
    <tr>
        <td>comentario</td>
        <td>nombre</td>
        <td>descripcion</td>
        <?php if ($_SESSION['MM_UserGroup'] == "administrador"){ ?>
	        <td><img src="b_edit.png" width="16" height="16" /></td>
    	    <td><img src="b_drop.png" width="16" height="16" /></td>
        <?php } ?>

    </tr>
    <?php do { ?>
        <tr>
            <td><textarea name="comentario" cols="" rows="" ><?php echo $row_criticasDeUsuarios['comentario']; ?></textarea></td>
            <td><?php echo $row_criticasDeUsuarios['nombre']; ?></td>
            <td><?php echo $row_criticasDeUsuarios['descripcion']; ?></td>
            <?php if ($_SESSION['MM_UserGroup'] == "administrador"){ ?>
	            <td><a href="editarCriticaProducto.php?id=<?php echo $row_criticasDeUsuarios['id']; ?>"><img src="b_edit.png" width="16" height="16" /></a></td>
	            <td><a href="borrarCriticaProducto.php?id=<?php echo $row_criticasDeUsuarios['id']; ?>"><img src="b_drop.png" width="16" height="16" /></a></td>
            <?php } ?>
        </tr>
        <?php } while ($row_criticasDeUsuarios = mysql_fetch_assoc($criticasDeUsuarios)); ?>
<table border="0">
        <tr>
            <td><?php if ($pageNum_criticasDeUsuarios > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_criticasDeUsuarios=%d%s", $currentPage, 0, $queryString_criticasDeUsuarios); ?>"><img src="First.gif" /></a>
                    <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_criticasDeUsuarios > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_criticasDeUsuarios=%d%s", $currentPage, max(0, $pageNum_criticasDeUsuarios - 1), $queryString_criticasDeUsuarios); ?>"><img src="Previous.gif" /></a>
                    <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_criticasDeUsuarios < $totalPages_criticasDeUsuarios) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_criticasDeUsuarios=%d%s", $currentPage, min($totalPages_criticasDeUsuarios, $pageNum_criticasDeUsuarios + 1), $queryString_criticasDeUsuarios); ?>"><img src="Next.gif" /></a>
                    <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_criticasDeUsuarios < $totalPages_criticasDeUsuarios) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_criticasDeUsuarios=%d%s", $currentPage, $totalPages_criticasDeUsuarios, $queryString_criticasDeUsuarios); ?>"><img src="Last.gif" /></a>
                    <?php } // Show if not last page ?></td>
	            <td><a href="agregarCriticaProducto.php"><img src="agregar.png" width="16" height="16" /></a></td>        
        </tr>
    </table>
</table>
<!-- InstanceEndEditable -->
    <!-- end .content --></div>
  <div class="footer">
Muchas gracias por visitar la web
    <!-- end .footer --></div>
  <!-- end .container --></div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($criticasDeUsuarios);
?>
