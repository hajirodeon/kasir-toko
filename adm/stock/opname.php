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
$filenya = "opname.php";
$judul = "Stock Opname";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$katcari = nosql($_REQUEST['katcari']);
$kunci = cegah($_REQUEST['kunci']);
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$diload = "document.formx.katcari.focus()";
$ke = "$filenya?katcari=$katcari&kunci=$kunci&page=$page";

$x_enter3 = 'onkeydown="return handleEnter(this, event)"';


//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	//null-kan
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}





//nek reset
if ($_POST['btnRST'])
	{
	//null-kan
	xclose($koneksi);

	//re-direct
	xloc($filenya);
	exit();
	}






//jika simpan
if ($_POST['btnSMP'])
	{
	//nilai
	$page = nosql($_POST['page']);
	$katcari = nosql($_POST['katcari']);
	$kunci = cegah($_POST['kunci']);
	$ke = "$filenya?katcari=$katcari&kunci=$kunci&page=$page";


	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}

	for($ongko=1;$ongko<=$limit;$ongko++)
		{
		$xko = md5("$x$ongko");

		$xkd = "kd";
		$xkd1 = "$xkd$ongko";
		$xkdx = nosql($_POST["$xkd1"]);


		$xtk = "tk";
		$xtk1 = "$xtk$ongko";
		$xtkx = nosql($_POST["$xtk1"]);

		$xjm = "jmin";
		$xjm1 = "$xjm$ongko";
		$xjmx = nosql($_POST["$xjm1"]);

		$xhb = "hb";
		$xhb1 = "$xhb$ongko";
		$xhbx = nosql($_POST["$xhb1"]);

		$xhj = "hj";
		$xhj1 = "$xhj$ongko";
		$xhjx = nosql($_POST["$xhj1"]);

		//cek, perubahan nilai ?
		$qcc = mysql_query("SELECT * FROM stock ".
							"WHERE kd_brg = '$xkdx'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$jml_tk = nosql($rcc['jml_toko']);
		$jml_min = nosql($rcc['jml_min']);
		$hrg_beli = nosql($rcc['hrg_beli']);
		$hrg_jual = nosql($rcc['hrg_jual']);


		//jika null, nol-kan
		if (empty($xgdx))
			{
			$xgdx = '0';
			}

		if (empty($xtkx))
			{
			$xtkx = '0';
			}

		if (empty($xjmx))
			{
			$xjmx = '0';
			}

		if (empty($xhbx))
			{
			$xhbx = '0';
			}

		if (empty($xhjx))
			{
			$xhjx = '0';
			}


		//jml stock
		if (($jml_gd != $xgdx) OR ($jml_tk != $xtkx) OR ($jml_min != $xjmx))
			{
			//sesuaikan
			mysql_query("UPDATE stock SET jml_toko = '$xtkx', jml_min = '$xjmx' ".
							"WHERE kd_brg = '$xkdx'");
			}

		//harga stock
		if (($hrg_beli != $xhbx) OR ($hrg_jual != $xhjx))
			{
			//sesuaikan
			mysql_query("UPDATE stock SET hrg_beli = '$xhbx', ".
							"hrg_jual = '$xhjx' ".
							"WHERE kd_brg = '$xkdx'");
			}
		}

	//null-kan
	xfree($qbw);
	xclose($koneksi);

	//re-direct
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
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
							"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
							"WHERE m_brg.kd_merk = m_merk.kd ".
							"AND m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
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
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
							"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
							"WHERE m_brg.kd_merk = m_merk.kd ".
							"AND m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
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
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
							"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
							"WHERE m_brg.kd_merk = m_merk.kd ".
							"AND m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
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

		//nek merk ==> c04
		else if ($katcari == "c04")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
							"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
							"WHERE m_brg.kd_merk = m_merk.kd ".
							"AND m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_merk.merk LIKE '%$kunci%' ".
							"ORDER BY m_brg.kode ASC";

			$sqlresult = $sqlcount;

			$count = mysql_num_rows(mysql_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?katcari=$katcari&kunci=$kunci";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysql_fetch_array($result);
			}

		//nek satuan ==> c05
		else if ($katcari == "c05")
			{
			$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
							"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
							"WHERE m_brg.kd_merk = m_merk.kd ".
							"AND m_brg.kd_kategori = m_kategori.kd ".
							"AND m_brg.kd_satuan = m_satuan.kd ".
							"AND stock.kd_brg = m_brg.kd ".
							"AND m_satuan.satuan LIKE '%$kunci%' ".
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
	}
else
	{
	//nek kode ==> c01
	if ($katcari == "c01")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
						"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
						"WHERE m_brg.kd_merk = m_merk.kd ".
						"AND m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
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
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
						"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
						"WHERE m_brg.kd_merk = m_merk.kd ".
						"AND m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
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
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
						"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
						"WHERE m_brg.kd_merk = m_merk.kd ".
						"AND m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
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

	//nek merk ==> c04
	else if ($katcari == "c04")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
						"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
						"WHERE m_brg.kd_merk = m_merk.kd ".
						"AND m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_merk.merk LIKE '%$kunci%' ".
						"ORDER BY m_brg.kode ASC";

		$sqlresult = $sqlcount;

		$count = mysql_num_rows(mysql_query($sqlcount));
		$pages = $p->findPages($count, $limit);
		$result = mysql_query("$sqlresult LIMIT ".$start.", ".$limit);
		$target = "$filenya?katcari=$katcari&kunci=$kunci";
		$pagelist = $p->pageList($_GET['page'], $pages, $target);
		$data = mysql_fetch_array($result);
		}

	//nek satuan ==> c05
	else if ($katcari == "c05")
		{
		$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, m_merk.*, m_kategori.*, m_satuan.*, stock.* ".
						"FROM m_brg, m_merk, m_kategori, m_satuan, stock ".
						"WHERE m_brg.kd_merk = m_merk.kd ".
						"AND m_brg.kd_kategori = m_kategori.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND m_satuan.satuan LIKE '%$kunci%' ".
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
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/js/down_enter.js");
require("../../inc/js/listmenu.js");
require("../../inc/menu/adm.php");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>';
xheadline($judul);
echo '</td>
</tr>
</table>

<table bgcolor="'.$warna02.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<select name="katcari" class="btn btn-info" '.$x_enter3.'>
<option value="" selected></option>
<option value="c01">Kode</option>
<option value="c02">Nama</option>
<option value="c03">Kategori</option>
<option value="c04">Merk</option>
<option value="c05">Satuan</option>
</select>

<input name="kunci" type="text" size="10" class="btn btn-info">
<input name="btnCRI" type="submit" value="CARI" class="btn btn-danger">
<input name="btnRST" type="submit" value="RESET" class="btn btn-warning">
</td>
</tr>
</table>';


//nek gak null cari
if ((!empty($katcari)) AND (!empty($kunci)))
	{
	echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
	<tr bgcolor="'.$warnaheader.'">
	<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
	<td width="200"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
	<td width="50"><strong><font color="'.$warnatext.'">Merk</font></strong></td>
	<td width="50" align="center"><strong><font color="'.$warnatext.'">Stock. Toko</font></strong></td>
	<td width="50" align="center"><strong><font color="'.$warnatext.'">Stock. Min</font></strong></td>
	<td width="50" align="center"><strong><font color="'.$warnatext.'">Harga Beli</font></strong></td>
	<td width="50" align="center"><strong><font color="'.$warnatext.'">Harga Jual</font></strong></td>
	</tr>';

	if ($count != 0)
		{
		do
			{
			$nomer = $nomer + 1;

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



			$kd = nosql($data['mbkd']);
			$kategori = balikin($data['kategori']);
			$satuan = balikin($data['satuan']);
			$kode = nosql($data['kode']);
			$nama = balikin($data['nama']);
			$merk = balikin($data['merk']);
			$jml_toko = nosql($data['jml_toko']);
			$jml_min = nosql($data['jml_min']);
			$jml_tot = $jml_toko;
			$hrg_beli = nosql($data['hrg_beli']);
			$hrg_jual = nosql($data['hrg_jual']);

			//jml. rusak ////////////////////////////////////////////////////////////
			$qjrus = mysql_query("SELECT SUM(jml) AS jrus FROM stock_rusak ".
									"WHERE kd_brg = '$kd'");
			$rjrus = mysql_fetch_assoc($qjrus);
			$jml_rusak = nosql($rjrus['jrus']);

			//nek null
			if (empty($jml_rusak))
				{
				$jml_rusak = "-";
				}


			//jml. hilang ////////////////////////////////////////////////////////////
			$qjhil = mysql_query("SELECT SUM(jml) AS jhil FROM stock_hilang ".
									"WHERE kd_brg = '$kd'");
			$rjhil = mysql_fetch_assoc($qjhil);
			$jml_hilang = nosql($rjhil['jhil']);

			//nek null
			if (empty($jml_hilang))
				{
				$jml_hilang = "-";
				}


			echo "<tr valign=\"top\" bgcolor=\"$warna\" onkeyup=\"this.bgColor='$warnaover';\" onkeydown=\"this.bgColor='$warna';\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td><input name="kd'.$nomer.'" type="hidden" value="'.$kd.'"> '.$kode.'</td>
			<td>'.$nama.'</td>
			<td>'.$kategori.'</td>
			<td>'.$satuan.'</td>
			<td>'.$merk.'</td>
			<td align="center">
			<input name="tk'.$nomer.'" type="text" style="text-align:right" class="btn btn-info" value="'.$jml_toko.'"
			onKeyPress="return numbersonly(this, event)"
			onKeyUp="document.formx.jtot'.$nomer.'.value=eval(document.formx.tk'.$nomer.'.value) + eval(document.formx.gd'.$nomer.'.value);"
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
			<input name="jmin'.$nomer.'" type="text" style="text-align:right" class="btn btn-info" value="'.$jml_min.'"
			onKeyPress="return numbersonly(this, event)"
			onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 38)
					{
					document.formx.jmin'.$nil.'.focus();
					}

				if (keyCode == 40)
					{
					document.formx.jmin'.$nild.'.focus();
					}

				if (keyCode == 39)
					{
					document.formx.hb'.$nomer.'.focus();
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
			<input name="hb'.$nomer.'" type="text" style="text-align:right" class="btn btn-info" value="'.$hrg_beli.'"
			onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 38)
					{
					document.formx.hb'.$nil.'.focus();
					}

				if (keyCode == 40)
					{
					document.formx.hb'.$nild.'.focus();
					}

				if (keyCode == 37)
					{
					document.formx.jmin'.$nomer.'.focus();
					}

				if (keyCode == 39)
					{
					document.formx.hj'.$nomer.'.focus();
					}

				if (keyCode == 13)
					{
					document.formx.btnSMP.focus();
					document.formx.btnSMP.submit();
					}
			"
			size="10">
			</td>
			<td align="center">
			<input name="hj'.$nomer.'" type="text" style="text-align:right" class="btn btn-info" value="'.$hrg_jual.'"
			onKeyDown="var keyCode = event.keyCode;
				if (keyCode == 38)
					{
					document.formx.hj'.$nil.'.focus();
					}

				if (keyCode == 40)
					{
					document.formx.hj'.$nild.'.focus();
					}

				if (keyCode == 37)
					{
					document.formx.hb'.$nomer.'.focus();
					}

				if (keyCode == 13)
					{
					document.formx.btnSMP.focus();
					document.formx.btnSMP.submit();
					}
			"
			size="10">
			</td>
	        </tr>';
			}
		while ($data = mysql_fetch_assoc($result));
		}


	echo '</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="263">
	<input name="page" type="hidden" value="'.$page.'">
	<input name="katcari" type="hidden" value="'.$katcari.'">
	<input name="kunci" type="hidden" value="'.$kunci.'">
	<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
	<input name="btnBTL" type="submit" value="BATAL" class="btn btn-warning">
	</td>
	<td align="right">
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