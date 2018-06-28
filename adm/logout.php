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

//ambil nilai
require("../inc/config.php");
require("../inc/fungsi.php");

nocache;

session_unset($hajirobe1_session);
session_unset($kd1_session);
session_unset($admin_session);
session_unset($username1_session);
session_unset($pass1_session);
session_unset();
session_destroy();

//re-direct
xloc($sumber);
exit();
?>