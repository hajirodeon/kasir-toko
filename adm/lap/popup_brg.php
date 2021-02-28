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
require("../../inc/class/paging.php");
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$filenya = "popup_brg.php";
$judul = "Daftar Barang";
$judulku = $judul;
$s = nosql($_REQUEST['s']);
$katcari = nosql($_REQUEST['katcari']);
$kunci = cegah($_REQUEST['kunci']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}


$x_enter2 = 'onKeyDown="return handleEnter(this, event)"';


//focus
$diload = "document.formx.katcari.focus();";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek reset
if ($_POST['btnRST'])
	{
	//nilai
	xloc($ke);
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
		$pesan = "Anda Belum Memasukkan Kata Kunci Pencarian. Harap Diulangi...!!";
		pekem($pesan,$ke);
		}
	else
		{
		//nek kode ==> c01
		if ($katcari == "c01")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, stock.* ".
							"FROM m_brg, stock ".
							"WHERE stock.kd_brg = m_brg.kd ".
							"AND m_brg.kode LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}

		//nek nama ==> c02
		else if ($katcari == "c02")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, stock.* ".
							"FROM m_brg, stock ".
							"WHERE stock.kd_brg = m_brg.kd ".
							"AND m_brg.nama LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}

		//nek kategori ==> c03
		else if ($katcari == "c03")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, stock.* ".
							"FROM m_brg, m_kategori, stock ".
							"WHERE m_brg.kd_kategori = m_kategori.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_kategori.kategori LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}

		//nek merk ==> c04
		else if ($katcari == "c04")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, stock.* ".
							"FROM m_brg, m_merk, stock ".
							"WHERE m_brg.kd_merk = m_merk.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_merk.merk LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}

		//nek satuan ==> c05
		else if ($katcari == "c05")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_satuan.*, stock.* ".
							"FROM m_brg, m_satuan, stock ".
							"WHERE m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_satuan.satuan LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}
		}
	}
else
	{
	//nek kode ==> c01
	if ($katcari == "c01")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, stock.* ".
						"FROM m_brg, stock ".
						"WHERE stock.kd_brg = m_brg.kd ".
						"AND m_brg.kode LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	//nek nama ==> c02
	else if ($katcari == "c02")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, stock.* ".
						"FROM m_brg, stock ".
						"WHERE stock.kd_brg = m_brg.kd ".
						"AND m_brg.nama LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	//nek kategori ==> c03
	else if ($katcari == "c03")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_kategori.*, stock.* ".
						"FROM m_brg, m_kategori, stock ".
						"WHERE m_brg.kd_kategori = m_kategori.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_kategori.kategori LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	//nek merk ==> c04
	else if ($katcari == "c04")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, stock.* ".
						"FROM m_brg, m_merk, stock ".
						"WHERE m_brg.kd_merk = m_merk.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_merk.merk LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}

	//nek satuan ==> c05
	else if ($katcari == "c05")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_satuan.*, stock.* ".
						"FROM m_brg, m_satuan, stock ".
						"WHERE m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_satuan.satuan LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysqli_num_rows(mysqli_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysqli_fetch_array($result);
		}
	}





//require
require("../../inc/js/down_enter.js");
require("../../inc/js/swap.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="3" cellpadding="0" bgcolor="'.$warnaover.'">
<tr valign="top">
<td>
<select name="katcari" '.$x_enter2.'>
<option value="" selected></option>
<option value="c01">Kode</option>
<option value="c02">Nama</option>
<option value="c03">Kategori</option>
<option value="c04">Merk</option>
<option value="c05">Satuan</option>
</select>

<input name="kunci" type="text" size="10">
<input name="btnCRI" type="submit" value="CARI">
<input name="btnRST" type="submit" value="RESET">
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
	echo '<table width="680" border="1" cellspacing="0" cellpadding="3">
	<tr valign="top" bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
	<td><strong><font color="'.$warnatext.'">Nama Barang</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Merk</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Stock Toko</font></strong></td>
	<td width="100"><strong><font color="'.$warnatext.'">Stock Gudang</font></strong></td>
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

			//kategori
			$katkd = nosql($data['kd_kategori']);
			$qikat = mysqli_query($koneksi, "SELECT * FROM m_kategori ".
									"WHERE kd = '$katkd'");
			$rikat = mysqli_fetch_assoc($qikat);
			$ikat_kat = balikin($rikat['kategori']);

			//satuan
			$stkd = nosql($data['kd_satuan']);
			$qist = mysqli_query($koneksi, "SELECT * FROM m_satuan ".
									"WHERE kd = '$stkd'");
			$rist = mysqli_fetch_assoc($qist);
			$ist_st = balikin($rist['satuan']);

			//mer
			$merkkd = nosql($data['kd_merk']);
			$qimerk = mysqli_query($koneksi, "SELECT * FROM m_merk ".
									"WHERE kd = '$merkkd'");
			$rimerk = mysqli_fetch_assoc($qimerk);
			$imerk_merk = balikin($rimerk['merk']);



			$merk = $imerk_merk;
			$kategori = $ikat_kat;
			$satuan = $ist_st;
			$kd = nosql($data['mbkd']);
			$kode = nosql($data['kode']);
			$nama = balikin($data['nama']);
			$jml_gudang = nosql($data['jml_gudang']);
			$jml_toko = nosql($data['jml_toko']);


			//nek null
			if (empty($jml_toko))
				{
				$jml_toko = "-";
				}

			if (empty($jml_gudang))
				{
				$jml_gudang = "-";
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\"
			onClick=\"document.formx.kodex.value='$kode';
			parent.brg_window.hide();
			\">";
			echo '<td>'.$kode.'</td>
			<td>'.$nama.'</td>
			<td>'.$kategori.'</td>
			<td>'.$merk.'</td>
			<td>'.$satuan.'</td>
			<td>'.$jml_toko.'</td>
			<td>'.$jml_gudang.'</td>
	        </tr>';
			}
		while ($data = mysqli_fetch_assoc($result));
		}


	echo '</table>
	<table width="680" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input id="kodex" name="kodex" type="hidden" value="" size="10">
	</td>

	<td>
	<div align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'</div>
	</td>
	</tr>
	</table>';
	}

echo '</form>
<br><br><br>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>