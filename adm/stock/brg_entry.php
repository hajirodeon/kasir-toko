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
$filenya = "brg_entry.php";
$judul = "Entry Stock Barang";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$brgkd = nosql($_REQUEST['brgkd']);
$katkd = nosql($_REQUEST['katkd']);
$merkkd = nosql($_REQUEST['merkkd']);
$kode = nosql($_REQUEST['kode']);


//nek null
if (empty($katkd))
	{
	$diload = "document.formx.kategori.focus();";
	}
else if (empty($merkkd))
	{
	$diload = "document.formx.merk.focus();";
	}
else if (empty($kode))
	{
	$diload = "document.formx.kode.focus();";
	}
else
	{
	$diload = "document.formx.nama.focus();";
	}




//nek null
if (empty($prs_tung))
	{
	$prs_tung = "0";
	}


$ke = $filenya;
$kecek = "$filenya?katkd=$katkd&merkkd=$merkkd&a=cek&kode=$kode";


//nek enter
$x_enter = 'onkeydown="return handleEnter(this, event)"';
$x_enter2 = 'onkeydown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnSMP.focus();
	document.formx.btnSMP.submit();
	}"';





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek batal
if ($_POST['btnBTL'])
	{
	xloc($ke);
	exit();
	}



//jika edit
if ($s == "edit")
	{
	$brgkd = nosql($_REQUEST['brgkd']);

	$qx = mysqli_query($koneksi, "SELECT m_brg.*, m_brg.kode AS mbkod, ".
						"m_brg.barkode AS mbbar, ".
						"m_brg.nama AS mbnm, stock.* ".
						"FROM m_brg, stock ".
						"WHERE stock.kd_brg = m_brg.kd ".
						"AND m_brg.kd = '$brgkd'");
	$rowx = mysqli_fetch_assoc($qx);

	$merkkd = nosql($rowx['kd_merk']);
	$katkd = nosql($rowx['kd_kategori']);
	$stkd = nosql($rowx['kd_satuan']);
	$kode = nosql($rowx['mbkod']);
	$barkode = nosql($rowx['mbbar']);
	$nama = balikin($rowx['mbnm']);
	$jml_toko = nosql($rowx['jml_toko']);
	$jml_min = nosql($rowx['jml_min']);
	$hrg_beli = nosql($rowx['hrg_beli']);
	$hrg_jual = nosql($rowx['hrg_jual']);
	$prs_tung = nosql($rowx['persen']);
	}





//jika simpan
if ($_POST['btnSMP'])
	{
	$s = nosql($_POST['s']);
	$brgkd = nosql($_POST['brgkd']);
	$katkd = nosql($_POST['katkd']);
	$merkkd = nosql($_POST['merkkd']);
	$kode = strtoupper(nosql($_POST['kode']));
	$barkode = nosql($_POST['barkode']);
	$nama = cegah2($_POST['nama']);
	$merkkd = nosql($_POST['merk']);
	$katkd = nosql($_POST['kategori']);
	$stkd = nosql($_POST['satuan']);
	$jml_toko = nosql($_POST['jml_toko']);
	$jml_min = nosql($_POST['jml_min']);
	$prs_tung = nosql($_POST['prs_tung']);
	$hrg_beli = nosql($_POST['hrg_beli']);
	$hrg_jual = nosql($_POST['hrg_jual']);

	//nek pembulatan
	$blt50 = substr($hrg_jual,-2,2);
	$blt50x = round($hrg_jual - $blt50);

	//50
	if (($blt50 >= 1) AND ($blt50 < 50))
		{
		$hrg_jual = $blt50x + 50;
		}

	//100
	else if (($blt50 > 50) AND ($blt50 < 100))
		{
		$hrg_jual = $blt50x + 100;
		}




	//jika baru
	if (empty($s))
		{
		//nek kode masih kosong
		if (empty($kode))
			{
			//null-kan
			xclose($koneksi);

			//re-direct
			$pesan = "Kode Barang Belum Dimasukkan. Harap Diulangi...!!";
			$ke = "$filenya?katkd=$katkd&merkkd=$merkkd";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			///cek kode
			$qcc = mysqli_query($koneksi, "SELECT * FROM m_brg ".
									"WHERE kode = '$kode'");
			$rcc = mysqli_fetch_assoc($qcc);
			$tcc = mysqli_num_rows($qcc);

			///cek barcode
			$qcc1 = mysqli_query($koneksi, "SELECT * FROM m_brg ".
									"WHERE barkode = '$barkode'");
			$rcc1 = mysqli_fetch_assoc($qcc1);
			$tcc1 = mysqli_num_rows($qcc1);
			$cc1_barkode = nosql($rcc1['barkode']);

			//nek ada
			if ($tcc != 0)
				{
				//null-kan
				xfree($qcc);
				xfree($qcc1);
				xclose($koneksi);

				//re-direct
				$pesan = "Kode Barang : $kode, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?katkd=$katkd&merkkd=$merkkd";
				pekem($pesan,$ke);
				exit();
				}
			else if (($tcc1 != 0) AND ($cc1_barkode != ''))
				{
				//null-kan
				xfree($qcc);
				xfree($qcc1);
				xclose($koneksi);

				//re-direct
				$pesan = "BarCode Barang : $barkode, Sudah Ada. Silahkan Ganti Yang Lain...!!";
				$ke = "$filenya?katkd=$katkd&merkkd=$merkkd";
				pekem($pesan,$ke);
				exit();
				}

			//jika telah isi
			else if (($a == "isi") OR (empty($a)))
				{
				//nek null
				if (empty($nama))
					{
					//null-kan
					xfree($qcc);
					xfree($qcc1);
					xclose($koneksi);

					//re-direct
					$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
					$ke = "$filenya?katkd=$katkd&merkkd=$merkkd&a=isi&kode=$kode";
					pekem($pesan,$ke);
					exit();
					}
				else
					{
					//ke m_brg
					mysqli_query($koneksi, "INSERT INTO m_brg(kd, kd_merk, kd_kategori, kd_satuan, kode, barkode, nama, postdate) VALUES ".
									"('$x', '$merkkd', '$katkd', '$stkd', '$kode', '$barkode', '$nama', '$today')");

					//ke stock
					$xi = md5($today3);

					mysqli_query($koneksi, "INSERT INTO stock(kd, kd_brg, jml_toko, jml_min, hrg_beli, hrg_jual, persen) VALUES ".
									"('$xi', '$x', '$jml_toko', '$jml_min', '$hrg_beli', '$hrg_jual', '$prs_tung')");

					//null-kan
					xfree($qcc);
					xfree($qcc1);
					xclose($koneksi);

					//re-direct
					$ke = "$filenya?katkd=$katkd&merkkd=$merkkd";
					xloc($ke);
					exit();
					}
				}
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();


//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/down_enter.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form method="post" name="formx">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td>';
xheadline($judul);
echo '</td>
</tr>
</table>

<table width="100%" bgcolor="'.$warna02.'" border="0" cellspacing="3" cellpadding="0">
<tr valign="top">
<td>
Kategori : <br>';
echo "<select name=\"kategori\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-info\">";

//terpilih
$qsupx = mysqli_query($koneksi, "SELECT * FROM m_kategori ".
						"WHERE kd = '$katkd'");
$rsupx = mysqli_fetch_assoc($qsupx);
$supx_kd = nosql($rsupx['kd']);
$supx_nm = balikin($rsupx['kategori']);

echo '<option value="'.$supx_kd.'" selected>'.$supx_nm.'</option>';

//query
$qsup = mysqli_query($koneksi, "SELECT * FROM m_kategori ".
						"WHERE kd <> '$katkd' ".
						"ORDER BY kategori ASC");
$rsup = mysqli_fetch_assoc($qsup);

do
	{
	$sup_kd = nosql($rsup['kd']);
	$sup_sing = balikin($rsup['kategori']);

	echo '<option value="'.$filenya.'?katkd='.$sup_kd.'">'.$sup_sing.'</option>';
	}
while ($rsup = mysqli_fetch_assoc($qsup));

echo '</select>
<br>

Merk :
<br>';

echo "<select name=\"merk\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn btn-info\">";

//terpilih
$qmerx = mysqli_query($koneksi, "SELECT * FROM m_merk ".
						"WHERE kd = '$merkkd'");
$rmerx = mysqli_fetch_assoc($qmerx);
$merx_kd = nosql($rmerx['kd']);
$merx_nm = balikin($rmerx['merk']);

echo '<option value="'.$merx_kd.'" selected>'.$merx_nm.'</option>';

//query
$qmer = mysqli_query($koneksi, "SELECT * FROM m_merk ".
						"WHERE kd <> '$merkd' ".
						"ORDER BY merk ASC");
$rmer = mysqli_fetch_assoc($qmer);

do
	{
	$mer_kd = nosql($rmer['kd']);
	$mer_sing = balikin($rmer['merk']);

	echo '<option value="'.$filenya.'?katkd='.$katkd.'&merkkd='.$mer_kd.'">'.$mer_sing.'</option>';
	}
while ($rmer = mysqli_fetch_assoc($qmer));

echo '</select>
<br>
Kode : <br>
<input name="kode" type="text" value="'.$kode.'" size="15" class="btn btn-info">

<p>
Nama :
<br>
<input name="nama" type="text" value="'.$nama.'" size="20"  class="btn btn-info" '.$x_enter.'>
</p>

<p>
Satuan : <br>
<select name="satuan" class="btn btn-info" '.$x_enter.'>';
//jika edit
if (empty($stkd))
	{
	echo '<option value="" selected></option>';
	}
else
	{
	$qstx = mysqli_query($koneksi, "SELECT * FROM m_satuan ".
							"WHERE kd = '$stkd'");
	$rstx = mysqli_fetch_assoc($qstx);
	$stx = balikin($rstx['satuan']);

	echo '<option value="'.$stkd.'" selected>'.$stx.'</option>';
	}

//satuan
$qst = mysqli_query($koneksi, "SELECT * FROM m_satuan ".
						"WHERE kd <> '$stkd' ".
						"ORDER BY satuan ASC");
$rst = mysqli_fetch_assoc($qst);

do
	{
	$stkd = nosql($rst['kd']);
	$st = nosql($rst['satuan']);

	echo '<option value="'.$stkd.'">'.$st.'</option>';
	}
while ($rst = mysqli_fetch_assoc($qst));


echo '</select>
</p>


<p>
Stock. Toko :
<br>
<input name="jml_toko" type="text" value="'.$jml_toko.'" size="5" style="text-align:right" class="btn btn-info" onkeypress="return numbersonly(this, event)" '.$x_enter.'>
</p>
</td>

<td>
Stock. Minimal :
<br>
<input name="jml_min" type="text" value="'.$jml_min.'" size="5" style="text-align:right" class="btn btn-info" onkeypress="return numbersonly(this, event)" '.$x_enter.'>
</p>

<p>
Harga Beli : <br>
<input name="hrg_beli" type="text" value="'.$hrg_beli.'" class="btn btn-info" size="10" style="text-align:right"
onKeyUp="if (document.formx.hrg_beli.value == \'\')
	{
	document.formx.hrg_jual.value = \'0\';
	}
else
	{
	k_kur1=Math.round(document.formx.hrg_beli.value * 100);
	k_kur2=Math.round(100 - document.formx.prs_tung.value);
	k_kur=Math.round(k_kur1 / k_kur2);
	document.formx.hrg_jual.value=eval(k_kur);
	}" '.$x_enter.'>
</p>


<p>
Persen Keuntungan : <br>
<input name="prs_tung" type="text" value="'.$prs_tung.'" size="5" maxlength="5" class="btn btn-info" style="text-align:right"
onKeyUp="if (document.formx.hrg_beli.value == \'\')
	{
	document.formx.hrg_jual.value = \'0\';
	}
else
	{
	k_kur1=Math.round(document.formx.hrg_beli.value * 100);
	k_kur2=Math.round(100 - document.formx.prs_tung.value);
	k_kur=Math.round(k_kur1 / k_kur2);
	document.formx.hrg_jual.value=eval(k_kur);
	}" '.$x_enter.'>%
</p>

<p>
Harga Jual : <br>
<input name="hrg_jual" type="text" value="'.$hrg_jual.'" size="10" class="btn btn-info" style="text-align:right" onKeyPress="return numbersonly(this, event)" '.$x_enter.'>
</p>

<p>
BarCode :
<br>
<input name="barkode" type="text" value="'.$barkode.'" size="20" class="btn btn-info" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
</p>

<input name="s" type="hidden" value="'.$s.'">
<input name="a" type="hidden" value="'.$a.'">
<input name="brgkd" type="hidden" value="'.$brgkd.'">
<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
<input name="btnBTL" type="submit" value="BATAL" class="btn btn-warning">
<input name="btnKLR" type="submit" value="TUTUP" class="btn btn-primary" onClick="parent.entry_window.onClose();parent.entry_window.hide();">
</td>
</tr>
</table>




<br>
<br>
<br>';


//data ne...
//query
$p = new Pager();
$start = $p->findStart($limit);

$sqlcount = "SELECT m_brg.*, m_brg.kd AS mbkd, stock.* ".
						"FROM m_brg, stock ".
						"WHERE stock.kd_brg = m_brg.kd ".
						"AND m_brg.kd_kategori = '$katkd' ".
						"AND m_brg.kd_merk = '$merkkd' ".
						"ORDER BY m_brg.kode DESC";


$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$target = "$filenya?katcari=$katcari&kunci=$kunci";
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);




echo '<table width="100%" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
<td width="200"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Merk</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
<td width="50" align="center"><strong><font color="'.$warnatext.'">Stock. Toko</font></strong></td>
<td width="50" align="center"><strong><font color="'.$warnatext.'">Stock. Min.</font></strong></td>
<td width="75" align="center"><strong><font color="'.$warnatext.'">Hrg. Beli</font></strong></td>
<td width="75" align="center"><strong><font color="'.$warnatext.'">Hrg. Jual</font></strong></td>
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


		$brgkd = nosql($data['mbkd']);

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
		$kode = nosql($data['kode']);
		$nama = balikin($data['nama']);
		$jml_toko = nosql($data['jml_toko']);
		$jml_min = nosql($data['jml_min']);
		$jml_total = $jml_toko;
		$hrg_beli = nosql($data['hrg_beli']);
		$hrg_jual = nosql($data['hrg_jual']);


		if (empty($jml_toko))
			{
			$jml_toko = "-";
			}

		if (empty($jml_min))
			{
			$jml_min = "-";
			}

		if (empty($jml_total))
			{
			$jml_total = "-";
			}

		if (empty($hrg_beli))
			{
			$hrg_beli = "-";
			}

		if (empty($hrg_jual))
			{
			$hrg_jual = "-";
			}






		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>'.$kode.'</td>
		<td>'.$nama.'</td>
		<td>'.$merk.'</td>
		<td>'.$kategori.'</td>
		<td>'.$satuan.'</td>
		<td align="right">'.$jml_toko.'</td>
		<td align="right">'.$jml_min.'</td>
		<td align="right">'.$hrg_beli.'</td>
		<td align="right">'.$hrg_jual.'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td width="300">
<input name="jml" type="hidden" value="'.$limit.'">
<input name="katkd" type="hidden" value="'.$katkd.'">
<input name="merkkd" type="hidden" value="'.$merkkd.'">
<input name="s" type="hidden" value="'.$s.'">
<input name="brgkd" type="hidden" value="'.$brgkd.'">
</td>
<td align="right"><strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
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