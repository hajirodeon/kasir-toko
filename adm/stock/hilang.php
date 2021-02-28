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
$gdkd = nosql($_REQUEST['gdkd']);
$katkd = nosql($_REQUEST['katkd']);
$filenya = "rusak.php";
$judul = "Stock Hilang";
$judulku = "[$admin_session : $username1_session] ==> $judul";
$judulx = $judul;
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

$ke = "$filenya?page=$page";


$diload = "document.formx.kode.focus();";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//jika tambah
if ($_POST['btnTBH'])
	{
	//nilai
	$kode = nosql($_POST['kode']);
	$jml = nosql($_POST['jml']);


	//null
	if ((empty($kode)) OR (empty($jml)))
		{
		//null-kan
		xfree($qbw);
		xclose($koneksi);

		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//bgkd...
		$qbg = mysqli_query($koneksi, "SELECT * FROM m_brg ".
								"WHERE kode = '$kode'");
		$rbg = mysqli_fetch_assoc($qbg);
		$tbg = mysqli_num_rows($qbg);
		$bgkd = nosql($rbg['kd']);

		//nek ada
		if ($tbg != 0)
			{

			//update stock toko
			mysqli_query($koneksi, "UPDATE stock ".
							"SET jml_toko = jml_toko - '$jml' ".
							"WHERE kd_brg = '$bgkd'");

			//query
			mysqli_query($koneksi, "INSERT INTO stock_hilang(kd, kd_brg, jml, postdate) VALUES ".
							"('$x', '$bgkd', '$jml', '$today')");

			//null-kan
			xfree($qbw);
			xfree($qbg);
			xclose($koneksi);

			//re-direct
			xloc($ke);
			exit();
			}
		else //nek gak ada
			{
			//null-kan
			xfree($qbw);
			xfree($qbg);
			xclose($koneksi);

			//re-direct
			$pesan = "Kode Barang : $kode, Tidak Ada. Harap Diulangi...!!";
			pekem($pesan,$ke);
			exit();
			}
		}
	}


//jika hapus
if ($_POST['btnHPS'])
	{
	//nilai
	$page = nosql($_POST['page']);

	if ((empty($page)) OR ($page == "0"))
		{
		$page = "1";
		}


	for($ongko=1;$ongko<=$limit;$ongko++)
		{
		$yuk = "item";
		$yuhu = "$yuk$ongko";
		$kd = nosql($_POST["$yuhu"]);

		mysqli_query($koneksi, "DELETE FROM stock_hilang ".
						"WHERE kd = '$kd'");
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

$sqlcount = "SELECT m_brg.*, m_kategori.*, m_satuan.*, stock_hilang.*, ".
				"stock_hilang.kd AS srkd ".
				"FROM m_brg, m_kategori, m_satuan, stock_hilang ".
				"WHERE stock_hilang.kd_brg = m_brg.kd ".
				"AND m_brg.kd_kategori = m_kategori.kd ".
				"AND m_brg.kd_satuan = m_satuan.kd ".
				"ORDER BY m_brg.kode ASC";
$sqlresult = $sqlcount;

$count = mysqli_num_rows(mysqli_query($sqlcount));
$pages = $p->findPages($count, $limit);
$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
$pagelist = $p->pageList($_GET['page'], $pages, $target);
$data = mysqli_fetch_array($result);


echo '
<script type="text/javascript" src="'.$sumber.'/inc/js/dhtmlwindow_adm.js"></script>
<script type="text/javascript" src="'.$sumber.'/inc/js/modal.js"></script>
<script type="text/javascript">

function open_brg()
	{
	brg_window=dhtmlmodal.open(\'Barang\',
	\'iframe\',
	\'popup_brg.php\',
	\'Barang\',
	\'width=700px,height=325px,center=1,resize=0,scrolling=0\')

	brg_window.onclose=function()
		{
		var kodex=this.contentDoc.getElementById("kodex");

		document.formx.kode.value=kodex.value;
		document.formx.kode.focus();
		return true
		}
	}
</script>';



//require
require("../../inc/js/jumpmenu.js");
require("../../inc/js/down_enter.js");
require("../../inc/js/swap.js");
require("../../inc/js/checkall.js");
require("../../inc/js/number.js");
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
<p>
Kode :
<input name="kode" type="text" value="" size="10" class="btn btn-info" tabindex="1"
onKeyPress="return handleEnter(this, event)"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 45)
	{
	open_brg();
	return false
	}
">,

Jumlah :
<input name="jml" type="text" size="3" class="btn btn-info" tabindex="2"
onKeyPress="return numbersonly(this, event)"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnTBH.focus();
	document.formx.btnTBH.submit();
	}
">
<input name="btnTBH" type="submit" class="btn btn-danger" value="SIMPAN>>>" tabindex="3">

[INSERT : Pilih Kode Barang].

</p>
</td>
</tr>
</table>
<br>

<table width="800" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="1%">&nbsp;</td>
<td width="50"><strong><font color="'.$warnatext.'">Kode</font></strong></td>
<td width="275"><strong><font color="'.$warnatext.'">Nama</font></strong></td>
<td width="100"><strong><font color="'.$warnatext.'">Kategori</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Satuan</font></strong></td>
<td width="50"><strong><font color="'.$warnatext.'">Jumlah</font></strong></td>
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
		$kd = nosql($data['srkd']);
		$kode = nosql($data['kode']);
		$nama = balikin($data['nama']);
		$kategori = balikin($data['kategori']);
		$satuan = balikin($data['satuan']);
		$jml = nosql($data['jml']);
		$gudang = balikin($data['gudang']);
		$postdate = $data['postdate'];


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
		echo '<td><input type="checkbox" name="item'.$nomer.'" value="'.$kd.'"> </td>
		<td>'.$kode.'</td>
		<td>'.$nama.'</td>
		<td>'.$kategori.'</td>
		<td>'.$satuan.'</td>
		<td>'.$jml.'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</table>
<table width="800" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'

<input name="page" type="hidden" value="'.$page.'">
<input name="btnALL" type="button" value="SEMUA" onClick="checkAll('.$limit.')" class="btn btn-info">
<input name="btnBTL" type="reset" value="BATAL" class="btn btn-warning">
<input name="btnHPS" type="submit" value="HAPUS" class="btn btn-danger">
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