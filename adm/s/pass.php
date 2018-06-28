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


session_start();

//ambil nilai
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "pass.php";
$diload = "document.formx.passlama.focus();";
$judul = "Ganti Password";
$judulku = "[$admin_session : $username1_session] ==> $judul  ";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}


//simpan
if ($_POST['btnSMP'])
	{
	//ambil nilai
	$passlama = md5(nosql($_POST["passlama"]));
	$passbaru = md5(nosql($_POST["passbaru"]));
	$passbaru2 = md5(nosql($_POST["passbaru2"]));


	//nek null
	if ((empty($passlama)) OR (empty($passbaru)) OR (empty($passbaru2)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else if ($passbaru != $passbaru2) //nek passbaru gak sama dgn passbaru2
		{
		//re-direct
		$pesan = "Password Baru Tidak Sesuai. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//query
		$q = mysql_query("SELECT * FROM admin ".
							"WHERE kd = '$kd1_session' ".
							"AND username = '$username1_session' ".
							"AND password = '$passlama'");
		$row = mysql_fetch_assoc($q);
		$total = mysql_num_rows($q);

		//cek
		if ($total != 0)
			{
			//perintah SQL
			mysql_query("UPDATE admin SET password = '$passbaru' ".
							"WHERE kd = '$kd1_session' ".
							"AND username = '$username1_session'");

			//null-kan
			xfree($q);
			xfree($qbw);

			//auto-kembali
			$pesan = "PASSWORD BERHASIL DIGANTI. Silahkan Login Kembali.";
			$ke = "../logout.php";
			pekem($pesan, $ke);
			exit();
			}
		else
			{
			//null-kan
			xfree($q);
			xfree($qbw);

			//re-direct
			$pesan = "PASSWORD LAMA TIDAK COCOK. HARAP DIULANGI...!!!";
			pekem($pesan, $filenya);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

require("../../inc/js/jumpmenu.js");
require("../../inc/js/down_enter.js");
require("../../inc/js/listmenu.js");
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<p>Password Lama : <br>
<input name="passlama" type="password" size="15" class="btn btn-info">
</p>
<p>Password Baru : <br>
<input name="passbaru" type="password" size="15" class="btn btn-info">
</p>
<p>RE-Password Baru : <br>
<input name="passbaru2" type="password" size="15" class="btn btn-info">
</p>
<p>
<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
<input name="btnBTL" type="submit" value="BATAL" class="btn btn-warning">
</p>
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xfree($qbw);
xclose($koneksi);
exit();
?>