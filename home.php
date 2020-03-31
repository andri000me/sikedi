<script src="../assets/chart/Chart.js"></script>
<style type="text/css">
canvas {
	width: 100% !important;
	max-width: 800px;
	height: auto !important;
}
</style>
<?php

$kd    = $_SESSION['dpkode'];
$uname = $_SESSION['dpNama'];
$uid   = $_SESSION['dpId'];
$ulevel= $_SESSION['dpLevel'];
$idken = getValue("bId","kendi","bpemegang='$uid'");
$e     = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));
$jenis = getValue("jenis","kendi_jen","id='$e[bjenis]'");
$merek = getValue("merek","kendi_merk","id='$e[bmerek]'");
$tipe  = getValue("tipe","kendi_tipe","id='$e[btipe]'");
$hari_s = getHari(date("w"));
$infologin =  "$hari_s, ".getTglIndo(date('Y m d'))." | ".date('H:i:s');
?>
<div class="alert alert-block alert-success">
	<button type="button" class="close" data-dismiss="alert">
		<i class="icon-remove"></i>
	</button>
	<i class="icon-ok green"></i>
	Hai,, <strong class="blue"><?php echo $_SESSION['dpNama'];?></strong>, 
	selamat datang di Aplikasi Sistem Informasi Pemakaian Kenderaan Dinas (SIKPD V.1.3).<br> Silahkan klik menu pilihan yang berada di sebelah kiri untuk mengelola konten anda.
	<small class="red">
		<p>Login : <?php echo $infologin;?> WIB</p>
	</small>
</div>
<!--PAGE CONTENT BEGINS-->
<div class="row-fluid">
	<div class="span12">
		<div class="table-header">
			REKAPITULASI PEMAKAIAN KENDERAAN DINAS <b><?php echo $e['no_plat'];?></b>, <?php echo strtoupper($infologin);?>
		</div>
		<div class="row-fluid">
			<table id="myTable" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th colspan='2' class="left" width="200px">Quick Info</th>
					</tr>
				</thead>
				<tbody>
					<?php
					error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
					$year = date('Y'); 
					$tb = mysql_fetch_array(mysql_query("SELECT sum(biaya) as biaya FROM rep_kendi WHERE bkode='$idken' AND YEAR(tglrep)=$year "));
					$ntot = $tb['biaya'];
					$nntot  = number_format ($ntot, 0, ',', ',');

					$pagu = getValue("pagu","kendi","bId='$idken'");
					$sisa = $pagu - $ntot;
					$npagu  = number_format ($pagu, 0, ',', ',');

					$bbm = mysql_fetch_array(mysql_query("SELECT sum(biaya) as biaya FROM rep_kendi WHERE jbbm!=NULL AND bkode='$idken' AND YEAR(tglrep)=$year "));
					$nbbm = $bbm['biaya'];
					$nnbbm  = number_format ($ntot, 0, ',', ',');

					$l = mysql_fetch_array(mysql_query("SELECT sum(bbm) as bbm FROM rep_kendi WHERE bkode='$idken' AND YEAR(tglrep)=$year "));
					$nl = $l['bbm'];
					$nnl  = number_format ($nl, 2, ',', ',');
					
					$km = mysql_fetch_array(mysql_query("SELECT max(km) as km FROM rep_kendi WHERE bkode='$idken'"));
					$nkm = $km['km'];
					$nnkm  = number_format ($nkm, 0, ',', ',');
					
					echo "
					<tr>
					<td class='left' width='20'><span class='red'><i class='icon-home bigger-300'></i></span></td><td><font color='#dd5a43' size='6'>Rp. $npagu</font> Pagu tahun $year</td>
					</tr>
					<td class='left' width='20'><span class='red'><i class='icon-th-list bigger-300'></i></span></td><td>
					<img class='pull-left' src='foto_kendi/$e[foto]' width='200' margin='5px' data-rel='tooltip' data-placement='right' data-original-title='Foto Sekarang'>
					</td>
					</tr>
					<tr>
					<td class='left' width='20'><span class='red'><i class='icon-user bigger-300'></i></span></td><td><font color='#dd5a43' size='6'>$nnkm </font>Kilometer</td>
					</tr>
					<tr>
					<td class='left' width='20'><span class='red'><i class='icon-ok bigger-300'></i></span></td><td><font color='#dd5a43' size='6'>$nnl</font> Liter BBM terpakai</td>
					</tr>					
					<td class='left' width='20'><span class='red'><i class='icon-download bigger-300'></i></span></td><td><font color='#dd5a43' size='6'>Rp. $nntot </font> Total Biaya Terserap</td>
					</tr>";
					?>
				</tbody>
			</table>
		</div>
	</div>
	<!--PAGE CONTENT ENDS-->


