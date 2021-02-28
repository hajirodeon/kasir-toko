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
$tpl = LoadTpl("../../template/window.html");

nocache;

//nilai
$filenya = "brg_entry_edit.php";
$judul = "Edit Stock Barang";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$a = nosql($_REQUEST['a']);
$brgkd = nosql($_REQUEST['brgkd']);
$kode = nosql($_REQUEST['kode']);

//nek null
if (empty($kode))
	{
	$diload = "document.formx.kode.focus();";
	}
else
	{
	$diload = "document.formx.kategori.focus();";
	}



//nek null
if (empty($prs_tung))
	{
	$prs_tung = "0";
	}

$ke = $filenya;
$kecek = "$filenya?a=cek&kode=$kode";


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




	//jika update
	if ($s == "edit")
		{
		//nek null
		if ((empty($kode)) OR (empty($nama)))
			{
			//null-kan
			xclose($koneksi);

			//re-direct
			$pesan = "Input Tidak Lengkap. Harap Diulangi...!";
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

			//nek duplikasi, lebih dari 1
			if ($tcc > 1)
				{
				//null-kan
				xfree($qcc);
				xfree($qcc1);
				xclose($koneksi);

				//re-direct
				$pesan = "Ditemukan Duplikasi Kode : $kode. Harap Segera Diperhatikan...!!";
				pekem($pesan,$filenya);
				exit();
				}
			else if (($tcc1 > 1) AND ($cc1_barkode != ''))
				{
				//null-kan
				xfree($qcc);
				xfree($qcc1);
				xclose($koneksi);

				//re-direct
				$pesan = "Ditemukan Duplikasi BarCode : $barkode. Harap Segera Diperhatikan...!!";
				pekem($pesan,$filenya);
				exit();
				}
			else
				{
				//update m_brg
				mysqli_query($koneksi, "UPDATE m_brg SET kd_merk = '$merkkd', ".
								"kd_kategori = '$katkd', ".
								"kd_satuan = '$stkd', ".
								"kode = '$kode', ".
								"barkode = '$barkode', ".
								"nama = '$nama' ".
								"WHERE kd = '$brgkd'");

				//update stock
				mysqli_query($koneksi, "UPDATE stock SET jml_toko = '$jml_toko', ".
								"jml_min = '$jml_min', ".
								"hrg_beli = '$hrg_beli', ".
								"hrg_jual = '$hrg_jual', ".
								"persen = '$prs_tung' ".
								"WHERE kd_brg = '$brgkd'");


				//null-kan
				xfree($qcc);
				xfree($qcc1);
				xclose($koneksi);


				//re-direct --> close
				echo "<script>
				parent.edit_window.onClose();
				parent.edit_window.hide();
				</script>";
				}
			}
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
			pekem($pesan,$filenya);
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
				pekem($pesan,$filenya);
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
				pekem($pesan,$filenya);
				exit();
				}

			//jika telah isi
			else if ($a == "isi")
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
					$ke = "$filenya?a=isi&kode=$kode";
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

					mysqli_query($koneksi, "INSERT aINTO stock(kd, kd_brg, jml_toko, jml_min, hrg_beli, hrg_jual, persen) VALUES ".
									"('$xi', '$x', '$jml_toko', '$jml_min', '$hrg_beli', '$hrg_jual', '$prs_tung')");

					//null-kan
					xfree($qcc);
					xfree($qcc1);
					xclose($koneksi);

					//re-direct
					xloc($ke);
					exit();
					}
				}
			else
				{
				//null-kan
				xfree($qcc);
				xfree($qcc1);
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?a=isi&kode=$kode";
				xloc($ke);
				exit();
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
<p>
Kategori : <br>
<select name="kategori" class="btn btn-info" '.$x_enter.'>';

//jika edit
if (empty($katkd))
	{
	echo '<option value="" selected></option>';
	}
else
	{
	$qke = mysqli_query($koneksi, "SELECT * FROM m_kategori ".
							"WHERE kd = '$katkd'");
	$rke = mysqli_fetch_assoc($qke);
	$kategori = balikin($rke['kategori']);

	echo '<option value="'.$katkd.'" selected>'.$kategori.'</option>';
	}


//kategori
$qkat = mysqli_query($koneksi, "SELECT * FROM m_kategori ".
						"WHERE kd <> '$katkd' ".
						"ORDER BY kategori ASC");
$rkat = mysqli_fetch_assoc($qkat);

do
	{
	$katkdx = nosql($rkat['kd']);
	$kat = balikin($rkat['kategori']);

	echo '<option value="'.$katkdx.'">'.$kat.'</option>';
	}
while ($rkat = mysqli_fetch_assoc($qkat));

echo '</select>

</p>

<p>
Merk :
<br>
<select name="merk" class="btn btn-info" '.$x_enter.'>';
//jika edit
if (empty($merkkd))
	{
	echo '<option value="" selected></option>';
	}
else
	{
	$qmex = mysqli_query($koneksi, "SELECT * FROM m_merk ".
							"WHERE kd = '$merkkd'");
	$rmex = mysqli_fetch_assoc($qmex);
	$mex = balikin($rmex['merk']);

	echo '<option value="'.$merkkd.'" selected>'.$mex.'</option>';
	}

//merk
$qme = mysqli_query($koneksi, "SELECT * FROM m_merk ".
						"WHERE kd <> '$merkkd' ".
						"ORDER BY merk ASC");
$rme = mysqli_fetch_assoc($qme);

do
	{
	$merkkd = nosql($rme['kd']);
	$me = balikin($rme['merk']);

	echo '<option value="'.$merkkd.'">'.$me.'</option>';
	}
while ($rme = mysqli_fetch_assoc($qme));


echo '</select>
</p>

<p>
Kode : <br>
<input name="kode" type="text" value="'.$kode.'" size="15" maxlength="15" class="btn btn-info" '.$x_enter3.'>
</p>

<p>
Nama :
<br>
<input name="nama" type="text" value="'.$nama.'" size="20" class="btn btn-info" '.$x_enter.'>
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
<input name="jml_toko" type="text" value="'.$jml_toko.'" size="5" class="btn btn-info" style="text-align:right" onkeypress="return numbersonly(this, event)" '.$x_enter.'>
</p>
</td>

<td>
<p>
Stock. Minimal :
<br>
<input name="jml_min" type="text" value="'.$jml_min.'" size="5" class="btn btn-info" style="text-align:right" onkeypress="return numbersonly(this, event)" '.$x_enter.'>
</p>

<p>
Harga Beli : <br>
<input name="hrg_beli" type="text" value="'.$hrg_beli.'" size="10" class="btn btn-info" style="text-align:right"
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
<input name="barkode" type="text" value="'.$barkode.'" size="20" onKeyPress="return numbersonly(this, event)" '.$x_enter2.'>
</p>

<p>
<input name="s" type="hidden" value="'.$s.'">
<input name="a" type="hidden" value="'.$a.'">
<input name="brgkd" type="hidden" value="'.$brgkd.'">
<input name="btnSMP" type="submit" value="SIMPAN" class="btn btn-danger">
<input name="btnBTL" type="submit" value="BATAL" class="btn btn-warning">
<input name="btnKLR" type="submit" value="TUTUP" class="btn btn-primary" onClick="parent.edit_window.onClose();parent.edit_window.hide();">
</p>
</td>
</tr>
</table>
</form>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");

//null-kan
xclose($koneksi);
exit();
?>