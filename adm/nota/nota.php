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
$tpl = LoadTpl("../../template/index.html");


nocache;

//nilai
$judulku = "Pembuat Nota";
$filenya = "nota.php";
$ikd = nosql($_REQUEST['ikd']);
$ikod = nosql($_REQUEST['ikod']);
$inm = balikin($_REQUEST['inm']);
$istn = nosql($_REQUEST['istn']);
$ihrg = nosql($_REQUEST['ihrg']);
$ijml = nosql($_REQUEST['ijml']);
$notakd = nosql($_REQUEST['notakd']);
$s = nosql($_REQUEST['s']);
$set = nosql($_REQUEST['set']);
$ke = "$filenya?notakd=$notakd";


//default jumlah
if ($ikod != "")
	{
	$ijml = "1";
	}


//today
$xtgl1 = nosql($tanggal);
$xbln1 = nosql($bulan);
$xthn1 = nosql($tahun);



//atrribut
if (empty($notakd))
	{
	$attribut = "disabled";
	}


//keydown.
//tombol "CTRL"=17, utk. nota baru
//tombol "HOME"=36, utk. pilih nota
//tombol "END"=35, utk. save & print
//tombol "ESC"=27, utk. keluar
$dikeydown = "var keyCode = event.keyCode;
				if (keyCode == 17)
					{
					var nyakin = window.confirm('Yakin Akan Memulai Nota Baru...?');

					if (nyakin)
						{
						location.href='$filenya?set=pending&notakd=$notakd';
						}
					else
						{
						return false
						}
					}

				if (keyCode == 35)
					{
					if (document.formx.notakdx.value == '')
						{
						alert('Gagal Melakukan Printing. Nota Masih Kosong, atau Nota Belum Dipilih. ');
						}
					else
						{
						location.href='nota_bayar.php?s=print&notakd=$notakd';
						}
					}

				if (keyCode == 36)
					{
					open_pilih();
					return false
					}

				if (keyCode == 27)
					{
					parent.ks_window.hide();
					}";





//set pending ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($set == "pending") //dari pembuatan nota baru (tidak melalui re-direct printing)
	{
	//nilai
	$notakd = nosql($_REQUEST['notakd']);

	//query
	mysql_query("UPDATE nota SET pending = 'true' ".
					"WHERE kd = '$notakd'");

	//null-kan
	xclose($koneksi);

	//re-direct
	$ke = "$filenya";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//nota baru /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "baru")
	{
	//nilai
	$notakd = nosql($_REQUEST['notakd']);
	$pelangganx = cegah($_REQUEST['pelanggan']);

	//today
	$wagu2 = $today3;
	$no_nota = $wagu2;

	//cek
	$qcc = mysql_query("SELECT * FROM nota ".
							"WHERE no_nota = '$no_nota'");
	$rcc = mysql_fetch_assoc($qcc);
	$tcc = mysql_num_rows($qcc);

	//nek iya
	if ($tcc != 0)
		{
		//today
		$wagu2 = $today3;

		//no nota
		$no_notax = $wagu2;

		//insert-kan...
		mysql_query("INSERT INTO nota(kd, pelanggan, tgl, no_nota, postdate) VALUES ".
						"('$notakd', '$pelangganx', '$today', '$no_notax', '$today')");
		}
	else
		{
		//insert-kan...
		mysql_query("INSERT INTO nota(kd, pelanggan, tgl, no_nota, postdate) VALUES ".
						"('$notakd', '$pelangganx', '$today', '$no_nota', '$today')");
		}

	//null-kan
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?notakd=$notakd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//nota edit /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($s == "editp")
	{
	//nilai
	$notakd = nosql($_REQUEST['notakd']);
	$pelangganx = cegah($_REQUEST['pelanggan']);

	//update
	mysql_query("UPDATE nota SET pelanggan = '$pelangganx' ".
					"WHERE kd = '$notakd'");

	//null-kan
	xclose($koneksi);

	//re-direct
	$ke = "$filenya?notakd=$notakd";
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//proses input baru /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//kode
if ($_POST['kode0'])
	{
	//nilai
	$kodeu = nosql($_POST['kodex']);
	$notakd = nosql($_POST['notakdx']);
	$jmlx = nosql($_POST['jmlx']);
	$hrgx = nosql($_POST['hrgx']);
	$stotx = $jmlx * $hrgx;
	$ke = "$filenya?notakd=$notakd";


	//cek, barkode-kah...? lebih dari 10 angka, BARCODE ////////////////////////////////////////////////////////////////////////////////
	if ((strlen($kodeu) > 10) AND (is_numeric($kodeu)))
		{
		//cek input
		$qcr = mysql_query("SELECT * FROM m_brg ".
								"WHERE barkode = '$kodeu'");
		$rcr = mysql_fetch_assoc($qcr);
		$tcr = mysql_num_rows($qcr);
		$kodex = nosql($rcr['kode']);
		$brgkd = nosql($rcr['kd']);
		}
	else
		{
		//cek input
		$qcr = mysql_query("SELECT * FROM m_brg ".
								"WHERE kode = '$kodeu'");
		$rcr = mysql_fetch_assoc($qcr);
		$tcr = mysql_num_rows($qcr);
		$kodex = nosql($rcr['kode']);
		$brgkd = nosql($rcr['kd']);
		}


	//nek kode barang tidak ada. atau salah
	if ($tcr == 0)
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Tidak ada Barang dengan Kode/Barcode : $kodex. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//deteksi, jika sudah ada
		$qcc = mysql_query("SELECT * FROM nota_detail ".
								"WHERE kd_nota = '$notakd' ".
								"AND kd_brg = '$brgkd'");
		$rcc = mysql_fetch_assoc($qcc);
		$tcc = mysql_num_rows($qcc);
		$cc_qty = nosql($rcc['qty']);
		$qty_all = $cc_qty + 1;

		if ($tcc != 0) //jika iya
			{
			//jika sudah ada, update jumlah
			//deteksi, (jmlx + qty) > dari stock
			$qcc1 = mysql_query("SELECT * FROM stock ".
									"WHERE kd_brg = '$brgkd'");
			$rcc1 = mysql_fetch_assoc($qcc1);
			$jml_cc1 = nosql($rcc1['jml_toko']);
			$jml_min = nosql($rcc1['jml_min']);

			//nek (jmlx + qty) lebih...
			if ($qty_all >= $jml_cc1)
				{
				//null-kan
				xclose($koneksi);

				//re-direct
				$pesan = "Jumlah Item Melebihi Jumlah Stock Yang Ada. Harap Dipehatikan...!!";
				pekem($pesan,$ke);
				exit();
				}
			else
				{
				//kurangi stock toko
				//deteksi
				$qdtx = mysql_query("SELECT * FROM stock ".
										"WHERE kd_brg = '$brgkd'");
				$rdtx = mysql_fetch_assoc($qdtx);
				$dtx_toko = nosql($rdtx['jml_toko']);
				$dtx_hrg = nosql($rdtx['hrg_jual']);
				$dtx_stotx = $dtx_hrg * $qty_all;

				//nek mencukupi
				if ($dtx_toko > $qty_all)
					{
					$s_toko = $qty_all;

					mysql_query("UPDATE stock ".
									"SET jml_toko = jml_toko - '$s_toko' ".
									"WHERE kd_brg = '$brgkd'");
					}
				else if ($dtx_toko < $qty_all)
					{
					$s_toko =  $qty_all; //sisa utk toko

					//update toko
					mysql_query("UPDATE stock ".
									"SET jml_toko = jml_toko - '$s_toko' ".
									"WHERE kd_brg = '$brgkd'");

					}

				//ke detail....
				//update
				mysql_query("UPDATE nota_detail SET qty = '$qty_all', ".
								"subtotal = '$dtx_stotx', ".
								"postdate = '$today' ".
								"WHERE kd_nota = '$notakd' ".
								"AND kd_brg = '$brgkd'");

				//null-kan
				xclose($koneksi);

				//re-direct
				xloc($ke);
				exit();
				}
			}
		else //jika tidak
			{
			//jika jumlah di-input
			if (empty($jmlx))
				{
				//nama item
				$qnm = mysql_query("SELECT m_brg.*, m_satuan.*, stock.* ".
										"FROM m_brg, m_satuan, stock ".
										"WHERE m_brg.kd = stock.kd_brg ".
										"AND m_brg.kd_satuan = m_satuan.kd ".
										"AND m_brg.kd = '$brgkd'");
				$rnm = mysql_fetch_assoc($qnm);
				$inm = urlencode(cegah($rnm['nama']));
				$istn = nosql($rnm['satuan']);
				$ihrg = nosql($rnm['hrg_jual']);

				//null-kan
				xclose($koneksi);

				//re-direct
				$ke = "$filenya?notakd=$notakd&ikod=$kodex&inm=$inm&istn=$istn&ihrg=$ihrg";
				xloc($ke);
				exit();
				}
			else
				{
				//deteksi, jmlx > dari stock
				$qcc1 = mysql_query("SELECT * FROM stock ".
										"WHERE kd_brg = '$brgkd'");
				$rcc1 = mysql_fetch_assoc($qcc1);
				$jml_cc1 = nosql($rcc1['jml_toko']);
				$jml_min = nosql($rcc1['jml_min']);

				//nek jmlx lebih...
				if ($jmlx >= $jml_cc1)
					{
					//null-kan
					xclose($koneksi);

					//re-direct
					$pesan = "Jumlah Item Melebihi Jumlah Stock Yang Ada. Harap Dipehatikan...!!";
					pekem($pesan,$ke);
					exit();
					}
				else
					{
					//kurangi stock toko
					//deteksi
					$qdtx = mysql_query("SELECT * FROM stock ".
											"WHERE kd_brg = '$brgkd'");
					$rdtx = mysql_fetch_assoc($qdtx);
					$dtx_toko = nosql($rdtx['jml_toko']);

					//nek mencukupi
					if ($dtx_toko > $jmlx)
						{
						$s_toko =  $jmlx;

						mysql_query("UPDATE stock ".
										"SET jml_toko = jml_toko - '$s_toko' ".
										"WHERE kd_brg = '$brgkd'");
						}
					else if ($dtx_toko < $jmlx)
						{
						$s_toko =  $jmlx; //sisa utk toko

						//update toko
						mysql_query("UPDATE stock ".
										"SET jml_toko = jml_toko - '$s_toko' ".
										"WHERE kd_brg = '$brgkd'");
						}

					//ke detail....
					//insert
					mysql_query("INSERT INTO nota_detail(kd, kd_nota, kd_brg, qty, subtotal, postdate) VALUES ".
									"('$x', '$notakd', '$brgkd', '$jmlx', '$stotx', '$today')");

					//null-kan
					xclose($koneksi);

					//re-direct
					xloc($ke);
					exit();
					}
				}
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//proses hapus //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (($_POST['s'] == "hapus")
	AND ($_POST['kdx']))
	{
	//nilai
	$kdx = nosql($_POST['kdx']);
	$notakd = nosql($_POST['notakdx']);
	$ke = "$filenya?notakd=$notakd";



	//deteksi
	$qcc = mysql_query("SELECT * FROM nota_detail ".
							"WHERE kd_nota = '$notakd' ".
							"AND kd = '$kdx'");
	$rcc = mysql_fetch_assoc($qcc);
	$kd_brg = nosql($rcc['kd_brg']);
	$qty_toko = nosql($rcc['qty']);

	//update stock kembali...
	mysql_query("UPDATE stock ".
					"SET jml_toko = jml_toko + '$qty_toko' ".
					"WHERE kd_brg = '$kd_brg'");

	//update
	mysql_query("DELETE FROM nota_detail ".
					"WHERE kd_nota = '$notakd' ".
					"AND kd = '$kdx'");

	//null-kan
	xclose($koneksi);

	//re-direct
	xloc($ke);
	exit();
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//proses edit ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (($_POST['s'] == "edit")
	AND ($_POST['kdx'])
	AND ($_POST['kodex'])
	AND ($_POST['jmlx']))
	{
	//nilai
	$kdx = nosql($_POST['kdx']);
	$notakd = nosql($_POST['notakdx']);
	$kodeu = nosql($_POST['kodex']);
	$jmlx = nosql($_POST['jmlx']);
	$hrgx = nosql($_POST['hrgx']);
	$stotx = nosql($_POST['stotx']);
	$ke = "$filenya?notakd=$notakd";


	//cek, barkode-kah...? lebih dari 10 angka, BARCODE ////////////////////////////////////////////////////////////////////////////////
	if ((strlen($kodeu) > 10) AND (is_numeric($kodeu)))
		{
		//cek input
		$qcr = mysql_query("SELECT * FROM m_brg ".
								"WHERE barkode = '$kodeu'");
		$rcr = mysql_fetch_assoc($qcr);
		$tcr = mysql_num_rows($qcr);
		$kodex = nosql($rcr['kode']);
		$brgkd = nosql($rcr['kd']);
		}
	else
		{
		//cek input
		$qcr = mysql_query("SELECT * FROM m_brg ".
								"WHERE kode = '$kodeu'");
		$rcr = mysql_fetch_assoc($qcr);
		$tcr = mysql_num_rows($qcr);
		$kodex = nosql($rcr['kode']);
		$brgkd = nosql($rcr['kd']);
		}



	//nek kode barang tidak ada. atau salah
	if ($tcr == 0)
		{
		//null-kan
		xclose($koneksi);

		//re-direct
		$pesan = "Tidak ada Barang dengan Kode/Barcode : $kodex. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//netralkan dahulu .......................................................................
		//deteksi
		$qcc = mysql_query("SELECT * FROM nota_detail ".
								"WHERE kd_nota = '$notakd' ".
								"AND kd = '$kdx'");
		$rcc = mysql_fetch_assoc($qcc);
		$qty_toko = nosql($rcc['qty']);

		//update stock kembali...
		mysql_query("UPDATE stock ".
						"SET jml_toko = jml_toko + '$qty_toko' ".
						"WHERE kd_brg = '$brgkd'");


		//lakukan sekarang .......................................................................
		//deteksi, jmlx > dari stock
		$qcc1 = mysql_query("SELECT * FROM stock ".
								"WHERE kd_brg = '$brgkd'");
		$rcc1 = mysql_fetch_assoc($qcc1);
		$jml_cc1 = nosql($rcc1['jml_toko']);
		$jml_min = nosql($rcc1['jml_min']);

		//nek jmlx lebih...
		if ($jmlx >= $jml_cc1)
			{
			//null-kan
			xclose($koneksi);

			//re-direct
			$pesan = "Jumlah Item Melebihi Jumlah Stock Yang Ada. Harap Dipehatikan...!!";
			pekem($pesan,$ke);
			exit();
			}
		else
			{
			//kurangi stock toko
			//deteksi
			$qdtx = mysql_query("SELECT * FROM stock ".
									"WHERE kd_brg = '$brgkd'");
			$rdtx = mysql_fetch_assoc($qdtx);
			$dtx_toko = nosql($rdtx['jml_toko']);

			//nek mencukupi
			if ($dtx_toko > $jmlx)
				{
				$s_toko =  $jmlx;

				mysql_query("UPDATE stock ".
								"SET jml_toko = jml_toko - '$s_toko' ".
								"WHERE kd_brg = '$brgkd'");
				}
			else if ($dtx_toko < $jmlx)
				{
				$s_toko =  $jmlx; //sisa utk toko

				//update toko
				mysql_query("UPDATE stock ".
								"SET jml_toko = jml_toko - '$s_toko' ".
								"WHERE kd_brg = '$brgkd'");
				}

			//update detail
			mysql_query("UPDATE nota_detail SET kd_brg = '$brgkd', ".
							"qty = '$jmlx', ".
							"subtotal = '$stotx' ".
							"WHERE kd_nota = '$notakd' ".
							"AND kd = '$kdx'");

			//null-kan
			xclose($koneksi);

			//re-direct
			xloc($ke);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





//focus /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika blm ada nota, bikin aja...
if (empty($notakd))
	{
	$diload = "isodatetime();document.formx.pelanggan.focus();";
	}
else
	{
	//subtotal-nya...
	$qstu = mysql_query("SELECT SUM(subtotal) AS subtotal ".
							"FROM nota_detail ".
							"WHERE kd_nota = '$notakd'");
	$rstu = mysql_fetch_assoc($qstu);
	$stu_subtotal = nosql($rstu['subtotal']);


	//nek tanpa ikod
	if (empty($ikod))
		{
		$diload = "isodatetime();document.formx.kode0.focus();document.formx.stotx.value='$stu_subtotal';";
		}
	else
		{
		$diload = "isodatetime();document.formx.jml0.focus();document.formx.stotx.value='$stu_subtotal';";
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();


echo '<script type="text/javascript" src="'.$sumber.'/inc/js/dhtmlwindow_admks.js"></script>
<script type="text/javascript" src="'.$sumber.'/inc/js/modal.js"></script>
<script type="text/javascript">

function open_brg()
	{
	brg_window=dhtmlmodal.open(\'Daftar Stock\',
	\'iframe\',
	\'nota_brg.php\',
	\'Daftar Stock\',
	\'width=750px,height=325px,center=1,resize=0,scrolling=0\')

	brg_window.onclose=function()
		{
		var kodex=this.contentDoc.getElementById("kodex");

		document.formx.kode0.value=kodex.value;
		document.formx.kode0.focus();
		return true
		}
	}

function open_pilih()
	{
	pilih_window=dhtmlmodal.open(\'Daftar Nota\',
	\'iframe\',
	\'nota_pilih.php?xtgl1='.$xtgl1.'&xbln1='.$xbln1.'&xthn1='.$xthn1.'\',
	\'Daftar Nota\',
	\'width=930px,height=320px,center=1,resize=0,scrolling=0\')

	pilih_window.onclose=function()
		{
		var kdx=this.contentDoc.getElementById("kdx");

		location.href=\''.$filenya.'?notakd=+kdx.value\';
		kdx2 = kdx.value;
		redir = \''.$filenya.'?notakd=\'+kdx2;
		location.href=redir;

		return true
		}
	}
</script>';

//js
require("../../inc/js/jam.js");
require("../../inc/js/number.js");
require("../../inc/menu/adm.php");

//echo '<form name="formx" method="post">';
echo '<h1>
KASIR
</h1>
<form name="formx" action="'.$ke.'" method="post">';


//nota-nya
$qntt = mysql_query("SELECT * FROM nota ".
						"WHERE kd = '$notakd'");
$rntt = mysql_fetch_assoc($qntt);
$ntt_nota = nosql($rntt['no_nota']);
$ntt_pel = balikin($rntt['pelanggan']);


//total-nya
$qtuh = mysql_query("SELECT SUM(subtotal) AS total ".
						"FROM nota_detail ".
						"WHERE kd_nota = '$notakd'");
$rtuh = mysql_fetch_assoc($qtuh);
$tuh_total = nosql($rtuh['total']);

//nek null
if (empty($tuh_total))
	{
	$tuh_total = "0";
	}



echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top">

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td class="kasir1">No. Nota </td>
<td class="kasir1">:
<input name="nota" type="text" value="'.$ntt_nota.'" size="20" class="xinput" readonly>
</td>
</tr>
<tr>
<td class="kasir1">Tanggal </td>
<td class="kasir1">:
<input name="xtglx" type="text" value="'.$tanggal.' '.$arrbln1[$bulan].' '.$tahun.'" size="20" class="xinput" readonly>
</td>
</tr>
<tr>
<td class="kasir1">Pelanggan </td>
<td class="kasir1">:
<input name="pelanggan" type="text" value="'.$ntt_pel.'" size="20" class="xinput1"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	if (document.formx.notakdx.value == \'\')
		{
		pelgx = document.formx.pelanggan.value;
		redir = \''.$filenya.'?s=baru&notakd='.$x.'&pelanggan=\'+pelgx;
		location.href=redir;
		}
	else
		{
		pelgx = document.formx.pelanggan.value;
		redir = \''.$filenya.'?s=editp&notakd='.$notakd.'&pelanggan=\'+pelgx;
		location.href=redir;
		}
	}">
</td>
</tr>
</table>


</td>
<td valign="top" align="right">
<input name="layar" type="text" size="30" value="'.$tuh_total.'" class="layar" style="text-align:right;width:200;height:70" readonly>
<br>
</td>
</tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
[<strong>CTRL</strong> : Nota Baru].
[<strong>HOME</strong> : Pilih Nota].
[<strong>INSERT</strong> : Cari Item].
[<strong>DEL</strong> : Hapus Item].
[<strong>END</strong> : Print].
</td>
<td>
<input type="text" name="display_jam" size="10" style="border:0;font-size:27;text-align:right">
</td>
</tr>
</table>

<table width="700" border="1" cellpadding="3" cellspacing="0">
<tr>
<td><strong>Kode</strong></td>
<td><strong>Nama Barang</strong></td>
<td><strong>Satuan</strong></td>
<td align="center"><strong>Harga</strong></td>
<td align="center"><strong>Jumlah</strong></td>
<td align="center"><strong>SubTotal</strong></td>
</tr>
<tr>
<td>
<input name="kode0" type="text" size="7" value="'.$ikod.'" maxlength="15" class="xinput1"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.kodex.value = document.formx.kode0.value;
	document.formx.submit();
	}

if (keyCode == 38)
	{
	document.formx.kode'.$tcob.'.focus();
	}

if (keyCode == 40)
	{
	document.formx.kode1.focus();
	}

if (keyCode == 45)
	{
	open_brg();
	return false
	}

if (keyCode == 46)
	{
	alert(\'Pilih Dahulu Item Yang Akan Dihapus...!!\');
	location.href=\''.$ke.'\';
	}
" '.$attribut.'>
</td>
<td>
<input name="nm0" type="text" size="25" value="'.$inm.'" class="xinput" readonly>
</td>
<td>
<input name="stn0" type="text" size="5" value="'.$istn.'" class="xinput" readonly>
</td>
<td>
<input name="hrg0" type="text" size="10" value="'.$ihrg.'" class="xinput" style="text-align:right" readonly>
</td>
<td>
<input name="jml0" type="text" size="5" value="'.$ijml.'" class="xinput1" style="text-align:right"
onKeyPress="return numbersonly(this, event)"
onKeyUp="document.formx.subtotal.value=Math.round(document.formx.jml0.value * document.formx.hrgx.value);
document.formx.stotx.value=document.formx.subtotal.value;
document.formx.layar.value=document.formx.subtotal.value;"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.jmlx.value = document.formx.jml0.value;
	document.formx.submit();
	}

if (keyCode == 46)
	{
	location.href=\''.$ke.'\';
	}
" '.$attribut.'>
</td>
<td>
<input name="subtotal" type="text" size="12" value="" class="xinput" style="text-align:right" readonly>
</td>
</tr>';

//data ne
$qcob = mysql_query("SELECT nota_detail.*, nota_detail.kd AS tckd, ".
						"nota_detail.qty AS tcjml, ".
						"m_brg.*, m_satuan.*, stock.* ".
						"FROM nota_detail, m_brg, m_satuan, stock ".
						"WHERE nota_detail.kd_brg = m_brg.kd ".
						"AND m_brg.kd_satuan = m_satuan.kd ".
						"AND stock.kd_brg = m_brg.kd ".
						"AND nota_detail.kd_nota = '$notakd' ".
						"ORDER BY m_brg.postdate ASC");
$rcob = mysql_fetch_assoc($qcob);
$tcob = mysql_num_rows($qcob);

//nek gak null
if ($tcob != 0)
	{
	do
		{
		$nomerx = $nomerx + 1;

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

		//pageup ////////////////////////
		$nil = $nomerx - 1;

		if ($nil < 1)
			{
			$nil = 0;
			}

		if ($nil > $tcob)
			{
			$nil = $tcob;
			}


		//pagedown ////////////////////////
		$nild = $nomerx + 1;

		if ($nild < 1)
			{
			$nild = $nild + 1;
			}

		if ($nild > $tcob)
			{
			$nild = 0;
			}

		$cob_kd = nosql($rcob['tckd']);
		$cob_kode = nosql($rcob['kode']);
		$cob_jml = nosql($rcob['tcjml']);
		$cob_nm = balikin($rcob['nama']);
		$cob_satuan = nosql($rcob['satuan']);
		$cob_hrg = nosql($rcob['hrg_jual']);


		echo "<tr valign=\"top\" bgcolor=\"$warna\"
		onkeyup=\"this.bgColor='$warnaover';\"
		onkeydown=\"this.bgColor='$warna';\"
		onmouseover=\"this.bgColor='$warnaover';\"
		onmouseout=\"this.bgColor='$warna';\">";
		echo '<td>
		<input name="kd'.$nomerx.'" type="hidden" value="'.$cob_kd.'">
		<input name="kode'.$nomerx.'" type="text" value="'.$cob_kode.'" size="7" maxlength="15" class="xinput1"
		onKeyDown="var keyCode = event.keyCode;
		if (keyCode == 13)
			{
			document.formx.jml'.$nomerx.'.focus();
			}

		if (keyCode == 38)
			{
			document.formx.kode'.$nil.'.focus();
			}

		if (keyCode == 40)
			{
			document.formx.kode'.$nild.'.focus();
			}

		if (keyCode == 46)
			{
			document.formx.s.value = \'hapus\';
			document.formx.kdx.value = document.formx.kd'.$nomerx.'.value;
			document.formx.submit();
			}">
		</td>
		<td>
		<input name="nm'.$nomerx.'" type="text" value="'.$cob_nm.'" size="25" class="xinput" readonly>
		</td>
		<td>
		<input name="stn'.$nomerx.'" type="text" value="'.$cob_satuan.'" size="5" class="xinput" readonly>
		</td>
		<td>
		<input name="hrg'.$nomerx.'" type="text" value="'.$cob_hrg.'" size="10" class="xinput" style="text-align:right" readonly>
		</td>
		<td>
		<input name="jml'.$nomerx.'" type="text" value="'.$cob_jml.'" size="5" class="xinput1" style="text-align:right"
		onKeyPress="return numbersonly(this, event)"
		onKeyUp="document.formx.stot'.$nomerx.'.value=Math.round(document.formx.hrg'.$nomerx.'.value * document.formx.jml'.$nomerx.'.value);
		document.formx.layar.value=document.formx.stot'.$nomerx.'.value;"
		onKeyDown="var keyCode = event.keyCode;
		if (keyCode == 13)
			{
			document.formx.s.value = \'edit\';
			document.formx.kdx.value = document.formx.kd'.$nomerx.'.value;
			document.formx.kodex.value = document.formx.kode'.$nomerx.'.value;
			document.formx.jmlx.value = document.formx.jml'.$nomerx.'.value;
			document.formx.stotx.value = document.formx.stot'.$nomerx.'.value;
			document.formx.submit();
			}

		if (keyCode == 46)
			{
			document.formx.s.value = \'hapus\';
			document.formx.kdx.value = document.formx.kd'.$nomerx.'.value;
			document.formx.submit();
			}">
		</td>
		<td>
		<input name="stot'.$nomerx.'" type="text" value="'.round($cob_hrg * $cob_jml).'" size="12" class="xinput" style="text-align:right" readonly>
		</td>
		</tr>';
		}
	while ($rcob = mysql_fetch_assoc($qcob));
	}

echo '</table>
<input name="s" type="hidden" value="">
<input name="kdx" type="hidden" value="'.$ikd.'">
<input name="kodex" type="hidden" value="'.$ikod.'">
<input name="hrgx" type="hidden" value="'.$ihrg.'">
<input name="jmlx" type="hidden" value="'.$ijml.'">
<input name="notakdx" type="hidden" value="'.$notakd.'">
<input name="stotx" type="hidden" value="'.$stu_subtotal.'">
</form>';

//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");

//null-kan
xclose($koneksi);
exit();
?>