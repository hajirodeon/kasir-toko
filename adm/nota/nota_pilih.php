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
$judul = "Daftar Nota";
$judulku = $judul;
$xtgl1 = nosql($_REQUEST['xtgl1']);
$xbln1 = nosql($_REQUEST['xbln1']);
$xthn1 = nosql($_REQUEST['xthn1']);
$filenya = "nota_pilih.php";
$ke = "$filenya?xtgl1=$xtgl1&xbln1=$xbln1&xthn1=$xthn1";
$page = nosql($_REQUEST['page']);
if ((empty($page)) OR ($page == "0"))
	{
	$page = "1";
	}

//nek cari, enter
$x_enter = 'onKeyDown="var keyCode = event.keyCode;
if (keyCode == 13)
	{
	document.formx.btnCRI.focus();
	document.formx.btnCRI.submit();
	}"';


//keydown.
//tombol "ESC"=27, utk. keluar
$dikeydown = "var keyCode = event.keyCode;
				if (keyCode == 27)
					{
					parent.pilih_window.hide();
					}";




//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nek reset
if ($_POST['btnRST'])
	{
	//nilai
	xloc($ke);
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
		//nek no. nota ==> c01
		if ($katcari == "c01")
			{
			$sqlcount = "SELECT * FROM nota ".
							"WHERE round(DATE_FORMAT(tgl, '%d')) = '$xtgl1' ".
							"AND round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
							"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
							"AND no_nota LIKE '%$kunci%' ".
							"AND pending = 'false' ".
							"ORDER BY no_nota DESC";

			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?xtgl1=$xtgl1&xbln1=$xbln1&xthn1=$xthn1";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}

		//nek pelanggan ==> c02
		if ($katcari == "c02")
			{
			$sqlcount = "SELECT * FROM nota ".
							"WHERE round(DATE_FORMAT(tgl, '%d')) = '$xtgl1' ".
							"AND round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
							"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
							"AND pelanggan LIKE '%$kunci%' ".
							"AND pending = 'false' ".
							"ORDER BY pelanggan DESC";

			$sqlresult = $sqlcount;

			$count = mysqli_num_rows(mysqli_query($sqlcount));
			$pages = $p->findPages($count, $limit);
			$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
			$target = "$filenya?xtgl1=$xtgl1&xbln1=$xbln1&xthn1=$xthn1";
			$pagelist = $p->pageList($_GET['page'], $pages, $target);
			$data = mysqli_fetch_array($result);
			}
		}
	} ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
else
	{
	$sqlcount = "SELECT * FROM nota ".
					"WHERE round(DATE_FORMAT(tgl, '%d')) = '$xtgl1' ".
					"AND round(DATE_FORMAT(tgl, '%m')) = '$xbln1' ".
					"AND round(DATE_FORMAT(tgl, '%Y')) = '$xthn1' ".
					"AND pending = 'false' ".
					"ORDER BY postdate DESC";

	$sqlresult = $sqlcount;

	$count = mysqli_num_rows(mysqli_query($sqlcount));
	$pages = $p->findPages($count, $limit);
	$result = mysqli_query($koneksi, "$sqlresult LIMIT ".$start.", ".$limit);
	$target = "$filenya?xtgl1=$xtgl1&xbln1=$xbln1&xthn1=$xthn1";
	$pagelist = $p->pageList($_GET['page'], $pages, $target);
	$data = mysqli_fetch_array($result);
	}



//require
require("../../inc/js/swap.js");
require("../../inc/js/jumpmenu.js");
xheadline($judul);

//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="900" border="0" cellspacing="0" cellpadding="0">
<tr valign="top">
<td>';
echo "<select name=\"xtgl1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn-info\">";
echo '<option value="'.$xtgl1.'" selected>'.$xtgl1.'</option>';

for ($i=1;$i<=31;$i++)
	{
	echo '<option value="'.$filenya.'?xtgl1='.$i.'">'.$i.'</option>';
	}

echo '</select>';

echo "<select name=\"xbln1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn-info\">";
echo '<option value="'.$xbln1.'" selected>'.$arrbln[round($xbln1)].'</option>';

for ($j=1;$j<=12;$j++)
	{
	echo '<option value="'.$filenya.'?xtgl1='.$xtgl1.'&xbln1='.$j.'">'.$arrbln[$j].'</option>';
	}

echo '</select>';

echo "<select name=\"xthn1\" onChange=\"MM_jumpMenu('self',this,0)\" class=\"btn-info\">";
echo '<option value="'.$xthn1.'" selected>'.$xthn1.'</option>';

//query
$qthn = mysqli_query($koneksi, "SELECT * FROM m_tahun ".
						"ORDER BY tahun DESC");
$rthn = mysqli_fetch_assoc($qthn);

do
	{
	$x_thn = nosql($rthn['tahun']);
	echo '<option value="'.$filenya.'?xtgl1='.$xtgl1.'&xbln1='.$xbln1.'&xthn1='.$x_thn.'">'.$x_thn.'</option>';
	}
while ($rthn = mysqli_fetch_assoc($qthn));

echo '</select>
</td>

<td align="right">
<select name="katcari" class="btn-info">
<option value="" selected></option>
<option value="c01">No. Nota</option>
<option value="c02">Pelanggan</option>
</select>
<input name="kunci" type="text" size="10" '.$x_enter.'>
<input name="btnCRI" type="submit" value="CARI" class="btn-danger">
<input name="btnRST" type="submit" value="RESET" class="btn-warning">
</td>
</tr>
</table>


<table width="900" border="1" cellspacing="0" cellpadding="3">
<tr bgcolor="'.$warnaheader.'">
<td width="150"><strong><font color="'.$warnatext.'">Jam</font></strong></td>
<td width="150"><strong><font color="'.$warnatext.'">No. Nota</font></strong></td>
<td width="250"><strong><font color="'.$warnatext.'">Pelanggan</font></strong></td>
<td width="100" align="center"><strong><font color="'.$warnatext.'">Jml. Jenis Barang</font></strong></td>
<td width="100" align="center"><strong><font color="'.$warnatext.'">Jml. Item</font></strong></td>
<td width="150" align="center"><strong><font color="'.$warnatext.'">SubTotal</font></strong></td>
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
		$x_kd = nosql($data['kd']);
		$x_jam = $data['postdate'];
		$x_no_nota = nosql($data['no_nota']);
		$x_pelanggan = balikin($data['pelanggan']);

		//nek null
		if (empty($x_pelanggan))
			{
			$x_pelanggan = "-";
			}


		//jml. jenis barang ////////////////////////////////////////////////////////
		$qtem = mysqli_query($koneksi, "SELECT nota_detail.*, m_brg.*  ".
								"FROM nota_detail, m_brg ".
								"WHERE nota_detail.kd_brg = m_brg.kd ".
								"AND nota_detail.kd_nota = '$x_kd'");
		$rtem = mysqli_fetch_assoc($qtem);
		$ttem = mysqli_num_rows($qtem);


		//nek null
		if ($ttem == 0)
			{
			$ttem = "-";
			}



		//jml. item ////////////////////////////////////////////////////////
		$qtem1 = mysqli_query($koneksi, "SELECT SUM(qty) AS jml ".
								"FROM nota_detail ".
								"WHERE kd_nota = '$x_kd'");
		$rtem1 = mysqli_fetch_assoc($qtem1);
		$tem_jml = nosql($rtem1['jml']);

		//nek null
		if (empty($tem_jml))
			{
			$tem_jml = "-";
			}


		//jml. subtotal //////////////////////////////////////////////////////////////
		$qstot = mysqli_query($koneksi, "SELECT SUM(subtotal) AS subtotal FROM nota_detail ".
								"WHERE kd_nota = '$x_kd'");
		$rstot = mysqli_fetch_assoc($qstot);
		$stot_subtotal = nosql($rstot['subtotal']);

		//nek null
		if (empty($stot_subtotal))
			{
			$stot_subtotalx = "-";
			}
		else
			{
			$stot_subtotalx = xduit2($stot_subtotal);
			}


		echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\"
		onClick=\"document.formx.kdx.value='$x_kd';
		parent.pilih_window.hide();
		\">";
		echo '<td>'.$x_jam.'</td>
		<td>'.$x_no_nota.'</td>
		<td>'.$x_pelanggan.'</td>
		<td align="right">'.$ttem.'</td>
		<td align="right">'.$tem_jml.'</td>
		<td align="right">'.$stot_subtotalx.'</td>
        </tr>';
		}
	while ($data = mysqli_fetch_assoc($result));
	}


echo '</table>
<table width="900" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
<input id="kdx" name="kdx" type="hidden" value="" size="50">
</td>
<td align="right">
<strong><font color="#FF0000">'.$count.'</font></strong> Data. '.$pagelist.'
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