<?php require_once('../Connections/con.php'); ?><?php
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

$maxRows_rsreservasi = 5;
$pageNum_rsreservasi = 0;
if (isset($_GET['pageNum_rsreservasi'])) {
  $pageNum_rsreservasi = $_GET['pageNum_rsreservasi'];
}
$startRow_rsreservasi = $pageNum_rsreservasi * $maxRows_rsreservasi;

mysql_select_db($database, $con);
$query_rsreservasi = "SELECT reservasi.reservasiID, reservasi.nama, reservasi.no_identitas, reservasi.identitasID, reservasi.no_telp, reservasi.email, reservasi.jadwalID, reservasi.KAID, reservasi.KAID, reservasi.stasiunID, reservasi.stasiunID1, reservasi.pembayaranID, reservasi.pemilik, reservasi.bankID, reservasi.rekening, reservasi.jumlahID, reservasi.tanggal_berangkat, jadwal.Harga, jadwal.Jam, ka.KANama, pembayaran.jenisPembayaran, stasiun.stasiunNama, stasiun1.stasiunNama1, identitas.jenisID, bank.bankNama, jumlah.jumlahNama FROM reservasi, jadwal, ka, pembayaran, stasiun, stasiun1, identitas, bank, jumlah WHERE (reservasi.identitasID=identitas.identitasID) AND (reservasi.jadwalID=jadwal.jadwalID) AND (reservasi.KAID=ka.KAID) AND (reservasi.stasiunID=stasiun.stasiunID) AND (reservasi.stasiunID1=stasiun1.stasiunID1) AND (reservasi.pembayaranID=pembayaran.pembayaranID) AND (reservasi.bankID=bank.bankID) AND (reservasi.jumlahID=jumlah.jumlahID) ORDER BY reservasi.reservasiID ASC";
$query_limit_rsreservasi = sprintf("%s LIMIT %d, %d", $query_rsreservasi, $startRow_rsreservasi, $maxRows_rsreservasi);
$rsreservasi = mysql_query($query_limit_rsreservasi, $con) or die(mysql_error());
$row_rsreservasi = mysql_fetch_assoc($rsreservasi);

if (isset($_GET['totalRows_rsreservasi'])) {
  $totalRows_rsreservasi = $_GET['totalRows_rsreservasi'];
} else {
  $all_rsreservasi = mysql_query($query_rsreservasi);
  $totalRows_rsreservasi = mysql_num_rows($all_rsreservasi);
}
$totalPages_rsreservasi = ceil($totalRows_rsreservasi/$maxRows_rsreservasi)-1;

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

$queryString_rsreservasi = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsreservasi") == false &&
        stristr($param, "totalRows_rsreservasi") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsreservasi = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsreservasi = sprintf("&totalRows_rsreservasi=%d%s", $totalRows_rsreservasi, $queryString_rsreservasi);

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
<script>function confirmDelete() {
        return confirm("Yakin Hapus?")
      }  </script>
      <!-- Bootstrap core CSS -->
      <link href="dist/css/bootstrap.min.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="dashboard.css" rel="stylesheet">

      <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
      <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
      <script src="assets/js/ie-emulation-modes-warning.js"></script>

      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
<link rel="Shortcut Icon" href="../images/train.ico">
<link rel="stylesheet" href="../styles.css" type="text/css" />
<style type="text/css">
</style>
</head>

<body>
  <div id="nav">
    	<?php include 'menu.php'; ?>
    </ul>
  </div>
    <div id="page-intro">

  </div>
    <div id="body">
		<div id="content">
			      <?php
$nextWeek = time() + (7*24*60*60);//7days;24 hours;60 mins;60 secs
echo 'SEKARANG: '.date('Y-m-d')."\n";
?>
  </h10></p>
          <p align="center" class="">LAPORAN SEMUA TRANSAKSI</p>
          <p align="left" class="">&nbsp;
Records <?php echo ($startRow_rsreservasi + 1) ?> to <?php echo min($startRow_rsreservasi + $maxRows_rsreservasi, $totalRows_rsreservasi) ?> of <?php echo $totalRows_rsreservasi ?> </p>
          <?php do { ?>
            <div class="table-responsive">
              <table class="table table-striped" legth="100%">
                <thead>
            <tr>
              <td width="20%" ><div align="center" class="">
                <div align="center"><strong>RESERVASI ID</strong></div>
              </div></td>
              <td width="10%"><div align="center" class="">
                <div align="center"><strong>NAMA</strong></div>
              </div></td>
              <td width="12%"><div align="center" class="">
                <div align="center"><strong>NO.TELP</strong></div>
              </div></td>
              <td width="11%"><div align="center" class="">
                <div align="center"><strong>E-MAIL</strong></div>
              </div></td>
              <td width="16%"><div align="center" class="">
                <div align="center"><strong>JADWAL ID</strong></div>
              </div></td>
              <td width="20%"><div align="center" class="">
                <div align="center"><strong>TANGGAL KEBERANGKATAN</strong></div>
              </div></td>
              <td width="11%"><div align="center" class="">
                <div align="center"><strong>DELETE</strong></div>
              </div></td>
            </tr>
          </thead>
          <div class="table-responsive">
            <table class="table table-striped">
            <tr>
              <td><div align="center" class=""><?php echo $row_rsreservasi['reservasiID']; ?></div></td>
              <td><div align="center" class=""><?php echo $row_rsreservasi['nama']; ?></div></td>
              <td><div align="center"><?php echo $row_rsreservasi['no_telp']; ?></div></td>
              <td><div align="center"><?php echo $row_rsreservasi['email']; ?></div></td>
              <td><div align="center"><?php echo $row_rsreservasi['jadwalID']; ?></div></td>
              <td><div align="center"><?php echo $row_rsreservasi['tanggal_berangkat']; ?></div></td>
              <td><div align="center"><a href="delete_reservasi.php?reservasiID=<?php echo $row_rsreservasi['reservasiID']; ?>"onclick="return confirmDelete()">DELETE</a></div></td>
            </tr>
                          </table>
            <?php } while ($row_rsreservasi = mysql_fetch_assoc($rsreservasi)); ?>
            <div class="table-responsive">
              <table class="table table-striped">
            <tr>
              <td><div align="center" class="">
                <?php if ($pageNum_rsreservasi > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, 0, $queryString_rsreservasi); ?>">First</a>
                <?php } // Show if not first page ?>
              </div></td>
              <td><div align="center" class="">
                <?php if ($pageNum_rsreservasi > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, max(0, $pageNum_rsreservasi - 1), $queryString_rsreservasi); ?>">Previous</a>
                <?php } // Show if not first page ?>
              </div></td>
              <td><div align="center" class="">
                <?php if ($pageNum_rsreservasi < $totalPages_rsreservasi) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, min($totalPages_rsreservasi, $pageNum_rsreservasi + 1), $queryString_rsreservasi); ?>">Next</a>
                <?php } // Show if not last page ?>
              </div></td>
              <td><div align="center" class="">
                <?php if ($pageNum_rsreservasi < $totalPages_rsreservasi) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_rsreservasi=%d%s", $currentPage, $totalPages_rsreservasi, $queryString_rsreservasi); ?>">Last</a>
                <?php } // Show if not last page ?>
              </div></td>
            </tr><?php
            include '../Connections/con.php';
             include '../print.php'; ?>
            </body>
            </html>
          </table>
          </p>

</body>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="dist/js/bootstrap.min.js"></script>
<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
<script src="assets/js/vendor/holder.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="assets/js/ie10-viewport-bug-workaround.js"></script>
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
?>
