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




//KONEKSI ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$koneksi = mysqli_connect($xhostname, $xusername, $xpassword, $xdatabase);


// Check connection
if (mysqli_connect_errno()) {
  echo "Koneksi ERROR: " . mysqli_connect_error();
  exit();
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>