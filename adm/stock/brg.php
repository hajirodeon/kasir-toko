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
$filenya = "brg.php";
$judul = "Stock Barang";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$diload = "document.formx.katcari.focus();";
$s = nosql($_REQUEST['s']);
$katcari = nosql($_REQUEST['katcari']);
$kunci = cegah($_REQUEST['kunci']);
$ke = $filenya;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//nek enter, ke simpan
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	}"';

//nek enter, ke cari
$x_enter2 = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnCRI.focus();
	}"';

$x_enter3 = 'onkeydown="return handleEnter(this, event)"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//re-direct
	xloc($ke);
	exit();
	}



//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$katcari = nosql($_POST['katcari']);
	$kunci = cegah($_POST['kunci']);
	$page = nosql($_POST['page']);

	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}

	for ($ongko=1;$ongko<=$limit;$ongko++)
		{
		$xkd = "kd";
		$xkd1 = "$xkd$ongko";
		$xkdx = nosql($_POST["$xkd1"]);


		$xtk = "tk";
		$xtk1 = "$xtk$ongko";
		$xtkx = nosql($_POST["$xtk1"]);


		//sesuaikan
		mysqli_query($koneksi, "UPDATE stock SET jml_toko = '$xtkx' ".
						"WHERE kd_brg = '$xkdx'");
		}

	//null-kan
	xfree($qbw);
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}




//jika hapus
if ($_POST['btnHPS'])
	{
	//ambil nilai
	$katcari = nosql($_POST['katcari']);
	$kunci = cegah($_POST['kunci']);
	$page = nosql($_POST['page']);
	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	for ($i=1;$i<=$limit;$i++)
		{
		//ambil nilai
		$yuk = "item";
		$yuhu = "$yuk$i";
		$kd = nosql($_POST["$yuhu"]);

		//del --> m_brg
		mysqli_query($koneksi, "DELETE FROM m_brg ".
						"WHERE kd = '$kd'");

		//del --> stock
		mysqli_query($koneksi, "DELETE FROM stock ".
						"WHERE kd_brg = '$kd'");

		//del --> stock_hilang
		mysqli_query($koneksi, "DELETE FROM stock_hilang ".
						"WHERE kd_brg = '$kd'");

		//del --> stock rusak
		mysqli_query($koneksi, "DELETE FROM stock_rusak ".
						"WHERE kd_brg = '$kd'");

		//del --> nota_detail
		mysqli_query($koneksi, "DELETE FROM nota_detail ".
						"WHERE kd_brg = '$kd'");

		}

	//null-kan
	xfree($qbw);
	xclose($koneksi);

	//auto-kembali
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();

//query
$p = new Pager();
$start = $p->findStart($limit);

//jika cari
if (($_POST['btnCRI']) OR ($_POST['kunci']))
	{
	$katcari = nosql($_POST['katcari']);
	$kunci = cegah($_POST['kunci']);

	//nek null
	if ((empty($katcari)) OR (empty($kunci)))
		{
		//null-kan
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Anda Belum Memasukkan Kata Kunci Pencarian. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
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
echo '<script type="text/javascript" src="'.$sumber.'/inc/js/dhtmlwindow_adm.js"></script>
<script type="text/javascript" src="'.$sumber.'/inc/js/modal.js"></script>
<script type="text/javascript">
function open_entry()
	{
	entry_window=dhtmlmodal.open(\'Entry Stock Barang\',
	\'iframe\',
	\'brg_entry.php\',
	\'Entry Stock Barang\',
	\'width=700px,height=500px,center=1,resize=0,scrolling=0\');

	entry_window.onClose=function()
		{
		location.href=\''.$filenya.'?katcari='.$katcari.'&kunci='.$kunci.'&page='.$page.'\';

		return true
		}
	}

function open_edit()
	{
	edit_window=dhtmlmodal.open(\'Edit Stock Barang\',
	\'iframe\',
	\'brg_entry_edit.php\',
	\'Edit Stock Barang\',
	\'width=700px,height=190px,center=1,resize=0,scrolling=0\');

	edit_window.onClose=function()
		{
		location.href=\''.$filenya.'?katcari='.$katcari.'&kunci='.$kunci.'&page='.$page.'\';

		return true
		}
	}
</script>';


//total semua barang
$qtotg = mysqli_query($koneksi, "SELECT m_brg.*, stock.* ".
						"FROM m_brg, stock ".
						"WHERE stock.kd_brg = m_brg.kd");
$rtotg = mysqli_fetch_assoc($qtotg);
$ttotg = mysqli_num_rows($qtotg);


//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
require("../../inc/js/swap.js");
require("../../inc/js/down_enter.js");
require("../../inc/js/listmenu.js");
require("../../inc/menu/adm.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo ' [<a href="" onClick="open_entry(); return false">ENTRY Stock</a>]
</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<select name="katcari" '.$x_enter3.' class="btn btn-info">
<option value="" selected></option>
<option value="c01">Kode</option>
<option value="c02">Nama</option>
<option value="c03">Kategori</option>
<option value="c04">Merk</option>
<option value="c05">Satuan</option>
</select>

<input name="kunci" type="text" size="15" class="btn btn-info">
<input name="btnCRI" type="submit" value="CARI" class="btn btn-danger">
<input name="btnBTL" type="submit" value="RESET" class="btn btn-warning">
</td>
<td align="right">
Total Semua Barang : <strong>'.$ttotg.'</strong>
</td>
</tr>
</table>';

//nek gak null
if ((!empty($katcari)) AND (!empty($kunci)))
	{
	echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="1">&nbsp;</td>
	<td width="1">&nbsp;</td>
	<td width="50">
	<strong><font color="'.$warnatext.'">Kode</font></strong>
	</td>

	<td width="200">
	<strong><font color="'.$warnatext.'">Nama</font></strong>
	</td>

	<td width="50">
	<strong><font color="'.$warnatext.'">Merk</font></strong>
	</td>

	<td width="50">
	<strong><font color="'.$warnatext.'">Kategori</font></strong>
	</td>

	<td width="50">
	<strong><font color="'.$warnatext.'">Satuan</font></strong>
	</td>

	<td width="50" align="center">
	<strong><font color="'.$warnatext.'">Stock. Toko</font></strong>
	</td>

	<td width="50" align="center">
	<strong><font color="'.$warnatext.'">Stock. Min.</font></strong>
	</td>


	<td width="75" align="center">
	<strong><font color="'.$warnatext.'">Hrg. Beli</font></strong>
	</td>

	<td width="75" align="center">
	<strong><font color="'.$warnatext.'">Hrg. Jual</font></strong>
	</td>

	<td width="75" align="center">
	<strong><font color="'.$warnatext.'">BARCODE</font></strong>
	</td>
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

			//pageup
			$nil = $nomer - 1;

			if ($nil < 1)
				{
				$nil = 1;
				}

			if ($nil > $limit)
				{
				$nil = $limit;
				}

			//pagedown
			$nild = $nomer + 1;

			if ($nild < 1)
				{
				$nild = $nild + 1;
				}

			if ($nild > $limit)
				{
				$nild = $limit;
				}



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
			$brgkd = nosql($data['mbkd']);
			$kode = nosql($data['kode']);
			$nama = balikin($data['nama']);
			$jml_toko = nosql($data['jml_toko']);
			$jml_min = nosql($data['jml_min']);
			$jml_total = $jml_toko;
			$hrg_beli = nosql($data['hrg_beli']);
			$hrg_jual = nosql($data['hrg_jual']);
			$st_barkode = nosql($data['barkode']);

			//nek ada
			if (!empty($st_barkode))
				{
				$st_barkode = "<strong>ADA BARCODE</strong>";
				}
			else
				{
				$st_barkode = "<em>TIDAK ADA</em> Barcode";
				}



			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$brgkd.'">
			<input type="checkbox" name="item'.$nomer.'" value="'.$brgkd.'">
	        </td>
			<td>
			<a title="('.$kode.'). '.$nama.'" onClick="
			edit_window=dhtmlmodal.open(\'Edit Stock Barang\', \'iframe\', \'brg_entry_edit.php?s=edit&brgkd='.$brgkd.'\', \'Edit Stock Barang\', \'width=700px,height=450px,center=1,resize=0,scrolling=0\');
			edit_window.onClose=function()
				{
				location.href=\''.$filenya.'?katcari='.$katcari.'&kunci='.$kunci.'&page='.$page.'\';

				return true
				}
			">
			<img src="'.$sumber.'/img/edit.gif" width="16" height="16" border="0">
			</a>
			</td>
			<td>'.$kode.'</td>
			<td>'.$nama.'</td>
			<td>'.$merk.'</td>
			<td>'.$kategori.'</td>
			<td>'.$satuan.'</td>
			<td align="center">
			<input name="tk'.$nomer.'" type="text" style="text-align:right" class="btn btn-info" value="'.$jml_toko.'"
			onKeyPress="return numbersonly(this, event)"
			onKeyUp="document.formx.gd'.$nomer.'.value=eval(document.formx.jtot'.$nomer.'.value) - eval(document.formx.tk'.$nomer.'.value);"
			onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 38)
					{
					document.formx.tk'.$nil.'.focus();
					}

				if (keyCode == 40)
					{
					document.formx.tk'.$nild.'.focus();
					}

				if (keyCode == 13)
					{
					document.formx.btnSMP.focus();
					document.formx.btnSMP.submit();
					}
			"
			size="5">
			</td>
			<td align="center">
			<input name="jmin'.$nomer.'" type="text" style="text-align:right" value="'.$jml_min.'" size="5" class="btn btn-warning" readonly>
			</td>
			<td align="center">
			<input name="hb'.$nomer.'" type="text" style="text-align:right" value="'.$hrg_beli.'" size="10" class="btn btn-warning" readonly>
			</td>
			<td align="center">
			<input name="hj'.$nomer.'" type="text" style="text-align:right" value="'.$hrg_jual.'" size="10" class="btn btn-warning" readonly>
			</td>
			<td align="center">'.$st_barkode.'</td>
	        </tr>';


			//null-kan
			xfree($qikat);
			xfree($qist);
			xfree($qimerk);
			}
		while ($data = mysqli_fetch_assoc($result));
		}


	echo '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td>
	<input name="jml" type="hidden" value="'.$limit.'">
	<input name="katkd" type="hidden" value="'.$katkd.'">
	<input name="s" type="hidden" value="'.$s.'">
	<input name="brgkd" type="hidden" value="'.$brgkd.'">
	<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')" class="btn btn-primary">
	<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
	<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
	<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
	</td>
	<td align="right" width="300">
	<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
	</td>
	</tr>
	</table>';

	xfree($result);
	}

echo '</form>
<br><br><br>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xfree($qbw);
xclose($koneksi);
exit();
?>