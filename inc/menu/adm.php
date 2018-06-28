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


//nilai
$maine = "$sumber/adm/index.php";


//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<UL class="menulist" id="listMenuRoot">
<table bgcolor="#E4D6CC" width="100%" border="0" cellspacing="0" cellpadding="5">
<tr>
<td>';





//home //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<LI>
<a href="'.$maine.'" title="BERANDA"><strong>BERANDA</strong></a>
</LI>';





//setting ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<LI>
<A href="#"><strong>SETTING</strong>&nbsp;&nbsp;</A>
	<UL>
	<LI>
	<a href="'.$sumber.'/adm/s/pass.php" title="Ganti Password">Ganti Password</a>
	</LI>
	</UL>
</LI>';



echo '<LI>
<A href="#"><strong>DATA</strong>&nbsp;&nbsp;</A>
<UL>
	<LI>
	<a href="'.$sumber.'/adm/d/kategori.php" title="Data Kategori">Data Kategori</a>
	</LI>
	
	<LI>
	<a href="'.$sumber.'/adm/d/merk.php" title="Data Merk">Data Merk</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/d/satuan.php" title="Data Satuan">Data Satuan</a>
	</LI>
</UL>
	


<LI>
<A href="#"><strong>STOCK</strong>&nbsp;&nbsp;</A>
<UL>
	<LI>
	<a href="'.$sumber.'/adm/stock/brg.php" title="Data Barang">Data Barang</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/stock/barcode.php" title="Data Print Barcode">Data Print Barcode</a>
	</LI>


	<LI>
	<a href="'.$sumber.'/adm/stock/opname.php" title="Stock Opname">Stock Opname</a>
	</LI>
	
	<LI>
	<a href="'.$sumber.'/adm/stock/rusak.php" title="Set Stock Rusak">Set Stock Rusak</a>
	</LI>
	
	<LI>
	<a href="'.$sumber.'/adm/stock/hilang.php" title="Set Stock Hilang">Set Stock Hilang</a>
	</LI>
	
	<LI>
	<a href="'.$sumber.'/adm/stock/iron.php" title="Iron Stock">Iron Stock</a>
	</LI>
	
</UL>




<LI>
<A href="'.$sumber.'/adm/nota/nota.php" ><strong>KASIR</strong>&nbsp;&nbsp;</A>
</LI>




<LI>
<A href="#"><strong>LAPORAN</strong>&nbsp;&nbsp;</A>
<UL>
	<LI>
	<a href="'.$sumber.'/adm/lap/lap_item_laris.php" title="Laporan Terlaris">Laporan Terlaris</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/lap/lap_brg.php" title="Laporan Daftar Barang">Laporan Daftar Barang</a>
	</LI>

	<LI>
	<a href="'.$sumber.'/adm/lap/lap_nota.php" title="Laporan per Nota">Laporan per Nota</a>
	</LI>
	

	<LI>
	<a href="'.$sumber.'/adm/lap/lap_history_nota.php" title="Laporan History Nota">Laporan History Nota</a>
	</LI>
	

	<LI>
	<a href="'.$sumber.'/adm/lap/lap_brg_keluar.php" title="Laporan Barang Keluar">Laporan Barang Keluar</a>
	</LI>
	
</UL>

</li>


	
</td>
<td width="10%" align="right">
<LI>
<A href="'.$sumber.'/logout.php" title="Logout / KELUAR"><strong>LogOut</strong></A>
</LI>
</td>
</tr>
</table>

</UL>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>