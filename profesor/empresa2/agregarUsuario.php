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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuario (nombre, password, nivel) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['nivel'], "text"));

  mysql_select_db($database_conexionEmpresa, $conexionEmpresa);
  $Result1 = mysql_query($insertSQL, $conexionEmpresa) or die(mysql_error());

  $insertGoTo = "listarUsuarios.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
    <!-- InstanceBeginEditable name="contenido" -->contenido
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Nombre:</td>
                <td><input type="text" name="nombre" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Password:</td>
                <td><input type="password" name="password" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">Nivel:</td>
                <td><select name="nivel">
                    <option value="usuario" <?php if (!(strcmp("usuario", ""))) {echo "SELECTED";} ?>>Usuario</option>
                    <option value="administrador" <?php if (!(strcmp("administrador", ""))) {echo "SELECTED";} ?>>Administrador</option>
                </select></td>
            </tr>
            <tr valign="baseline">
                <td nowrap="nowrap" align="right">&nbsp;</td>
                <td><input type="submit" value="Insertar registro" /></td>
            </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
    </form>
    <p>&nbsp;</p>
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
