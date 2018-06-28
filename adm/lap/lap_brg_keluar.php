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
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/index.html");

nocache;

//nilai
$filenya = "lap_brg_keluar.php";
$judul = "Laporan Barang Keluar";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$xtgl1 = nosql($_REQUEST['xtgl1']);
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$s = nosql($_REQUEST['s']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


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




//isi *START
ob_start();

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT DISTINCT(kd_brg) ".
				"FROM nota, nota_detail, m_brg ".
				"WHERE nota_detail.kd_nota = nota.kd ".
				"AND nota_detail.kd_brg = m_brg.kd ".
				"AND round(DATE_FORMAT(nota.tgl, '%d')) = '$xtgl1' ".
				"AND round(DATE_FORMAT(nota.tgl, '%m')) = '$xbln1' ".
				"AND round(DATE_FORMAT(nota.tgl, '%Y')) = '$xthn1' ".
				"ORDER BY m_brg.nama ASC";


$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?xtgl1=$xtgl1&xbln1=$xbln1&xthn1=$xthn1";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);

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
echo "<select name=\"xtgl1\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$xtgl1.'" selected>'.$xtgl1.'</option>';

for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$filenya.'?xtgl1='.$i.'">'.$i.'</option>';
	}

echo '</select>';

echo "<select name=\"xbln1\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$xbln1.'" selected>'.$arrbln[$xbln1].'</option>';

for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$filenya.'?xtgl1='.$xtgl1.'&xbln1='.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>';

echo "<select name=\"xthn1\" onChange=\"MM_jumpMenu('self',this,0)\">";
echo '<option value="'.$xthn1.'" selected>'.$xthn1.'</option>';


for ($k=$tahun;$k<=$tahun+1;$k++)
	{
	$x_thn = $k;

	echo '<option value="'.$filenya.'?xtgl1='.$xtgl1.'&xbln1='.$xbln1.'&xthn1='.$x_thn.'">'.$x_thn.'</option>';
	}


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
else
	{
	if ($count != 0)
		{
		//data - datanya
		echo '<table width="500" border="1" cellspacing="0" cellpadding="3">
		<tr bgcolor="'.$warnaheader.'">
		<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
		<td><strong><font color="'.$warnatext.'">Nama Barang</font></strong></td>
		<td width="100" align="center"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
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
			$brgkd = nosql($data['kd_brg']);

			//artinya....
			$qbrg = mysql_query("SELECT m_brg.*, m_satuan.* ".
									"FROM m_brg, m_satuan ".
									"WHERE m_brg.kd_satuan = m_satuan.kd ".
									"AND m_brg.kd = '$brgkd'");
			$rbrg = mysql_fetch_assoc($qbrg);
			$tbrg = mysql_num_rows($qbrg);
			$brg_kode = balikin($rbrg['kode']);
			$brg_nama = balikin($rbrg['nama']);
			$brg_satuan = balikin($rbrg['satuan']);


			//jumlahnya
			$qjml = mysql_query("SELECT SUM(qty) AS jml ".
									"FROM nota, nota_detail ".
									"WHERE nota_detail.kd_nota = nota.kd ".
									"AND round(DATE_FORMAT(nota.tgl, '%d')) = '$xtgl1' ".
									"AND round(DATE_FORMAT(nota.tgl, '%m')) = '$xbln1' ".
									"AND round(DATE_FORMAT(nota.tgl, '%Y')) = '$xthn1' ".
									"AND nota_detail.kd_brg = '$brgkd'");
			$rjml = mysql_fetch_assoc($qjml);
			$jml_qty = nosql($rjml['jml']);

			echo "<tr bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td>'.$brg_kode.'</td>
			<td>'.$brg_nama.'</td>
			<td align="right">
			'.$jml_qty.' '.$brg_satuan.'
			</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));

		echo '</table>
		<table width="500" border="0" cellspacing="0" cellpadding="3">
		<tr>
		<td width="100">
		<input name="xtgl1" type="hidden" value="'.$xtgl1.'">
		<input name="xbln1" type="hidden" value="'.$xbln1.'">
		<input name="xthn1" type="hidden" value="'.$xthn1.'">
		<input name="page" type="hidden" value="'.$page.'">
		[<a href="lap_brg_keluar_prt.php?xtgl1='.$xtgl1.'&xbln1='.$xbln1.'&xthn1='.$xthn1.'" title="PRINT...!!"><img src="../../img/print.gif" border="0"></a>]
		</td>
		<td align="right">
		<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
		</td>
		</tr>
		</table>';
		}
	else
		{
		echo '<font color="red"><strong>TIDAK ADA DATA BARANG KELUAR.</strong></font>';
		}
	}

echo '</form>
<br><br><br>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");

//null-kan
xfree($result);
xclose($koneksi);
exit();
?>