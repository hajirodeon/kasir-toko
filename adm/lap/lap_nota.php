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
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "lap_nota.php";
$judul = "Laporan Nota";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$xtgl1 = nosql($_REQUEST['xtgl1']);
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$s = nosql($_REQUEST['s']);
$notakd = nosql($_REQUEST['notakd']);


//focus
if (empty($xtgl1))
	{
	$diload = "document.formx.xtgl1.focus();";
	}
else if (empty($xbln1))
	{
	$diload = "document.formx.xbln1.focus();";
	}
else if (empty($xthn1))
	{
	$diload = "document.formx.xthn1.focus();";
	}
else if (empty($notakd))
	{
	$diload = "document.formx.notakd.focus();";
	}






//isi *START
ob_start();



//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/listmenu.js");
require("../../inc/menu/adm.php");



//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo '</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warna02.'">
<td>
Tanggal : ';
echo "<select name=\"xtgl1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn-info\">";
echo '<option value="'.$xtgl1.'" selected>'.$xtgl1.'</option>';

for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$filenya.'?xtgl1='.$i.'">'.$i.'</option>';
	}

echo '</select>';

echo "<select name=\"xbln1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn-info\">";
echo '<option value="'.$xbln1.'" selected>'.$arrbln[$xbln1].'</option>';

for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$filenya.'?xtgl1='.$xtgl1.'&xbln1='.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>';

echo "<select name=\"xthn1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn-info\">";
echo '<option value="'.$xthn1.'" selected>'.$xthn1.'</option>';

for ($k=$tahun;$k<=$tahun+1;$k++)
	{
	$x_thn = $k;

	echo '<option value="'.$filenya.'?xtgl1='.$xtgl1.'&xbln1='.$xbln1.'&xthn1='.$x_thn.'">'.$x_thn.'</option>';
	}


echo '</select>,
No. Nota : ';
echo "<select name=\"notakd\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn-info\">";

//terpilih
$qtru = mysql_query("SELECT * FROM nota ".
						"WHERE round(DATE_FORMAT(tgl, '%d')) = '$xtgl1' ".
						"AND round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
						"AND kd = '$notakd'");
$rtru = mysql_fetch_assoc($qtru);
$x_notakd = $notakd;
$x_no_nota = nosql($rtru['no_nota']);
$x_pelanggan = balikin($rtru['pelanggan']);
$x_total = nosql($rtru['total']);

//terpilih --> total item
$qtru2 = mysql_query("SELECT * FROM nota_detail ".
						"WHERE kd_nota = '$notakd'");
$rtru2 = mysql_fetch_assoc($qtru2);
$ttru2 = mysql_num_rows($qtru2);
$x_nota_items = nosql($ttru2);

echo '<option value="'.$x_notakd.'" selected>'.$x_no_nota.' => ['.$x_nota_items.' Item]. [Pelanggan : '.$x_pelanggan.'].</option>';

//data
$qtrux = mysql_query("SELECT * FROM nota ".
						"WHERE round(DATE_FORMAT(tgl, '%d')) = '$xtgl1' ".
						"AND round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
						"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
						"AND kd <> '$notakd' ".
						"ORDER BY round(no_nota) ASC");
$rtrux = mysql_fetch_assoc($qtrux);

do
	{
	$i_notakd = nosql($rtrux['kd']);
	$i_no_nota = nosql($rtrux['no_nota']);
	$i_pelanggan = nosql($rtrux['pelanggan']);


	//jumlahnya
	$qyukx = mysql_query("SELECT * FROM nota_detail ".
							"WHERE kd_nota = '$i_notakd'");
	$ryukx = mysql_fetch_assoc($qyukx);
	$tyukx = mysql_num_rows($qyukx);
	$i_nota_items = $tyukx;

	echo '<option value="'.$filenya.'?xtgl1='.$xtgl1.'&xbln1='.$xbln1.'&xthn1='.$xthn1.'&notakd='.$i_notakd.'">
	'.$i_no_nota.' => ['.$i_nota_items.' Item]. [Pelanggan : '.$i_pelanggan.'].</option>';
	}
while ($rtrux = mysql_fetch_assoc($qtrux));

echo '</select>
</td>
</tr>
</table>
<br>';


//nek masih do null
if (empty($xtgl1))
	{
	echo "<strong>Tanggal Belum Dipilih...!!</strong>";
	}
else if (empty($xbln1))
	{
	echo "<strong>Bulan Belum Dipilih...!!</strong>";
	}
else if (empty($xthn1))
	{
	echo "<strong>Tahun Belum Dipilih...!!</strong>";
	}
else if (empty($notakd))
	{
	echo "<strong>No. Nota Belum Dipilih...!!</strong>";
	}
else
	{
	//query
	$qnot = mysql_query("SELECT nota.*, nota_detail.*, ".
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
	$rnot = mysql_fetch_assoc($qnot);
	$tnot = mysql_num_rows($qnot);

	if ($tnot != 0)
		{
		//data - datanya
		echo 'Total : <strong>'.xduit2($x_total).'</strong>
		<br>
		<table width="700" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama Barang</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">@ Harga</font></strong></td>
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
		<td width="150" align="center"><strong><font color="'.$warnatext.'">SubTotal</font></strong></td>
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
			$kd = nosql($rnot['ndkd']);
			$kode = nosql($rnot['kode']);
			$nama = balikin($rnot['nama']);
			$satuan = balikin($rnot['satuan']);
			$ndqty = nosql($rnot['ndqty']);
			$hrg_jual = nosql($rnot['hrg_jual']);
			$subtotal = nosql($rnot['subtotal']);



			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
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
		while ($rnot = mysql_fetch_assoc($qnot));

		echo '</table>
		<table width="700" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td>
		<input name="xtgl1" type="hidden" value="'.$xtgl1.'">
		<input name="xbln1" type="hidden" value="'.$xbln1.'">
		<input name="xthn1" type="hidden" value="'.$xthn1.'">
		<input name="notakd" type="hidden" value="'.$notakd.'">
		[<a href="lap_nota_prt.php?notakd='.$notakd.'&xtgl1='.$xtgl1.'&xbln1='.$xbln1.'&xthn1='.$xthn1.'" title="PRINT...!!"><img src="../../img/print.gif" border="0"></a>]
		</td>
		<td align="right"><strong><font color="#FF0000">'.$tnot.'</font></strong> Data.</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<font color="red"><strong>TIDAK ADA DATA.</strong></fonr>';
		}
	}

echo '</form>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>