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
$filenya = "lap_nota_prt.php";
$judul = "Laporan Nota";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$xtgl1 = nosql($_REQUEST['xtgl1']);
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$s = nosql($_REQUEST['s']);
$notakd = nosql($_REQUEST['notakd']);
$ke = "lap_nota.php?xtgl1=$xtgl1&xbln1=$xbln1&xthn1=$xthn1&notakd=$notakd";
$diload = "window.print();location.href='$ke';";




//isi *START
ob_start();

//query
$qdata = mysqli_query($koneksi, "SELECT nota.*, nota_detail.*, ".
						"nota_detail.kd AS ndkd, ".
						"nota_detail.qty AS ndqty, ".
						"m_brg.*, m_satuan.*, stock.* ".
						"FROM nota, nota_detail, m_brg, m_satuan, stock ".
						"WHERE nota.kd = nota_detail.kd_nota ".
						"AND nota_detail.kd_brg = m_brg.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND nota.kd = '$notakd' ".
						"ORDER BY nota.no_nota ASC");
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
<br>';

echo '<strong>Tanggal :</strong>
'.$xtgl1.' '.$arrbln[$xbln1].' '.$xthn1.',
<br>
<strong>No. Nota :</strong> ';

//terpilih
$qtru = mysqli_query($koneksi, "SELECT * FROM nota ".
						"WHERE round(DATE_FORMAT(tgl, '%d')) = '$xtgl1' ".
						"AND round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
						"AND kd = '$notakd'");
$rtru = mysqli_fetch_assoc($qtru);
$x_notakd = $notakd;
$x_no_nota = nosql($rtru['no_nota']);
$x_pelanggan = balikin($rtru['pelanggan']);


//terpilih --> total item
$qtru2 = mysqli_query($koneksi, "SELECT * FROM nota_detail ".
						"WHERE kd_nota = '$notakd'");
$rtru2 = mysqli_fetch_assoc($qtru2);
$ttru2 = mysqli_num_rows($qtru2);
$x_nota_items = nosql($ttru2);

echo ''.$x_no_nota.' => ['.$x_nota_items.' Item],
<br>
<strong>Pelanggan :</strong> '.$x_pelanggan.'';


//data - datanya
echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama Barang</font></strong></td>
<td width="100" align="center"><strong><font color="'.$warnatext.'">@ Harga</font></strong></td>
<td width="100" align="center"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
<td width="100" align="center"><strong><font color="'.$warnatext.'">SubTotal</font></strong></td>
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
		$kd = nosql($rdata['ndkd']);
		$kode = nosql($rdata['kode']);
		$nama = balikin($rdata['nama']);
		$satuan = balikin($rdata['satuan']);
		$ndqty = nosql($rdata['ndqty']);
		$hrg_jual = nosql($rdata['hrg_jual']);
		$subtotal = nosql($rdata['subtotal']);

		echo "<tr bgcolor=\"$warna\">";
		echo '<td>'.$kode.'</td>
		<td>'.$nama.'</td>
		<td align="right">
		'.xduit2($hrg_jual).'
		</td>
		<td align="right">
		'.$ndqty.' '.$satuan.'
		</td>
		<td align="right">
		'.xduit2($subtotal).'
		</td>
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
xclose($koneksi);
exit();
?>