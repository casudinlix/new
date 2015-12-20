
<?php require_once('../Connections/con.php');
require_once('../Connections/session.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);

  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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



mysql_select_db($database, $con);
$query_member = "SELECT * FROM users";
$member = mysql_query($query_member, $con) or die(mysql_error());
$row_member = mysql_fetch_assoc($member);
$totalRows_member = mysql_num_rows($member);


mysql_select_db($database, $con);
$query_rsadmin = "SELECT * FROM `admin`";
$rsadmin = mysql_query($query_rsadmin, $con) or die(mysql_error());
$row_rsadmin = mysql_fetch_assoc($rsadmin);
$totalRows_rsadmin = mysql_num_rows($rsadmin);

$queryString_member = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_member") == false &&
        stristr($param, "totalRows_member") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_member = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_member = sprintf("&totalRows_member=%d%s", $totalRows_member, $queryString_member);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daftar ALL Member</title>
<script>function confirmLogout() {
        return confirm("Yakin Logout?")
      } <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>LAPORAN TRANSAKSI</title>
      <script>function confirmLogout() {
              return confirm("Yakin Logout?")
            }  </script>
      <link rel="Shortcut Icon" href="../images/train.ico">
      <link rel="stylesheet" href="../styles.css" type="text/css" />
      <style type="text/css">
      <!--
      .style1 {color: #FF0000}
      .style2 {
      	color: #FF0000;
      	font-size: 16px;
      	font-weight: bold;
      }
      .style6 {color: #FF0000; font-weight: bold; }
      .style7 {
      	color: #FF00FF;
      	font-weight: bold;
      }
      -->
      </style>

</head>

<body>
<?php include 'menu.php'; ?>
	<h2><strong>List Member</strong></h2>
            <p><img src="../images/footer-l2.png" alt="" width="265" height="55" longdesc="images/footer-l2.png" /></p>
            <p><?php
$nextWeek = time() + (7*24*60*60);//7days;24 hours;60 mins;60 secs
echo 'SEKARANG: '.date('Y-m-d')."\n";

?>

<p align="center" class="fa-users"></p>
<p align="left" class="style1">Records <?php echo ($startRow_member + 1) ?> to <?php echo min($startRow_member + $maxRows_member, $totalRows_member) ?> of <?php echo $totalRows_member ?> </p>
<form id="form1" method="post" action="">
  <?php do { ?>
    <div class="row">
      <div class="col-md-6">
  <table class="table table-bordered"   width="100%" border="0" cellspacing="0" cellpadding="3">
      <thead>
    <tr >
      <th><div align="center"><strong>Nomor</strong></div></th>
      <th><div align="center"><strong>User Name</strong></div></th>
      <th><div align="center"><strong>Email</strong></div></th>
      <th><div align="center"><strong>Nomor Telpone</strong></div></th>
      <th><div align="center"><strong>Level</strong></div></th>

    </tr>
  </thead>
</div>
  </div>
<tbody>
    <tr>
      <td><div align="center" class="style7"><a href="laporan_member.php?userID=<?php echo $row_member['userID']; ?>"><?php echo $row_member['userID']; ?></a></div></td>

      <td><div align="center"><?php echo $row_member['username']; ?></div></td>

      <td><div align="center"><?php echo $row_member['email']; ?></div></td>
      <td><div align="center"><?php echo $row_member['nomor']; ?></div></td>
      <td><div align="center"><?php echo $row_member['accessLevel']; ?></div></td>

    </tr>
  </tbody>
  </table>
</div>
</div>
  <?php } while ($row_member = mysql_fetch_assoc($member)); ?>
</form>
<p align="left" class="style1">&nbsp;</p>
<div align="center"></div>
<table border="0">
  <tr>
    <td class="style1"><div align="center">
      <?php if ($pageNum_rsjadwal > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_member=%d%s", $currentPage, 0, $queryString_member); ?>">First</a>
      <?php } // Show if not first page ?>
    </div></td>
    <td class="style1"><div align="center">
      <?php if ($pageNum_member > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_member=%d%s", $currentPage, max(0, $pageNum_member - 1), $queryString_member); ?>">Previous</a>
      <?php } // Show if not first page ?>
    </div></td>
    <td class="style1"><div align="center">
      <?php if ($pageNum_member < $totalPages_member) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_member=%d%s", $currentPage, min($totalPages_member, $pageNum_member + 1), $queryString_member); ?>">Next</a>
      <?php } // Show if not last page ?>
    </div></td>
    <td class="style1"><div align="center">
      <?php if ($pageNum_member < $totalPages_member) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_rsjadwal=%d%s", $currentPage, $totalPages_member, $queryString_member); ?>">Last</a>
      <?php } // Show if not last page ?>
    </div></td>
  </tr>
</table>
<?php include '../footer.php'; ?>
</body>

</html>
<?php mysql_free_result($member);  ?>
