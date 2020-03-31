<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

include "../config/koneksi.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_thumb.php";
include "../config/fungsiku.php";
include '../config/konfigurasi.php';

if (empty($_SESSION['dpId'])){
	echo "<script>window.close();</script>";
}

else{
	require ("html2pdf/html2pdf.class.php");
	$filename="Data Inventaris.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = getTglIndo($now);

	$ruang   = (empty($_GET['r']) ? "" : $_GET['r']);
	$rng     = getData("*","ms_ruangan","rKode='$ruang'");
	$jruang  = getValue("rJenis","ms_ruangan","idruang='$ruang'");
	$nruang  = getValue("rNama","ms_ruangan","idruang='$ruang'");
	$rkode   = getValue("rKode","ms_ruangan","idruang='$ruang'");
	$pruang  = strtoupper(getValue("rPemilik","ms_ruangan","idruang='$ruang'"));
	$npruang = getValue("uId","user","uNama='$pruang'");

	$kd     = $_SESSION['dpkode'];
    $kkb    = $_GET['kkb'];
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kkb'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='2");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='3'");
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");

	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$title = "$nbln $thn";
	$content = "
				<table border='0' style='margin:10px 50px 50px 50px;'>
				<tr valign='middle'>
						<td><img src='$_CONFIG[llogo]' height='50'></td>
						<td width='20'></td>
						<td>
							<b>$_CONFIG[sysrptname]</b><br>
							<b>$_CONFIG[syscopyright]</b> - Alamat : $_CONFIG[sysaddress] - $_CONFIG[syscity] $_CONFIG[syspostal]<br>
							Telp. $_CONFIG[systelp] | Fax. $_CONFIG[sysfax]	| Email : $_CONFIG[sysemail]
						</td>
					</tr>
				</table>
				<hr>
					<p align='center'><b><u>LAPORAN DATA INVENTARIS DIRINCI MENURUT RUANG BPS $nmkabb</u></b></p><br>
					<table align='left'>
					<tr>
						<td><b>Laporan Per $date_now</b></td>
					</tr>
					<tr>
						<td><b>[$rkode] - Ruang $nruang (Lantai $jruang)</b></td>
					</tr>
					</table>
				<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Jenis/Merek/Tipe</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pemegang</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kategori</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kondisi</th>
				</tr>
				";
				$no = 0;
				$query = mysql_query("SELECT a.*, b.* FROM penempatan a 
																  LEFT JOIN barang b ON a.pInv=b.bkode
																  WHERE a.pRuang='$ruang'");
				while ($d = mysql_fetch_array($query)){
					$no++;
					$kat = getValue("kNama","ms_kategori","kId='$d[bjenis]'");
					$merek = getValue("merek","ms_merek","rMerek='$d[bmerek]'");
					$tipe = getValue("tipe","ms_tipe","rTipe='$d[btipe]'");
					$tipek = getValue("asal","ms_tipe","rTipe='$d[btipe]'");
	      			$asal = getValue("sumber","_pengadaan","id='$tipek'");
	      			$pem = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	      			$kondisi = ($d['bkondisi']=='1' ? "Baik" : "<b>Rusak</b>");
	      			$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$merek - $tipe - $d[bserial]</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$pem</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$kat</td>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$kondisi </td>
					</tr>";
				}			
				$content .= "
				</table>
				<br>

				<table>
				<tr>
					<td width='450'></td>
					<td align='center'>
						$ikota, $date_now<br>
						Mengetahui :<br><br>
						<b>Penanggungjawab Ruangan</b>
						<br><br><br><br>								
						<u><b>$pruang</b></u>
					</td>
				</tr>
				</table>";
			
			
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','folio','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>