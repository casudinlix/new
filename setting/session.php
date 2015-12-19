<?php
error_reporting(0);
session_start();
if ((!$_SESSION['MM_Username']) AND (!$_SESSION['MM_UserGroup']))
{
echo "<center><font color=white size=+3><b>
Anda Belum Login</b></font><br>";
echo "<br><b><a href=fail.php> Hayoo... ! Login Dulu Donk</center><br></a>";
exit;
}
?>
