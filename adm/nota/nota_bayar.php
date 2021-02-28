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
$tpl = LoadTpl("../../template/window2.html");

nocache;

//nilai
$judul = "Pembayaran";
$judulku = $judul;
$notakd = nosql($_REQUEST['notakd']);
$filenya = "nota_bayar.php";
$ke = "$filenya?notakd=$notakd";
$diload = "document.formx.bayar.focus();";





//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//nilai
	$notakd = nosql($_POST['notakd']);
	$total = nosql($_POST['total']);
	$bayar = nosql($_POST['bayar']);
	$kembalian = nosql($_POST['kembalian']);

	//cek
	if ($bayar < $total)
		{
		//pesan
		$pesan = "Pembayaran Masih Kurang. Harap Diperhatikan...!!";
		pekem($pesan,$ke);
		exit();
		}
	else
		{
		//simpan
		mysqli_query($koneksi, "UPDATE nota SET total_bayar = '$bayar', ".
						"total_kembali = '$kembalian' ".
						"WHERE kd = '$notakd'");

		//lari ke print...
		$ke1 = "nota_prt.php?notakd=$notakd";
		xloc($ke1);
		exit();
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




//isi *START
ob_start();




//require
require("../../inc/js/swap.js");
require("../../inc/js/number.js");


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ketahui total e...
$qtote = mysqli_query($koneksi, "SELECT SUM(subtotal) AS total FROM nota_detail ".
						"WHERE kd_nota = '$notakd'");
$rtote = mysqli_fetch_assoc($qtote);
$tote_totalx = nosql($rtote['total']);

//simpan nota & detail
mysqli_query($koneksi, "UPDATE nota SET total = '$tote_totalx', ".
				"pending = 'false' ".
				"WHERE kd = '$notakd'");

//total e.
$qnot = mysqli_query($koneksi, "SELECT * FROM nota ".
						"WHERE kd = '$notakd'");
$rnot = mysqli_fetch_assoc($qnot);
$not_total = $tote_totalx;
$not_bayar = nosql($rnot['total_bayar']);
$not_kembalian = nosql($rnot['total_kembali']);



echo '<form method="post" name="formx">
<table width="100" border="1" cellspacing="0" cellpadding="3">
<tr align="center">
<td>';
xheadline($judul);
echo '<br>

<p>
Total :
<br>
<input name="total" type="text" value="'.$not_total.'" size="15" class="btn-warning">
</p>
<br>
<p>
Bayar / Charge :
<br>
<input name="bayar" type="text" value="'.$not_bayar.'" size="15"
onKeyPress="return numbersonly(this, event)"
onKeyUp="document.formx.kembalian.value=eval(document.formx.bayar.value - document.formx.total.value);"
onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnOK.focus();
	document.formx.btnOK.submit();
	}"
class="btn-info">
</p>

<p>
<br>
Kembalian / Change :
<br>
<input name="kembalian" type="text" value="'.$not_kembalian.'" size="15" class="btn-info" readonly>
</p>
<br>
<br>

<p>
<input name="notakd" type="hidden" value="'.$notakd.'">
<input name="btnOK" type="submit" value="OK" class="btn-danger">
<input name="btnBTL" type="submit" value="BATAL" class="btn-warning">
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