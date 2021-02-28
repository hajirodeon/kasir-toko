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



//************************************************************************************************
//jika user : admin, semua menu bisa dijelajah.
//tapi jika user selain mereka, maka hanya menu tertentu saja yg diijinkan.
//sesuai dgn yg telah di-set.
if ($username1_session <> "admin")
	{
	//jika menu user, tidak sesuai akses
	$qcm = mysqli_query($koneksi, "SELECT akses_menu.*, akses_admin.* ".
				"FROM akses_menu, akses_admin ".
				"WHERE akses_admin.kd_menu = akses_menu.kd ".
				"AND akses_admin.status = 'true' ".
				"AND akses_admin.kd_admin = '$kd1_session' ".
				"AND akses_menu.filex = '$filenya'");
	$rcm = mysqli_fetch_assoc($qcm);
	$tcm = mysqli_num_rows($qcm);

	if ($tcm == 0)
		{
		//re-direct
		$pesan = "MENU TERSEBUT DILUAR JANGKAUAN KEKUASAAN ANDA. Silahkan LOGOUT...!!";
		$ke = "$sumber/adm/logout.php";
		pekem($pesan, $ke);
		exit();
		}
	}
//************************************************************************************************
?>