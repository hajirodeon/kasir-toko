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
$filenya = "iron.php";
$judul = "Iron Stock";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?page=$page";





//isi *START
ob_start();

//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, ".
				"m_satuan.*, stock.* ".
				"FROM m_brg, m_kategori, m_satuan, stock ".
				"WHERE m_brg.kd_kategori = m_kategori.kd ".
				"AND m_brg.kd_satuan = m_satuan.kd ".
				"AND stock.kd_brg = m_brg.kd ".
				"AND stock.jml_toko < stock.jml_min ".
				"ORDER BY m_brg.kode ASC";

$sqlresult = $sqlcount;

$count = mysql_num_rows(mysql_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysql_fetch_array($result);



//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/listmenu.js");
require("../../inc/menu/adm.php");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="900" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
<td><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Minimal Stock</font></strong></td>
<td width="120"><strong><font color="'.$warnatext.'">Stock Sekarang</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Habis</font></strong></td>
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

		//stock
		$qto = mysql_query("SELECT * FROM stock ".
								"WHERE kd_brg = '$kd'");
		$rto = mysql_fetch_assoc($qto);
		$jml_min = nosql($rto['jml_min']);
		$jml_total = nosql($rto['jml_toko']);

		//habis...?
		$qhbs = mysql_query("SELECT * FROM stock ".
								"WHERE kd_brg = '$kd' ".
								"AND stock.jml_toko <= '0'");
		$rhbs = mysql_fetch_assoc($qhbs);
		$thbs = mysql_num_rows($qhbs);

		//nek iya
		if ($thbs != 0)
			{
			$hbs_status = "YA.";
			}
		else
			{
			$hbs_status = "BELUM.";
			}



		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'"> '.$kode.'</td>
		<td>'.$nama.'</td>
		<td>'.$kategori.'</td>
		<td>'.$satuan.'</td>
		<td><strong>'.$jml_min.'</strong></td>
		<td><font color="red"><strong>'.$jml_total.'</strong></font></td>
		<td><strong>'.$hbs_status.'</strong></td>
        </tr>';
		}
	while ($data = mysql_fetch_assoc($result));
	}


echo '</table>
<table width="900" border="0" cellspacing="0" cellpadding="3">
<tr>
<td align="right">
<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
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
xfree($qbw);
xfree($result);
xclose($koneksi);
exit();
?>