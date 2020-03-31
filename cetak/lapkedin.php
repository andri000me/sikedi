<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Makassar");

$ulevel = $_SESSION['dpLevel'];
$kkb     = $_GET['kkb'];

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
	$kd      = $_SESSION['dpkode'];
    $kkb     = $_GET['kkb'];
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kkb'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='2");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='3'");
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kkb'");

	$title   = "$nbln $thn";
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
					<p align='center'><b><u>DAFTAR KENDERAAN DINAS  $nmkabb </u></b><br>
					Kondisi : $date_now</p>
					<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Jenis</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Merek</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tipe</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No Mesin</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No Rangka</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No Plat</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No BPKB</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pemegang</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kondisi</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tahun Per</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Harga Per</th>
				</tr>
				";
				$no=0;
	    		$qry = mysql_query("SELECT * FROM kendi WHERE kdkab='$kkb' ORDER BY thn_per DESC");
	
				while ($d = mysql_fetch_array($qry)){
	    		$no++;
	    		$kat      = getValue("jenis","kendi_jen","id='$d[bjenis]'");
	    		$merek    = getValue("merek","kendi_merk","id='$d[bmerek]'");
	    		$tipe     = getValue("tipe","kendi_tipe","id='$d[btipe]'");
	    		$kon      = getValue("nama","_kondisi","id='$d[bkondisi]'");	    		
	    		$format   = number_format ($d[harga_per], 0, ',', '.');
	    		$pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	
					$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$kat</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$merek</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$tipe</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$d[no_mesin]</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$d[no_rangka]</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$d[no_plat]</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$d[no_bpkb]</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$pemegang</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$kon</td>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$d[thn_per]</td>
						<td style='border:1px solid #000; padding: 4px;' align='right'>$format</td>
					</tr>";
				}			
				$content .= "
				</table>
				<br>

				<table>
				<tr>
					<td width='820'></td>
					<td align='center'>
						$ikota, $date_now<br>
						Mengetahui :<br><br>
						<b>Kepala  $nmkab</b>
						<br><br><br><br>								
						<u><b>$kepala</b></u><br>
						NIP. $nipkep
					</td>
				</tr>
				</table>";
			
			
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('L','Folio','fr', false, 'ISO-8859-15',array(2, 2, 2, 2)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>