<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname = "localhost";
$database = "tiket";
$username = "cas";
$password = "bintang";
$connect = mysqli_connect($hostname,$username,$password,$database);
if (!$connect) {
	die("NO CONNECTION");
	}
?>
