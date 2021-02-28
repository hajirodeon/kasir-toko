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
$filenya = "lap_item_laris_prt.php";
$judul = "Laporan Item Terlaris";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$ke = "lap_item_laris.php?xbln1=$xbln1&xthn1=$xthn1";
$diload = "window.print();location.href='$ke';";




//isi *START
ob_start();




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo '</td>
</tr>
</table>';

//query
$qdata = mysqli_query($koneksi, "SELECT item_laris.*, m_brg.*, m_kategori.* ".
						"FROM item_laris, m_brg, m_kategori ".
						"WHERE item_laris.kd_brg = m_brg.kd ".
						"AND m_brg.kd_kategori = m_kategori.kd ".
						"AND round(item_laris.bln) = '$xbln1' ".
						"AND round(item_laris.thn) = '$xthn1' ".
						"ORDER BY round(item_laris.jml) DESC");
$rdata = mysqli_fetch_assoc($qdata);
$tdata = mysqli_num_rows($qdata);

//nek ada
if ($tdata != 0)
	{
	//data - datanya
	echo '<table width="600" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="5"><strong><font color="'.$warnatext.'">No.</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama Barang</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Jumlah Terjual</font></strong></td>
	</tr>';

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
		$x_kode = nosql($rdata['kode']);
		$x_nama = balikin($rdata['nama']);
		$x_kategori = balikin($rdata['kategori']);
		$x_jml = nosql($rdata['jml']);

		echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$nomer.'.</td>
		<td>'.$x_kode.'</td>
		<td>'.$x_nama.'</td>
		<td>'.$x_kategori.'</td>
		<td>'.$x_jml.'</td>
        </tr>';
		}
	while ($rdata = mysqli_fetch_assoc($qdata));

	echo '</table>';
	}

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>