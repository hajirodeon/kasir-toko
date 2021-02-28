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
$filenya = "lap_brg.php";
$judul = "Laporan Daftar Barang";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}






//isi *START
ob_start();

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, m_satuan.* ".
				"FROM m_brg, m_kategori, m_satuan ".
				"WHERE m_brg.kd_kategori = m_kategori.kd ".
				"AND m_brg.kd_satuan = m_satuan.kd ".
				"ORDER BY m_brg.nama ASC";

$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);



//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/listmenu.js");
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>
<table width="600" border="1" cellspacing="0" cellpadding="3">
<tr valign="top" bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
<td width="450"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
</tr>';

if ($count != 0)
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
		$kd = nosql($data['mbkd']);
		$kategori = balikin($data['kategori']);
		$satuan = balikin($data['satuan']);
		$kode = nosql($data['kode']);
		$nama = balikin($data['nama']);

		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$kode.'</td>
		<td>'.$nama.'</td>
		<td>'.$kategori.'</td>
		<td>'.$satuan.'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</table>
<table width="600" border="0" cellspacing="0" cellpadding="3">
<tr>
<td><a href="lap_brg_prt.php" title="PRINT...!!"><img src="../../img/print.gif" border="0"></a></td>
<td align="right">
<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
</td>
</tr>
</table>
</td>
</tr>
</table>
</form>
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