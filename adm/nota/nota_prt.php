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

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
$tpl = LoadTpl("../../template/window.html");


nocache;

//nilai
$judulku = "Nota";
$notakd = nosql($_REQUEST['notakd']);


//deteksi pending
$qcvu = mysqli_query($koneksi, "SELECT * FROM nota ".
						"WHERE pending = 'true' ".
						"ORDER BY postdate DESC");
$rcvu = mysqli_fetch_assoc($qcvu);
$tcvu = mysqli_num_rows($qcvu);
$cvu_notakd = nosql($rcvu['kd']);

if ($tcvu != 0)
	{
	//print re-direct nota pending
	$diload = "window.print();location.href='nota.php?notakd=$cvu_notakd';";
	}
else
	{
	//print re-direct
	$diload = "window.print();location.href='nota.php';";
	}




//isi *START
ob_start();


//query
$q = mysqli_query($koneksi, "SELECT * FROM nota ".
					"WHERE kd = '$notakd'");
$r = mysqli_fetch_assoc($q);
$total = mysqli_num_rows($q);
$no_nota = nosql($r['no_nota']);
$tot_total = nosql($r['total']);
$tot_bayar = nosql($r['total_bayar']);
$tot_kembali = nosql($r['total_kembali']);


//header
echo '<table width="200" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td align="center">
<big><strong>'.$nama_toko.'</strong></big>
<br>
'.$alamat_toko.'
</td>
</tr>
</table>';

//tgl & no nota
echo '<table width="200" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td>
<hr>
'.$no_nota.'
<br>
<hr>
</td>
</tr>
</table>';

//kolom header
echo '<table width="200" border="0" cellspacing="0" cellpadding="3">';


//row kolom data
$qx = mysqli_query($koneksi, "SELECT nota_detail.*, nota_detail.qty AS kdqty, ".
					"nota_detail.subtotal AS kdsub, ".
					"m_brg.*, m_brg.kode AS mbkod, ".
					"m_brg.nama AS mbnm, stock.*, m_satuan.* ".
					"FROM nota_detail, m_brg, stock, m_satuan ".
					"WHERE nota_detail.kd_brg = m_brg.kd ".
					"AND stock.kd_brg = m_brg.kd ".
					"AND m_brg.kd_satuan = m_satuan.kd ".
					"AND nota_detail.kd_nota = '$notakd' ".
					"ORDER BY m_brg.kode ASC");
$rqx = mysqli_fetch_assoc($qx);

do
	{
	$nomer = $nomer + 1;
	$mbkod = nosql($rqx['mbkod']);
	$mbnm = balikin($rqx['mbnm']);

	//nek akeh...
	if (strlen($mbnm) > 15)
		{
		$mbnm1 = substr(balikin($rqx['mbnm']),0,15);
		$mbnmx = "$mbnm1...";
		}
	else
		{
		$mbnmx = $mbnm;
		}

	$kdqty = nosql($rqx['kdqty']);
	$satuan = balikin($rqx['satuan']);
	$x_qty = "$kdqty $satuan";
	$kdsub = nosql($rqx['kdsub']);
	$hrg_jual = nosql($rqx['hrg_jual']);

	echo '<tr>
	<td>
	'.$mbnm.'...
	<br>
	'.$x_qty.' * '.$hrg_jual.'
	<br>
	<strong>'.xduit2($kdsub).'</strong>
	</td>
	</tr>';
	}
while ($rqx = mysqli_fetch_assoc($qx));

echo '</table>';

//total
echo '<table width="200" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="100">
<hr>
<strong>Total : </strong>
<br>
'.xduit2($tot_total).'
<br><br>
<strong>Charge : </strong>
<br>
'.xduit2($tot_bayar).'
<br><br>
<strong>Change : </strong>
<br>
'.xduit2($tot_kembali).'
</td>
</tr>
</table>';


//petugas
echo '<table width="200" border="0" cellspacing="0" cellpadding="3">
<tr valign="top">
<td width="100">
<hr>
'.$today.'
<hr>
</td>
</tr>
</table>';



//isi
$isi = ob_get_contents();
ob_end_clean();

require("../../inc/niltpl.php");


//null-kan
xclose($koneksi);
exit();
?>