<?php require_once('../../Connections/conexionEmpresa.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE criticasproductos SET usuario_id=%s, producto_id=%s, comentario=%s WHERE id=%s",
                       GetSQLValueString($_POST['usuario_id'], "int"),
                       GetSQLValueString($_POST['producto_id'], "int"),
                       GetSQLValueString($_POST['comentario'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conexionEmpresa, $conexionEmpresa);
  $Result1 = mysql_query($updateSQL, $conexionEmpresa) or die(mysql_error());

  $updateGoTo = "listarCriticasProductos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_criticas = "-1";
if (isset($_GET['id'])) {
  $colname_criticas = $_GET['id'];
}
mysql_select_db($database_conexionEmpresa, $conexionEmpresa);
$query_criticas = sprintf("SELECT * FROM criticasproductos WHERE id = %s", GetSQLValueString($colname_criticas, "int"));
$criticas = mysql_query($query_criticas, $conexionEmpresa) or die(mysql_error());
$row_criticas = mysql_fetch_assoc($criticas);
$totalRows_criticas = mysql_num_rows($criticas);

mysql_select_db($database_conexionEmpresa, $conexionEmpresa);
$query_usuarios = "SELECT * FROM usuario";
$usuarios = mysql_query($query_usuarios, $conexionEmpresa) or die(mysql_error());
$row_usuarios = mysql_fetch_assoc($usuarios);
$totalRows_usuarios = mysql_num_rows($usuarios);

mysql_select_db($database_conexionEmpresa, $conexionEmpresa);
$query_productos = "SELECT * FROM producto";
$productos = mysql_query($query_productos, $conexionEmpresa) or die(mysql_error());
$row_productos = mysql_fetch_assoc($productos);
$totalRows_productos = mysql_num_rows($productos);
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
        src="../empresa/camello.jpg" 
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table align="center">
        <tr valign="baseline">
            <td nowrap="nowrap" align="right">Usuario_id:</td>
            <td><select name="usuario_id">
                <?php 
do {  
?>
                <option value="<?php echo $row_usuarios['id']?>" <?php if (!(strcmp($row_usuarios['id'], htmlentities($row_criticas['usuario_id'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_usuarios['nombre']?></option>
                <?php
} while ($row_usuarios = mysql_fetch_assoc($usuarios));
?>
            </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
            <td nowrap="nowrap" align="right">Producto_id:</td>
            <td><select name="producto_id">
                <?php 
do {  
?>
                <option value="<?php echo $row_productos['id']?>" <?php if (!(strcmp($row_productos['id'], htmlentities($row_criticas['producto_id'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_productos['descripcion']?></option>
                <?php
} while ($row_productos = mysql_fetch_assoc($productos));
?>
            </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
            <td nowrap="nowrap" align="right" valign="top">Comentario:</td>
            <td><textarea name="comentario" cols="50" rows="5"><?php echo htmlentities($row_criticas['comentario'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
        </tr>
        <tr valign="baseline">
            <td nowrap="nowrap" align="right">&nbsp;</td>
            <td><input type="submit" value="Actualizar registro" /></td>
        </tr>
    </table>
    <input type="hidden" name="MM_update" value="form1" />
    <input type="hidden" name="id" value="<?php echo $row_criticas['id']; ?>" />
</form>
<p>&nbsp;</p>
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
mysql_free_result($criticas);

mysql_free_result($usuarios);

mysql_free_result($productos);
?>
