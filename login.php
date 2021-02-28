<?php
//ambil nilai
require("inc/config.php");
require("inc/fungsi.php");
require("inc/koneksi.php");
$tpl = LoadTpl("template/login_adm.html");


nocache;

//nilai
$filenya = "login.php";
$judul = $nama_toko;



//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($_POST['btnOK'])
	{
	//ambil nilai
	$username = nosql($_POST["usernamex"]);
	$password = md5(nosql($_POST["passwordx"]));

	//cek
	if ((empty($username)) OR (empty($password)))
		{
		//re-direct
		$pesan = "Input Tidak Lengkap. Harap Diulangi...!!";
		pekem($pesan,$filenya);
		exit();
		}
	else
		{
		//admin
		$q = mysqli_query($koneksi, "SELECT * FROM admin ".
							"WHERE username = '$username' ".
							"AND password = '$password'");
		$row = mysqli_fetch_assoc($q);
		$total = mysqli_num_rows($q);

		//cek login
		if ($total != 0)
			{
			session_start();

			//nilai - nilai
			$_SESSION['kd1_session'] = nosql($row['kd']);
			$_SESSION['username1_session'] = $username;
			$_SESSION['pass1_session'] = $password;
			$_SESSION['time1_session'] = $today;
			$_SESSION['admin_session'] = "PENGELOLA";
			$_SESSION['hajirobe1_session'] = $hajirobe;

			//time login
			mysqli_query($koneksi, "UPDATE admin SET time_login = '$today' ".
							"WHERE username = '$username' ".
							"AND password = '$password'");


			//re-direct
			$ke = "adm/index.php";
			xloc($ke);
			exit();
			}
		else
			{
			//null-kan
			xfree($q);
			xclose($koneksi);

			//re-direct
			$pesan = "PASSWORD SALAH. HARAP DIULANGI...!!!";
			pekem($pesan, $filenya);
			exit();
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//isi *START
ob_start();




//view //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
echo '<form action="'.$filenya.'" method="post" name="formx">
<table width="990" bgcolor="'.$warnaover.'" border="0" cellspacing="5" cellpadding="0">
<tr valign="top">
<td valign="top">
<h1>
'.$nama_toko.'
</h1>
<em>
'.$alamat_toko.', '.$nama_kota.'
</em>


<p>
Username :
<br>
<input name="usernamex" type="text" size="20" class="btn btn-info">
</p>

<p>
Password :
<br>
<input name="passwordx" type="password" size="20" class="btn btn-info">
</p>

<p>
<input name="btnOK" type="submit" value="LANJUT >>" class="btn btn-danger">
</p>
</td>

</tr>
</table>

<table width="990" bgcolor="'.$warna02.'" border="0" cellspacing="5" cellpadding="0">
<tr valign="top">
<td>
&copy;2018. <strong>{versi}</strong>
</td>
</tr>
</table>


  
</form>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//isi
$isi = ob_get_contents();
ob_end_clean();

require("inc/niltpl.php");


//diskonek
xclose($koneksi);
exit();
?>