<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname = "localhost";
$database = "tiket";
$username = "cas";
$password = "bintang";
$con = mysql_connect($hostname,$username,$password) or trigger_error(mysql_error(),E_USER_ERROR);
?>
