<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexionEmpresa = "localhost";
$database_conexionEmpresa = "empresa";
$username_conexionEmpresa = "root";
$password_conexionEmpresa = "secreto";
$conexionEmpresa = mysql_pconnect($hostname_conexionEmpresa, $username_conexionEmpresa, $password_conexionEmpresa) or trigger_error(mysql_error(),E_USER_ERROR); 
?>