<?php
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
//// SISFO-TOKO v2.1                                 ////
/////////////////////////////////////////////////////////
//// Dibuat Oleh :                                   ////
////    Agus Muhajir, S.Kom                          ////
/////////////////////////////////////////////////////////
//// URL    : http://hajirodeon.wordpress.com/       ////
//// E-Mail : hajirodeon@yahoo.com                   ////
//// HP/SMS : 081-829-88-54                          ////
/////////////////////////////////////////////////////////
//// Milist :                                        ////
////    http://yahoogroup.com/groups/linuxbiasawae/  ////
////    http://yahoogroup.com/groups/sisfokol/       ////
/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////


////cek session
$kd2_session = nosql($_SESSION['kd2_session']);
$username2_session = nosql($_SESSION['username2_session']);
$kasir_session = nosql($_SESSION['kasir_session']);
$pass2_session = nosql($_SESSION['pass2_session']);
$time2_session = $_SESSION['time2_session'];
$hajirobe2_session = nosql($_SESSION['hajirobe2_session']);

$qbw = mysqli_query($koneksi, "SELECT * FROM admks ".
						"WHERE kd = '$kd2_session' ".
						"AND username = '$username2_session' ".
						"AND time_login = '$time2_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0) OR (empty($kd2_session))
	OR (empty($username2_session))
	OR (empty($pass2_session))
	OR (empty($time2_session))
	OR (empty($kasir_session))
	OR (empty($hajirobe2_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
?>