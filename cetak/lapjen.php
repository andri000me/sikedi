<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

$ulevel = $_SESSION['dpLevel'];
$kd     = $_SESSION['dpkode'];
$jen    = $_GET['jen'];
$jen_kd = $_GET['jen_kd'];

include "../config/koneksi.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_thumb.php";
include "../config/fungsiku.php";
include '../config/konfigurasi.php';

if (empty($_SESSION['dpId'])){
	echo "<script>window.close();</script>";
}

else{
    $kd     = $_SESSION['dpkode'];
    $kkb    = $_GET['kkb'];
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$jen_kd'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$jen_kd'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$jen_kd'","status='2");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$jen_kd'","status='3'");
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$jen_kd'");
	
	$thn = (empty($_GET['thn']) ? "" : $_GET['thn']);
	$tterm = (empty($_GET['thn']) ? "1" : "YEAR(bTgl)='$thn'");
	$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (empty($_GET['bln']) ? "1" : "MONTH(bTgl)='$bln'");
	$njen   = strtoupper(getValue("kNama","ms_kategori","kId='$jen'"));
	$title = "$nbln $thn";
	require ("html2pdf/html2pdf.class.php");
	$filename="Data Inventaris $njen.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = getTglIndo($now);

	
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
					<br><p align='center'><b><u>REKAPITULASI $njen BPS $nmkabb</u></b><br></p>
					<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center'style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Merek/Tipe/Serial</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Ruangan</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pemegang</th>
					<th align='center' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kondisi</th>
				</tr>
				";
				$qry = mysql_query("SELECT * FROM barang WHERE kdkab='$jen_kd' AND bjenis='$jen' ORDER BY onCreate DESC");
				$no  = 0;
				while ($d = mysql_fetch_array($qry)){
	    		$no++;
	    		$ruang  = getValue("pRuang","penempatan","pInv='$d[bkode]'");
	    		$nruang = getValue("rNama","ms_ruangan","idruang='$ruang'");
	    		$pruang = getValue("rPemilik","ms_ruangan","idruang='$ruang'");
	    		$nnama  = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	    		$merek  = getValue("merek","ms_merek","rMerek='$d[bmerek]'");
	    		$tipe   = getValue("tipe","ms_tipe","rTipe='$d[btipe]'");
	    		if ($d[bkondisi] =='1') {
				$kon="Baik";	
	    		} else if ($d[bkondisi] =='2') {
				$kon="Rusak Ringan";	
				} else {
				$kon="Rusak Berat";	
				}

				$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$merek/$tipe/$d[bserial]</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$nruang
						</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$nnama</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$kon
						</td>
					</tr>";
				}			
				$content .= "
				</table>
				<br>

				<table>
				<tr>
					<td width='400'></td>
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