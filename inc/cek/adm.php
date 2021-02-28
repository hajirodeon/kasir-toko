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


///nilai session
$kd1_session = nosql($_SESSION['kd1_session']);
$username1_session = nosql($_SESSION['username1_session']);
$admin_session = nosql($_SESSION['admin_session']);
$pass1_session = nosql($_SESSION['pass1_session']);
$time1_session = $_SESSION['time1_session'];
$hajirobe1_session = nosql($_SESSION['hajirobe1_session']);


//jika belum login.
$qbw = mysqli_query($koneksi, "SELECT * FROM admin ".
						"WHERE kd = '$kd1_session' ".
						"AND username = '$username1_session' ".
						"AND time_login = '$time1_session'");
$rbw = mysqli_fetch_assoc($qbw);
$tbw = mysqli_num_rows($qbw);

if (($tbw == 0)
	OR (empty($kd1_session))
	OR (empty($username1_session))
	OR (empty($pass1_session))
	OR (empty($time1_session))
	OR (empty($admin_session))
	OR (empty($hajirobe1_session)))
	{
	//re-direct
	$pesan = "ANDA BELUM LOGIN. SILAHKAN LOGIN DAHULU...!!!";
	pekem($pesan, $sumber);
	exit();
	}
?>
