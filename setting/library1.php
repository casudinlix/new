  <?php
  require_once 'server.php';
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
      ///Untuk Testimoni
      mysql_select_db($database, $con);
      $query_rsusers = "SELECT * FROM users";
      $rsusers = mysql_query($query_rsusers, $con) or die(mysql_error());
      $row_rsusers = mysql_fetch_assoc($rsusers);
      $totalRows_rsusers = mysql_num_rows($rsusers);
      
      $maxRows_rstesti = 3;
      $pageNum_rstesti = 0;
      if (isset($_GET['pageNum_rstesti'])) {
      $pageNum_rstesti = $_GET['pageNum_rstesti'];
      }
      $startRow_rstesti = $pageNum_rstesti * $maxRows_rstesti;
      
      mysql_select_db($database, $con);
      $query_rstesti = "SELECT * FROM testi ORDER BY testiID DESC";
      $query_limit_rstesti = sprintf("%s LIMIT %d, %d", $query_rstesti, $startRow_rstesti, $maxRows_rstesti);
      $rstesti = mysql_query($query_limit_rstesti, $con) or die(mysql_error());
      $row_rstesti = mysql_fetch_assoc($rstesti);
      
      if (isset($_GET['totalRows_rstesti'])) {
      $totalRows_rstesti = $_GET['totalRows_rstesti'];
      } else {
      $all_rstesti = mysql_query($query_rstesti);
      $totalRows_rstesti = mysql_num_rows($all_rstesti);
      }
      $totalPages_rstesti = ceil($totalRows_rstesti/$maxRows_rstesti)-1;
      #Akhir Testimoni
      ?>
      
      
      
      <?php
      // *** Validate request untuk login ke dalam situs.
      
      if (!isset($_SESSION)) {
      session_start();
      }
      //fungsi untuk Form
      $loginFormAction = $_SERVER['PHP_SELF'];
      //akhir fungsi
      
      if (isset($_GET['accesscheck'])) {
      $_SESSION['PrevUrl'] = $_GET['accesscheck'];
      }
      
      if (isset($_POST['text1'])) {
      $loginUsername=$_POST['text1'];
      $password=$_POST['text2'];
      $MM_fldUserAuthorization = "accessLevel";
      $MM_redirectLoginSuccess = "user.php";
      $MM_redirectLoginFailed = "fail.php";
      $MM_redirecttoReferrer = false;
      mysql_select_db($database, $con);
      
      $LoginRS__query=sprintf("SELECT username, password, accessLevel FROM users WHERE username=%s AND password=%s",
      GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
      
      $LoginRS = mysql_query($LoginRS__query, $con) or die(mysql_error());
      $loginFoundUser = mysql_num_rows($LoginRS);
      if ($loginFoundUser) {
      
      $loginStrGroup  = mysql_result($LoginRS,0,'accessLevel');
      
      //declare two session variables and assign them
      $_SESSION['MM_Username'] = $loginUsername;
      $_SESSION['MM_UserGroup'] = $loginStrGroup;
      
      if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
      }
      header("Location: " . $MM_redirectLoginSuccess );
      }
      else {
      header("Location: ". $MM_redirectLoginFailed );
      }
      }

//melihat jadwal Guest
//
//

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
$query_rsjadwal = "SELECT  jadwal.jadwalID,
 jadwal.KAID,
  jadwal.stasiunID,
   jadwal.StasiunID1,
    jadwal.kelasID,
     jadwal.Harga,
      jadwal.Jam,
       ka.KANama,
       kelas.kelasNama,
        stasiun.stasiunNama,
         stasiun1.stasiunNama1
          FROM jadwal, ka, kelas, stasiun, stasiun1
           WHERE (jadwal.KAID=ka.KAID)
            AND (jadwal.stasiunID=stasiun.stasiunID)
             AND (jadwal.stasiunID1=stasiun1.stasiunID1)
              AND (jadwal.kelasID=kelas.kelasID)
               ORDER BY jadwal.jadwalID ASC";
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

// Pesan Tiket USER
// 
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO reservasi (nama, no_identitas, identitasID, no_telp, email, jadwalID, KAID, stasiunID, stasiunID1, pembayaranID, pemilik, bankID, rekening, jumlahID, tanggal_berangkat) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['no_identitas'], "text"),
                       GetSQLValueString($_POST['identitasID'], "int"),
                       GetSQLValueString($_POST['no_telp'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['jadwalID'], "int"),
                       GetSQLValueString($_POST['KAID'], "int"),
                       GetSQLValueString($_POST['stasiunID'], "int"),
                       GetSQLValueString($_POST['stasiunID1'], "int"),
                       GetSQLValueString($_POST['pembayaranID'], "int"),
                       GetSQLValueString($_POST['pemilik'], "text"),
                       GetSQLValueString($_POST['bankID'], "int"),
                       GetSQLValueString($_POST['rekening'], "text"),
                       GetSQLValueString($_POST['jumlahID'], "int"),
                       GetSQLValueString($_POST['tanggal_berangkat'], "date"));

  mysql_select_db($database, $con);
  $Result1 = mysql_query($insertSQL, $con) or die(mysql_error());

  $insertGoTo = "tiket.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

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

$tiket_rsjadwal = "1";
if (isset($_GET["jadwalID"])) {
  $tiket_rsjadwal = $_GET["jadwalID"];
}
mysql_select_db($database, $con);
$query_rsjadwal = sprintf("SELECT jadwal.jadwalID,
   jadwal.KAID,
    jadwal.stasiunID,
     jadwal.StasiunID1,
      jadwal.kelasID, jadwal.Harga,
       jadwal.Jam,
        ka.KANama,
         kelas.kelasNama, stasiun.stasiunNama, stasiun1.stasiunNama1
          FROM jadwal, ka, kelas, stasiun, stasiun1
           WHERE (jadwal.KAID= ka.KAID)
            AND (jadwal.stasiunID=stasiun.stasiunID)
             AND (jadwal.stasiunID1=stasiun1.stasiunID1)
              AND (jadwal.kelasID=kelas.kelasID)
               AND (jadwal.jadwalID=%s)
                ORDER BY jadwal.jadwalID ASC", GetSQLValueString($tiket_rsjadwal, "int"));
$rsjadwal = mysql_query($query_rsjadwal, $con) or die(mysql_error());
$row_rsjadwal = mysql_fetch_assoc($rsjadwal);
$totalRows_rsjadwal = mysql_num_rows($rsjadwal);

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

//pencarian tiket USER
//
$tampil_rsreservasi = "thunder_cas@yahoo.com";
if (isset($_GET["email"])) {
  $tampil_rsreservasi = $_GET["email"];
}
mysql_select_db($database, $con);
$query_rsreservasi = sprintf("SELECT reservasi.reservasiID,
   reservasi.nama,
   reservasi.no_identitas,
   reservasi.identitasID,
   reservasi.no_telp,
   reservasi.email,
   reservasi.jadwalID,
    reservasi.KAID,
    reservasi.stasiunID,
    reservasi.stasiunID1,
    reservasi.pembayaranID,
    reservasi.pemilik,
    reservasi.bankID,
     reservasi.rekening,
      reservasi.jumlahID,
       reservasi.tanggal_berangkat,
        jadwal.Harga,
         jadwal.Jam,
          ka.KANama,
           pembayaran.jenisPembayaran,
            stasiun.stasiunNama,
             stasiun1.stasiunNama1,
              identitas.jenisID,
               bank.bankNama,
                jumlah.jumlahNama,
                 reservasi.rekening,
                  reservasi.pemilik,
                   reservasi.tanggal_berangkat
                    FROM reservasi,
                     jadwal,
                      ka,
                       pembayaran,
                        stasiun,
                         stasiun1,
                          identitas,
                           bank,
                            jumlah WHERE (
                              reservasi.identitasID=identitas.identitasID)
                               AND (reservasi.jadwalID=jadwal.jadwalID) AND
                                (reservasi.KAID=ka.KAID) AND
                                 (reservasi.stasiunID=stasiun.stasiunID) AND
                                  (reservasi.stasiunID1=stasiun1.stasiunID1) AND
                                   (reservasi.pembayaranID=pembayaran.pembayaranID) AND
                                    (reservasi.bankID=bank.bankID) AND
                                     (reservasi.jumlahID=jumlah.jumlahID) AND
                                      (reservasi.email=%s)", GetSQLValueString($tampil_rsreservasi, "text"));
$rsreservasi = mysql_query($query_rsreservasi, $con) or die(mysql_error());
$row_rsreservasi = mysql_fetch_assoc($rsreservasi);
$totalRows_rsreservasi = mysql_num_rows($rsreservasi);

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

mysql_free_result($rskelas);

mysql_free_result($rska);

mysql_free_result($rspembayaran);

mysql_free_result($rsstasiun);

mysql_free_result($rstrayek);

mysql_free_result($rsjadwal);

mysql_free_result($rsreservasi);

?>
