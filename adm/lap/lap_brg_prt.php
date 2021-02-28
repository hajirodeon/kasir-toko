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

require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/adm.php");
$tpl = LoadTpl("../../template/print.html");

nocache;

//nilai
$filenya = "lap_brg_prt.php";
$judul = "Laporan Daftar Barang";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$ke = "lap_brg.php";
$diload = "window.print();location.href='$ke';";



//isi *START
ob_start();

//query
$qdata = mysqli_query($koneksi, "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, m_satuan.* ".
						"FROM m_brg, m_kategori, m_satuan ".
						"WHERE m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"ORDER BY m_brg.nama ASC");
$rdata = mysqli_fetch_assoc($qdata);
$tdata = mysqli_num_rows($qdata);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="center">
<br>';
xheadline($judul);
echo '</td>
</tr>
</table>

<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
<td width="450"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
</tr>';

if ($tdata != 0)
	{
	do
		{
		if ($warna_set ==0)
			{
			$warna = $warna01;
			$warna_set = 1;
			}
		else
			{
			$warna = $warna02;
			$warna_set = 0;
			}

		$nomer = $nomer + 1;
		$kd = nosql($rdata['mbkd']);
		$kategori = balikin($rdata['kategori']);
		$satuan = balikin($rdata['satuan']);
		$kode = nosql($rdata['kode']);
		$nama = balikin($rdata['nama']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\">";
		echo '<td>'.$kode.'</td>
		<td>'.$nama.'</td>
		<td>'.$kategori.'</td>
		<td>'.$satuan.'</td>
        </tr>';
		}
	while ($rdata = mysqli_fetch_assoc($qdata));
	}


echo '</table>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xfree($qdata);
xclose($koneksi);
exit();
?>