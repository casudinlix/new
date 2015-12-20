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
$query_rskelas = "SELECT * FROM kelas";
$rskelas = mysql_query($query_rskelas, $con) or die(mysql_error());
$row_rskelas = mysql_fetch_assoc($rskelas);
$totalRows_rskelas = mysql_num_rows($rskelas);

mysql_select_db($database, $con);
$query_rska = "SELECT * FROM ka";
$rska = mysql_query($query_rska, $con) or die(mysql_error());
$row_rska = mysql_fetch_assoc($rska);
$totalRows_rska = mysql_num_rows($rska);

mysql_select_db($database, $con);
$query_rspembayaran = "SELECT * FROM pembayaran";
$rspembayaran = mysql_query($query_rspembayaran, $con) or die(mysql_error());
$row_rspembayaran = mysql_fetch_assoc($rspembayaran);
$totalRows_rspembayaran = mysql_num_rows($rspembayaran);

mysql_select_db($database, $con);
$query_rsstasiun = "SELECT * FROM stasiun";
$rsstasiun = mysql_query($query_rsstasiun, $con) or die(mysql_error());
$row_rsstasiun = mysql_fetch_assoc($rsstasiun);
$totalRows_rsstasiun = mysql_num_rows($rsstasiun);

mysql_select_db($database, $con);
$query_rstrayek = "SELECT * FROM trayek";
$rstrayek = mysql_query($query_rstrayek, $con) or die(mysql_error());
$row_rstrayek = mysql_fetch_assoc($rstrayek);
$totalRows_rstrayek = mysql_num_rows($rstrayek);

$maxRows_rsjadwal = 5;
$pageNum_rsjadwal = 0;
if (isset($_GET['pageNum_rsjadwal'])) {
  $pageNum_rsjadwal = $_GET['pageNum_rsjadwal'];
}
$startRow_rsjadwal = $pageNum_rsjadwal * $maxRows_rsjadwal;

mysql_select_db($database, $con);
$query_rsjadwal = "SELECT jadwal.jadwalID, jadwal.KAID, jadwal.stasiunID, jadwal.StasiunID1, jadwal.kelasID, jadwal.Harga, jadwal.Jam, ka.KANama, kelas.kelasNama, stasiun.stasiunNama, stasiun1.stasiunNama1 FROM jadwal, ka, kelas, stasiun, stasiun1 WHERE (jadwal.KAID=ka.KAID) AND (jadwal.stasiunID=stasiun.stasiunID) AND (jadwal.stasiunID1=stasiun1.stasiunID1) AND (jadwal.kelasID=kelas.kelasID) ORDER BY jadwal.jadwalID ASC";
$query_limit_rsjadwal = sprintf("%s LIMIT %d, %d", $query_rsjadwal, $startRow_rsjadwal, $maxRows_rsjadwal);
$rsjadwal = mysql_query($query_limit_rsjadwal, $con) or die(mysql_error());
$row_rsjadwal = mysql_fetch_assoc($rsjadwal);

if (isset($_GET['totalRows_rsjadwal'])) {
  $totalRows_rsjadwal = $_GET['totalRows_rsjadwal'];
} else {
  $all_rsjadwal = mysql_query($query_rsjadwal);
  $totalRows_rsjadwal = mysql_num_rows($all_rsjadwal);
}
$totalPages_rsjadwal = ceil($totalRows_rsjadwal/$maxRows_rsjadwal)-1;

mysql_select_db($database, $con);
$query_rsjumlah = "SELECT * FROM jumlah";
$rsjumlah = mysql_query($query_rsjumlah, $con) or die(mysql_error());
$row_rsjumlah = mysql_fetch_assoc($rsjumlah);
$totalRows_rsjumlah = mysql_num_rows($rsjumlah);

mysql_select_db($database, $con);
$query_rsreservasi = "SELECT reservasi.reservasiID, reservasi.nama, reservasi.no_identitas, reservasi.identitasID, reservasi.no_telp, reservasi.email, reservasi.jadwalID, reservasi.KAID, reservasi.KAID, reservasi.stasiunID, reservasi.stasiunID1, reservasi.pembayaranID, reservasi.pemilik, reservasi.bankID, reservasi.rekening, reservasi.jumlahID, reservasi.tanggal_berangkat, jadwal.Harga, jadwal.Jam, ka.KANama, pembayaran.jenisPembayaran, stasiun.stasiunNama, stasiun1.stasiunNama1, identitas.jenisID, bank.bankNama, jumlah.jumlahNama FROM reservasi, jadwal, ka, pembayaran, stasiun, stasiun1, identitas, bank, jumlah WHERE (reservasi.identitasID=identitas.identitasID) AND (reservasi.jadwalID=jadwal.jadwalID) AND (reservasi.KAID=ka.KAID) AND (reservasi.stasiunID=stasiun.stasiunID) AND (reservasi.stasiunID1=stasiun1.stasiunID1) AND (reservasi.pembayaranID=pembayaran.pembayaranID) AND (reservasi.bankID=bank.bankID) AND (reservasi.jumlahID=jumlah.jumlahID) ORDER BY reservasi.reservasiID ASC";
$rsreservasi = mysql_query($query_rsreservasi, $con) or die(mysql_error());
$row_rsreservasi = mysql_fetch_assoc($rsreservasi);
$totalRows_rsreservasi = mysql_num_rows($rsreservasi);

mysql_select_db($database, $con);
$query_rsstasuin1 = "SELECT * FROM stasiun1";
$rsstasuin1 = mysql_query($query_rsstasuin1, $con) or die(mysql_error());
$row_rsstasuin1 = mysql_fetch_assoc($rsstasuin1);
$totalRows_rsstasuin1 = mysql_num_rows($rsstasuin1);

mysql_select_db($database, $con);
$query_rsidentitas = "SELECT * FROM identitas";
$rsidentitas = mysql_query($query_rsidentitas, $con) or die(mysql_error());
$row_rsidentitas = mysql_fetch_assoc($rsidentitas);
$totalRows_rsidentitas = mysql_num_rows($rsidentitas);

mysql_select_db($database, $con);
$query_rsbank = "SELECT * FROM bank";
$rsbank = mysql_query($query_rsbank, $con) or die(mysql_error());
$row_rsbank = mysql_fetch_assoc($rsbank);
$totalRows_rsbank = mysql_num_rows($rsbank);

mysql_select_db($database, $con);
$query_rsadmin = "SELECT * FROM `admin`";
$rsadmin = mysql_query($query_rsadmin, $con) or die(mysql_error());
$row_rsadmin = mysql_fetch_assoc($rsadmin);
$totalRows_rsadmin = mysql_num_rows($rsadmin);

$queryString_rsjadwal = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsjadwal") == false &&
        stristr($param, "totalRows_rsjadwal") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsjadwal = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsjadwal = sprintf("&totalRows_rsjadwal=%d%s", $totalRows_rsjadwal, $queryString_rsjadwal);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
	<h2><strong>Transaksi Penjualan Tiket</strong></h2>
            <p><img src="../images/footer-l2.png" alt="" width="265" height="55" longdesc="images/footer-l2.png" /></p>
            <p><?php
$nextWeek = time() + (7*24*60*60);//7days;24 hours;60 mins;60 secs
echo 'SEKARANG: '.date('Y-m-d')."\n";
echo 'MINGGU DEPAN:'.date('Y-m-d',$nextWeek)."\n";
?>
  </h10></p>
          <p align="center" class="style2">PILIH KATEGORI BERDASARKAN JADWAL ID</p>
          <p align="left" class="style1">Records <?php echo ($startRow_rsjadwal + 1) ?> to <?php echo min($startRow_rsjadwal + $maxRows_rsjadwal, $totalRows_rsjadwal) ?> of <?php echo $totalRows_rsjadwal ?> </p>
          <form id="form1" method="post" action="">
            <?php do { ?>
              <div class="row">
                <div class="col-md-6">
            <table class="table table-bordered" width="100%" border="0" cellspacing="0" cellpadding="3">
                <thead>
              <tr>
                <th><div align="center"><strong>JADWAL ID</strong></div></th>
                <th><div align="center"><strong>KA</strong></div></th>
                <th><div align="center"><strong>DARI</strong></div></th>
                <th><div align="center"><strong>TUJUAN</strong></div></th>
                <th><div align="center"><strong>KELAS</strong></div></th>
                <th><div align="center"><strong>HARGA</strong></div></th>
                <th><div align="center"><strong>JAM</strong></div></th>
              </tr>
            </thead>
          </div>
            </div>
<tbody>
              <tr>
                <td><div align="center" class="style7"><a href="laporan.php?jadwalID=<?php echo $row_rsjadwal['jadwalID']; ?>"><?php echo $row_rsjadwal['jadwalID']; ?></a></div></td>
                <td><div align="center" class="style6"><?php echo $row_rsjadwal['KANama']; ?></div></td>
                <td><div align="center"><?php echo $row_rsjadwal['stasiunNama']; ?></div></td>
                <td><div align="center"><?php echo $row_rsjadwal['stasiunNama1']; ?></div></td>
                <td><div align="center"><?php echo $row_rsjadwal['kelasNama']; ?></div></td>
                <td><div align="center"><?php echo $row_rsjadwal['Harga']; ?></div></td>
                <td><div align="center"><?php echo $row_rsjadwal['Jam']; ?></div></td>
              </tr>
            </tbody>
            </table>
          </div>
        </div>
            <?php } while ($row_rsjadwal = mysql_fetch_assoc($rsjadwal)); ?>
          </form>
          <p align="left" class="style1">&nbsp;</p>
          <div align="center"></div>
          <table border="0">
            <tr>
              <td class="style1"><div align="center">
                <?php if ($pageNum_rsjadwal > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsjadwal=%d%s", $currentPage, 0, $queryString_rsjadwal); ?>">First</a>
                <?php } // Show if not first page ?>
              </div></td>
              <td class="style1"><div align="center">
                <?php if ($pageNum_rsjadwal > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsjadwal=%d%s", $currentPage, max(0, $pageNum_rsjadwal - 1), $queryString_rsjadwal); ?>">Previous</a>
                <?php } // Show if not first page ?>
              </div></td>
              <td class="style1"><div align="center">
                <?php if ($pageNum_rsjadwal < $totalPages_rsjadwal) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsjadwal=%d%s", $currentPage, min($totalPages_rsjadwal, $pageNum_rsjadwal + 1), $queryString_rsjadwal); ?>">Next</a>
                <?php } // Show if not last page ?>
              </div></td>
              <td class="style1"><div align="center">
                <?php if ($pageNum_rsjadwal < $totalPages_rsjadwal) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsjadwal=%d%s", $currentPage, $totalPages_rsjadwal, $queryString_rsjadwal); ?>">Last</a>
                <?php } // Show if not last page ?>
              </div></td>
            </tr>
          </table>
          </p>
          <p>&nbsp;</p>
          <p align="center" class="style1"><strong><a href="all_aporan.php">SEMUA TRANSAKSI</a></strong></p>
          <p align="center" class="style1">&nbsp;</p>
	  </div>

    	<div class="clear"></div>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
<?php
mysql_free_result($rskelas);

mysql_free_result($rska);

mysql_free_result($rspembayaran);

mysql_free_result($rsstasiun);

mysql_free_result($rstrayek);

mysql_free_result($rsjadwal);

mysql_free_result($rsjumlah);

mysql_free_result($rsreservasi);

mysql_free_result($rsstasuin1);

mysql_free_result($rsidentitas);

mysql_free_result($rsbank);

mysql_free_result($rsadmin);
?>
