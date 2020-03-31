<?php
$uid   = $_SESSION['dpId'];
if ($_SESSION['dpLevel']=="0"){
?>
<ul class="nav nav-list">
	<li class="active"><a href="?page=home"><i class="icon-desktop"></i><span class="menu-text">Beranda</span></a></li>
	<div class="sidebar-collapse" id=""></div>	
	<li><a href="?page=mkendi" class="dropdown-toggle"><i class="icon-asterisk"></i><span class="menu-text">Master Kenderaan</span></a></li>
	<li><a href="?page=rkendi" class="dropdown-toggle"><i class="icon-cog"></i><span class="menu-text">Input Perawatan</span></a></li>
	<li><a href="?page=ukendi" class="dropdown-toggle"><i class="icon-upload"></i><span class="menu-text">Upload Bukti</span></a></li>
	<li><a href="?page=rekap" class="dropdown-toggle"><i class="icon-list"></i><span class="menu-text">Rekapitulasi</span></a></li>
	<li><a href="?page=lap" class="dropdown-toggle"><i class="icon-folder-close"></i><span class="menu-text">Laporan</span></a></li>
	<div class="sidebar-collapse" id=""></div>	
	<li><a href="?page=mmerek" class="dropdown-toggle"><i class="icon-arrow-right"></i><span class="menu-text">Master Merek</span></a></li>
	<li><a href="?page=mtipe" class="dropdown-toggle"><i class="icon-arrow-right"></i><span class="menu-text">Master Tipe</span></a></li>
	<li><a href="?page=mpegawai" class="dropdown-toggle"><i class="icon-arrow-right"></i><span class="menu-text">Master Pegawai</span></a></li>
	<li><a href="?page=user" class="dropdown-toggle"><i class="icon-user"></i><span class="menu-text">User</span></a></li>
	<li><a href="?page=seting" class="dropdown-toggle"><i class="icon-desktop"></i><span class="menu-text">Seting</span></a></li>
</ul><!--/.nav-list-->
<?php
}else if ($_SESSION['dpLevel']=="1"){
?>
<ul class="nav nav-list">
	<li class="active"><a href="?page=home"><i class="icon-desktop"></i><span class="menu-text">Beranda</span></a></li>
	<div class="sidebar-collapse" id=""></div>	
	<li><a href="?page=mkendi" class="dropdown-toggle"><i class="icon-asterisk"></i><span class="menu-text">Master Kenderaan</span></a></li>	
	<li><a href="?page=ukendi" class="dropdown-toggle"><i class="icon-upload"></i><span class="menu-text">Upload Bukti</span></a></li>
	<li><a href="?page=rekap" class="dropdown-toggle"><i class="icon-list"></i><span class="menu-text">Rekapitulasi</span></a></li>
	<div class="sidebar-collapse" id=""></div>
	<li><a href="?page=lap" class="dropdown-toggle"><i class="icon-folder-close"></i><span class="menu-text">Laporan</span></a></li>
	<li><a href="?page=rkendi" class="dropdown-toggle"><i class="icon-cog"></i><span class="menu-text">Input Perawatan</span></a></li>
</ul><!--/.nav-list-->
<?php
}else if ($_SESSION['dpLevel']=="2"){	

?>
<ul class="nav nav-list">
	<li class="active"><a href="?page=home"><i class="icon-desktop"></i><span class="menu-text">Beranda</span></a></li>
	<div class="sidebar-collapse" id=""></div>	
	<li><a href="?page=rkendi" class="dropdown-toggle"><i class="icon-cog"></i><span class="menu-text">Input Perawatan</span></a></li>	
	<div class="sidebar-collapse" id=""></div>
</ul><!--/.nav-list-->
<?php
}else{
?>
<ul class="nav nav-list">
	<li class="active"><a href="?page=home"><i class="icon-desktop"></i><span class="menu-text">Beranda</span></a></li>
	<div class="sidebar-collapse" id=""></div>	
	<li><a href="?page=mkendi" class="dropdown-toggle"><i class="icon-home"></i><span class="menu-text">Master Kenderaan</span></a></li>
	<li><a href="?page=ukendi" class="dropdown-toggle"><i class="icon-upload"></i><span class="menu-text">Upload Bukti</span></a></li>
	<li><a href="?page=ukendiall" class="dropdown-toggle"><i class="icon-asterisk"></i><span class="menu-text">Bukti Perbaikan</span></a></li>
	<li><a href="?page=rkendiall" class="dropdown-toggle"><i class="icon-cog"></i><span class="menu-text">Perawatan UMUM</span></a></li>
	<li><a href="?page=rekap" class="dropdown-toggle"><i class="icon-list"></i><span class="menu-text">Rekapitulasi</span></a></li>
	<div class="sidebar-collapse" id=""></div>
	<li><a href="?page=lap" class="dropdown-toggle"><i class="icon-folder-close"></i><span class="menu-text">Laporan</span></a></li>	
</ul><!--/.nav-list-->
<?php
}
?>

