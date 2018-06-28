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


require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$filenya = "nota_brg.php";
$judul = "Daftar Stock";
$judulku = $judul;
$katcari = nosql($_REQUEST['katcari']);
$kunci = cegah($_REQUEST['kunci']);
$ke = "$filenya?katcari=$katcari&kunci=$kunci";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//keydown.
$x_enter2 = 'onKeyDown="return handleEnter(this, event)"';

//tombol "ESC"=27, utk. keluar
$dikeydown = "var keyCode = event.keyCode;
				if (keyCode == 27)
					{
					parent.brg_window.hide();
					}";

//focus
$diload = "document.formx.katcari.focus();";



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek reset
if ($_POST['btnRST'])
	{
	//re-direct
	xloc($filenya);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();

//query
$p = new Pager();
$start = $p->findStart($limit);

//jika cari /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnCRI'])
	{
	$katcari = nosql($_POST['katcari']);
	$kunci = cegah($_POST['kunci']);

	//nek null
	if ((empty($katcari)) OR (empty($kunci)))
		{
		//re-direct
		xloc($ke);
		exit();
		}
	else
		{
		//nek kode ==> c01
		if ($katcari == "c01")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, ".
							"m_satuan.*, stock.*, m_merk.* ".
							"FROM m_brg, m_kategori, m_satuan, stock, m_merk ".
							"WHERE m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_brg.kd_merk = m_merk.kd ".
							"AND stock.jml_toko > stock.jml_min ".
							"AND m_brg.kode LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		//nek nama ==> c02
		else if ($katcari == "c02")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, ".
							"m_satuan.*, stock.*, m_merk.* ".
							"FROM m_brg, m_kategori, m_satuan, stock, m_merk ".
							"WHERE m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_brg.kd_merk = m_merk.kd ".
							"AND stock.jml_toko > stock.jml_min ".
							"AND m_brg.nama LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		//nek kategori ==> c03
		else if ($katcari == "c03")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, ".
							"m_satuan.*, stock.*, m_merk.* ".
							"FROM m_brg, m_kategori, m_satuan, stock, m_merk ".
							"WHERE m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_brg.kd_merk = m_merk.kd ".
							"AND stock.jml_toko > stock.jml_min ".
							"AND m_kategori.kategori LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}
		}
	} ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else
	{
	//nek kode ==> c01
	if ($katcari == "c01")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, ".
						"m_satuan.*, stock.*, m_merk.* ".
						"FROM m_brg, m_kategori, m_satuan, stock, m_merk ".
						"WHERE m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_brg.kd_merk = m_merk.kd ".
						"AND stock.jml_toko > stock.jml_min ".
						"AND m_brg.kode LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nek nama ==> c02
	else if ($katcari == "c02")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, ".
						"m_satuan.*, stock.*, m_merk.* ".
						"FROM m_brg, m_kategori, m_satuan, stock, m_merk ".
						"WHERE m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_brg.kd_merk = m_merk.kd ".
						"AND stock.jml_toko > stock.jml_min ".
						"AND m_brg.nama LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nek kategori ==> c03
	else if ($katcari == "c03")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, ".
						"m_satuan.*, stock.*, m_merk.* ".
						"FROM m_brg, m_kategori, m_satuan, stock, m_merk ".
						"WHERE m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_brg.kd_merk = m_merk.kd ".
						"AND stock.jml_toko > stock.jml_min ".
						"AND m_kategori.kategori LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}
	}




//require
require("../../inc/js/down_enter.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>
<select name="katcari" class="btn-info" '.$x_enter2.'>
<option value="" selected></option>
<option value="c01">Kode</option>
<option value="c02">Nama</option>
<option value="c03">Kategori</option>
</select>

<input name="kunci" type="text" size="10" class="btn-info">
<input name="btnCRI" type="submit" value="CARI" class="btn-danger">
<input name="btnRST" type="submit" value="RESET" class="btn-warning">
</td>
</tr>
</table>';


//nek masih null
if (empty($katcari))
	{
	echo '<font color="#FF0000"><strong>Masukkan Kata Kunci...!</strong></font>';
	}
else
	{
	echo '<table width="700" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama Barang</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Merk</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Stock</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">@ Harga</font></strong></td>
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
			$merk = balikin($data['merk']);
			$kode = nosql($data['kode']);
			$nama = balikin($data['nama']);
			$hrg_jual = xduit2($data['hrg_jual']);
			$brg_jml = nosql($data['jml_toko']);

			//nek null
			if (empty($hrg_jual))
				{
				$hrg_jual = '-';
				}

			if (empty($brg_jml))
				{
				$brg_jml = '-';
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\"
			onClick=\"document.formx.kodex.value='$kode';
			parent.brg_window.hide();
			\">";
			echo '<td>'.$kode.'</td>
			<td>'.$nama.'</td>
			<td>'.$merk.'</td>
			<td>'.$kategori.'</td>
			<td>'.$brg_jml.'  '.$satuan.'</td>
			<td align="right">'.$hrg_jual.'</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}


	echo '</table>
	<table width="700" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input id="kodex" name="kodex" type="hidden" value="" size="10">
	</td>
	<td align="right">
	<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
	</td>
	</tr>
	</table>';
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