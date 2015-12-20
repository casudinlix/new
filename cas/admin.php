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
