<?php
// ALL CONTENT
if ($_GET['page']=='home'){
	include 'home.php';
}elseif($_GET['page']=='profil'){
	include 'profil.php';
}elseif($_GET['page']=='cpass'){
	include 'cpass.php';
// ALL CONTENT

// ADMIN CONTENT & MASTER
}elseif($_GET['page']=='user'){
	include 'mod/user/user.php';
}elseif($_GET['page']=='mkat'){
	include 'mod/master/kategori.php';
}elseif($_GET['page']=='mruang'){
	include 'mod/master/seting.php';
}elseif($_GET['page']=='seting'){
	include 'mod/master/ruangan.php';
}elseif($_GET['page']=='mmerek'){
	include 'mod/master/merek.php';
}elseif($_GET['page']=='mtipe'){
	include 'mod/master/tipe.php';
}elseif($_GET['page']=='mpegawai'){
	include 'mod/master/pegawai.php';
}elseif($_GET['page']=='mkdkab'){
	include 'mod/master/mkdkab.php';
}elseif($_GET['page']=='inv'){
	include 'mod/inventaris/inventaris.php';
}elseif($_GET['page']=='minv'){
	include 'mod/inventaris/minventaris.php';
}elseif($_GET['page']=='mkendi'){
	include 'mod/inventaris/mkendi.php';
}elseif($_GET['page']=='dinv'){
	include 'mod/inventaris/dinventaris.php';
}elseif($_GET['page']=='dkendi'){
	include 'mod/inventaris/dkendi.php';
}elseif($_GET['page']=='pinv'){
	include 'mod/penempatan/pinventaris.php';
}elseif($_GET['page']=='pdinv'){
	include 'mod/penempatan/pdinventaris.php';
}elseif($_GET['page']=='pinjam'){
	include 'mod/penempatan/ppinjam.php';
}elseif($_GET['page']=='repair'){
	include 'mod/perbaikan/perbaikan.php';
}elseif($_GET['page']=='rac'){
	include 'mod/perbaikan/rac.php';
}elseif($_GET['page']=='rkendi'){
	include 'mod/perbaikan/rkendi.php';
}elseif($_GET['page']=='dayajasa'){
	include 'mod/perbaikan/dayajasa.php';
}elseif($_GET['page']=='rkendi2'){
	include 'mod/perbaikan/rkendi2.php';
}elseif($_GET['page']=='rkendiall'){
	include 'mod/perbaikan/rkendiall.php';
}elseif($_GET['page']=='vinv'){
	include 'mod/vinventaris/vinventaris.php';
}elseif($_GET['page']=='hrepair'){
	include 'mod/vinventaris/history.php';
}elseif($_GET['page']=='vinvr'){
	include 'mod/vinventarisr/vinventarisr.php';
}elseif($_GET['page']=='vdinvr'){
	include 'mod/vinventarisr/vdinventarisr.php';
}elseif($_GET['page']=='rekap'){
	include 'mod/rekap/rekap.php';
}elseif($_GET['page']=='lap'){
	include 'mod/laporan/laporan.php';
}
// ADMIN CONTENT & MASTER

else{
	include 'error.php';
}
?>