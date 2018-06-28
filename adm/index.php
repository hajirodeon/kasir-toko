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
require("../inc/config.php");
require("../inc/fungsi.php");
require("../inc/koneksi.php");
require("../inc/cek/adm.php");
$tpl = LoadTpl("../template/index.html");


nocache;

//nilai
$filenya = "index.php";
$judul = "Selamat Datang di Area Pengelolaan Administrasi $nama_toko.";
$judulku = "$judul  [$admin_session : $username1_session]";
$diload = "isodatetime();";


//isi *START
ob_start();

require("../inc/js/jam.js");
require("../inc/js/jumpmenu.js");
require("../inc/js/listmenu.js");
require("../inc/menu/adm.php");

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form name="formx" method="post">
<p>&nbsp;</p>
<p align="center">
Selamat Datang, Pengelola : <strong>'.$username1_session.'</strong>
</p>

<p align="center">
<em>Semua Kebutuhan dan Keperluan Administrasi, Harap Dikelola Dengan Baik.</em>
</p>
<p>&nbsp;</p>
<h3 align="center">
['.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'].
<br>
<input type="text" name="display_jam" size="6" style="border:0;font-size:27;">
</h3>
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>