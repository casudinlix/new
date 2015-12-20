<?php include 'menu.php'; ?>
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


<div id="content">
  <h2><strong>Transaksi Penjualan Tiket</strong></h2>
        <p><img src="../images/footer-l2.png" alt="" width="265" height="55" longdesc="images/footer-l2.png" /></p>
        <p><?php
$nextWeek = time() + (7*24*60*60);//7days;24 hours;60 mins;60 secs
echo 'SEKARANG: '.date('Y-m-d')."\n";
?>
</h10></p>
      <p align="center" class="style2">Data Member</p>
      <p align="left" class="style1">&nbsp;
Records <?php echo ($startRow_member + 1) ?> to <?php echo min($startRow_member + $maxRows_member, $totalRows_member) ?> of <?php echo $totalRows_member ?> </p>
      <?php do { ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td width="20%"><div align="center" class="style1">
            <div align="center"><strong>USER ID</strong></div>
          </div></td>
          <td width="10%"><div align="center" class="style1">
            <div align="center"><strong>NAMA</strong></div>
          </div></td>
          <td width="12%"><div align="center" class="style1">
            <div align="center"><strong>NO.TELP</strong></div>
          </div></td>
          <td width="19%"><div align="center" class="style1">
            <div align="center"><strong>E-MAIL</strong></div>
          </div></td>
          <td width="16%"><div align="center" class="style1">

          </div></td>
          <td width="20%"><div align="center" class="style1">

          </div></td>
          <td width="11%"><div align="center" class="style1">
            <div align="center"><strong>DELETE</strong></div>
          </div></td>
        </tr>
        <tr>
          <td><div align="center" class="style6"><?php echo $row_member['userID']; ?></div></td>
          <td><div align="center" class="style6"><?php echo $row_member['username'];?></div></td>
          <td><div align="center" class="style7"><?php echo $row_member['nomor']; ?></div></td>
          <td><div align="center" class="style6"><?php echo $row_member['email']; ?></div></td>
          <td></div></td>
          <td><div></div></td>
          <td><div align="center"><a href="delete_user.php?useriID=<?php echo $row_member['userID']; ?>"onclick="return confirmDelete()">DELETE</a></div></td>
        </tr>
                      </table>
                      
        <?php } while ($row_me = mysql_fetch_assoc($rsreservasi)); ?>
        <table border="0">
        <tr>
          <td><div align="center" class="style1">
            <?php if ($pageNum_rsreservasi > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, 0, $queryString_rsreservasi); ?>">First</a>
            <?php } // Show if not first page ?>
          </div></td>
          <td><div align="center" class="style1">
            <?php if ($pageNum_rsreservasi > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, max(0, $pageNum_rsreservasi - 1), $queryString_rsreservasi); ?>">Previous</a>
            <?php } // Show if not first page ?>
          </div></td>
          <td><div align="center" class="style1">
            <?php if ($pageNum_rsreservasi < $totalPages_rsreservasi) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, min($totalPages_rsreservasi, $pageNum_rsreservasi + 1), $queryString_rsreservasi); ?>">Next</a>
            <?php } // Show if not last page ?>
          </div></td>
          <td><div align="center" class="style1">
            <?php if ($pageNum_rsreservasi < $totalPages_rsreservasi) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, $totalPages_rsreservasi, $queryString_rsreservasi); ?>">Last</a>
            <?php } // Show if not last page ?>
          </div></td>
        </tr>
      </table>
      </p>
<p align="left" class="style1">&nbsp;</p>
      <div align="center"></div>
      </p>
<p>&nbsp;</p>
      <p align="center" class="style1">&nbsp;</p>
</div>

    <div class="clear"></div>
</div>
</div>
<?php include '../footer.php'; ?>
</body>
</html>
