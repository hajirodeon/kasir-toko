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
$filenya = "lap_history_nota_prt.php";
$judul = "Laporan History Nota";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$brgkd = nosql($_REQUEST['brgkd']);
$ke = "lap_history_nota.php?xbln1=$xbln1&xthn1=$xthn1&brgkd=$brgkd";
$diload = "window.print();location.href='$ke';";



//isi *START
ob_start();


//query
$qdata = mysql_query("SELECT nota.*, nota_detail.*, m_brg.*, m_brg.nama AS mbnm, ".
						"m_satuan.* ".
						"FROM nota, nota_detail, m_brg, m_satuan ".
						"WHERE nota.kd = nota_detail.kd_nota ".
						"AND nota_detail.kd_brg = m_brg.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND m_brg.kd = '$brgkd' ".
						"AND round(DATE_FORMAT(nota.tgl, '%m')) = '$xbln1' ".
						"AND round(DATE_FORMAT(nota.tgl, '%Y')) = '$xthn1' ".
						"ORDER BY nota.tgl ASC");
$rdata = mysql_fetch_assoc($qdata);
$tdata = mysql_num_rows($qdata);

//nilai data
$brg_kode = nosql($rdata['kode']);
$brg_nm = balikin($rdata['mbnm']);



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="center">
<br>';
xheadline($judul);
echo '</td>
</tr>
</table>

<br><br>';


echo 'Bulan : <strong>'.$arrbln[$xbln1].' '.$xthn1.'</strong>;
Kode Barang : <strong>'.$brg_kode.'</strong>,
Nama Barang : <strong>'.$brg_nm.'</strong>';

echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="100"><strong><font color="'.$warnatext.'">Tanggal</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">No. Faktur</font></strong></td>
<td><strong><font color="'.$warnatext.'">Kastumer</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
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
		$y_kd = nosql($rdata['kd']);
		$y_tgl = $rdata['tgl'];
		$y_no_nota = balikin($rdata['no_nota']);
		$y_pelanggan = balikin($rdata['pelanggan']);
		$y_qty = nosql($rdata['qty']);
		$y_satuan = balikin($rdata['satuan']);

		//nek null
		if (empty($y_pelanggan))
			{
			$y_pelanggan = "-";
			}

		echo "<tr valign=\"top\" bgcolor=\"$warna\">";
		echo '<td>'.$y_tgl.'</td>
		<td>'.$y_no_nota.'</td>
		<td>'.$y_pelanggan.'</td>
		<td>'.$y_qty.' '.$y_satuan.'</td>
        </tr>';
		}
	while ($rdata = mysql_fetch_assoc($qdata));
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