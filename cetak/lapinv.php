<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

$ulevel = $_SESSION['dpLevel'];
$kd     = $_SESSION['dpkode'];
    
$jen    = $_GET['jen'];

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

	$thn = (empty($_GET['thn']) ? "" : $_GET['thn']);
	$tterm = (empty($_GET['thn']) ? "1" : "YEAR(bTgl)='$thn'");
	$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (empty($_GET['bln']) ? "1" : "MONTH(bTgl)='$bln'");

	$kd     = $_SESSION['dpkode'];
    
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='2");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='3'");
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");

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
					<br><p align='center'><b><u>LAPORAN MASUK DATA INVENTARIS IT BPS $nmkabb</u></b><br>
					Tahun $title</p>
					<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='15' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' width='250' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Jenis/Merek/Tipe Barang</th>
					<th align='center' width='100' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tgl Masuk</th>
					<th align='center' width='100' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Nilai Perolehan</th>
					<th align='center' width='100' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Asal</th>
					<th align='center' width='60' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Jumlah</th>
				</tr>
				";
				$no = 0;
				$query = mysql_query("SELECT *,COUNT(bId) AS bJlh FROM barang WHERE $tterm AND $mterm AND kdkab='$kd' GROUP BY btipe ORDER BY bjenis");
				while ($d = mysql_fetch_array($query)){
					$no++;
					$kat    = getValue("kNama","ms_kategori","kId='$d[btipe]'");
	      			$jenis  = getValue("jNama","_pengadaan","jId='$d[basal]'");
	      			$tglm   = getTglIndo($d['btgl']);
	      			$rng    = getData("*","ms_ruangan","rKode='$ruang'");
					$jenis  = getValue("kNama","ms_kategori","kId='$d[bjenis]'");
					$merek  = getValue("merek","ms_merek","rMerek='$d[bmerek]'");
					$tipe   = getValue("tipe","ms_tipe","rTipe='$d[btipe]'");
					$nper   = getValue("nperolehan","ms_tipe","rTipe='$d[btipe]'");
					$asal   = getValue("sumber","_pengadaan","id='$d[btipe]'");
					$format = number_format ($nper, 0, ',', '.');

					$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' width='15' align='center'>$no</td>
						<td style='border:1px solid #000; padding: 4px;' width='300' align='left'>
							$jenis - $merek - $tipe
						</td>
						<td style='border:1px solid #000; padding: 4px;' width='100' align='center'>$tglm</td>
						<td style='border:1px solid #000; padding: 4px;' width='100' align='center'>Rp. $format</td>
						<td style='border:1px solid #000; padding: 4px;' width='140' align='left'>$asal</td>
						<td style='border:1px solid #000; padding: 4px;' width='60' align='center'>$d[bJlh]</td>
					</tr>";
				}			
				$content .= "
				</table>
				<br>

				<table>
				<tr>
					<td width='700'></td>
					<td align='center'>
						$ikota, $date_now<br>
						Mengetahui :<br><br>
						<b>Kepala BPS $nmkab</b>
						<br><br><br><br>								
						<u><b>$kepala</b></u><br>
						NIP. $nipkep
					</td>
				</tr>
				</table>";
			
			
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('L','A4','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>