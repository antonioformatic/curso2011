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

$maxRows_usuarios = 10;
$pageNum_usuarios = 0;
if (isset($_GET['pageNum_usuarios'])) {
  $pageNum_usuarios = $_GET['pageNum_usuarios'];
}
$startRow_usuarios = $pageNum_usuarios * $maxRows_usuarios;

mysql_select_db($database_conexionEmpresa, $conexionEmpresa);
$query_usuarios = "SELECT * FROM usuario";
$query_limit_usuarios = sprintf("%s LIMIT %d, %d", $query_usuarios, $startRow_usuarios, $maxRows_usuarios);
$usuarios = mysql_query($query_limit_usuarios, $conexionEmpresa) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);

if (isset($_GET['totalRows_usuarios'])) {
  $totalRows_usuarios = $_GET['totalRows_usuarios'];
} else {
  $all_usuarios = mysql_query($query_usuarios);
  $totalRows_usuarios = mysql_num_rows($all_usuarios);
}
$totalPages_usuarios = ceil($totalRows_usuarios/$maxRows_usuarios)-1;

$queryString_usuarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_usuarios") == false && 
        stristr($param, "totalRows_usuarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_usuarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_usuarios = sprintf("&totalRows_usuarios=%d%s", $totalRows_usuarios, $queryString_usuarios);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/profesorEmpresa.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin título</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../css/twoColFixLtHdr.css" rel="stylesheet" type="text/css" />
<script src="../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
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
    </a>Web básica 1
</h1>
    <!-- end .header --></div>
  <div class="sidebar1">
<ul id="MenuBar1" class="MenuBarVertical">
    <li><a href="listarUsuarios.php">Usuarios</a></li>
    <li><a href="listarFirmas.php">Libro de firmas</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>
<!-- end .sidebar1 --></div>
  <div class="content">
    <!-- InstanceBeginEditable name="contenido" -->
    <table border="0">
        <tr bgcolor="#CCCCCC">
            <td>id</td>
            <td>nombre</td>
            <td>password</td>
            <td>nivel</td>
            <td><img src="b_edit.png" width="16" height="16" /></td>
            <td><img src="b_drop.png" width="16" height="16" /></td>
        </tr>
        <?php do { ?>
            <tr>
                <td><?php echo $row_usuarios['id']; ?></td>
                <td><?php echo $row_usuarios['nombre']; ?></td>
                <td>
                	<input name="password" type="password" value ="<?php echo $row_usuarios['password']; ?>" readonly="readonly"/>
                </td>
                <td><?php echo $row_usuarios['nivel']; ?></td>
                <?php if($_SESSION['MM_UserGroup'] == "administrador"){ ?>
                <td><a href="editarUsuario.php?id=<?php echo $row_usuarios['id']; ?>"><img src="b_edit.png" width="16" height="16" /></a></td>
                <td><a href="borrarUsuario.php?id=<?php echo $row_usuarios['id']; ?>"><img src="b_drop.png" width="16" height="16" /></a></td>
                <?php } ?>
            </tr>
            <?php } while ($row_usuarios = mysql_fetch_assoc($usuarios)); ?>
        <table border="0">
            <tr>
                <td><?php if ($pageNum_usuarios > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, 0, $queryString_usuarios); ?>"><img src="First.gif" /></a>
                        <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_usuarios > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, max(0, $pageNum_usuarios - 1), $queryString_usuarios); ?>"><img src="Previous.gif" /></a>
                        <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_usuarios < $totalPages_usuarios) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, min($totalPages_usuarios, $pageNum_usuarios + 1), $queryString_usuarios); ?>"><img src="Next.gif" /></a>
                        <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_usuarios < $totalPages_usuarios) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_usuarios=%d%s", $currentPage, $totalPages_usuarios, $queryString_usuarios); ?>"><img src="Last.gif" /></a>
                        <?php } // Show if not last page ?></td>
                 <?php if($_SESSION['MM_UserGroup'] == "administrador"){ ?>
                 <td><a href="agregarUsuario.php"><img src="agregar.png" width="16" height="16" /></a></td>
                 <?php } ?>
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
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"../SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($usuarios);
?>
