<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

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
					<p align='center'><b><u>REKAPITULASI KENDERAAN DINAS  $nmkabb MENURUT KONDISI</u></b><br>
					Kondisi : $date_now</p>
					<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='30' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' width='80' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Jenis</th>
					<th align='center' width='80' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Merek</th>
					<th align='center' width='140' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tipe</th>
					<th align='center' width='40' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Total</th>
					<th align='center' width='40' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Baik</th>
					<th align='center' width='40' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rusak Ringan</th>
					<th align='center' width='40' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rusak Berat</th>
				</tr>
				";

				$qry = mysql_query("SELECT DISTINCT bjenis, bmerek, btipe FROM kendi WHERE kdkab='$_GET[kkb]' ORDER BY bjenis");
				while ($d = mysql_fetch_array($qry)){
		     	$no++;
		      	$jtotal = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]'");
		      	$jbaik = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]' AND bkondisi='1'");
		      	$jrusakr = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]' AND bkondisi='2'");
		      	$jrusakb = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]' AND bkondisi='3'");	
		      		     
		      	$jjtotal +=$jtotal;
	    		$jjbaik  +=$jbaik;
	    		$jjrr    +=$jrusakr;
	    		$jjrb    +=$jrusakb;
	    		
			  	$jttersedia = $jtotal-$jterpakai-$jpinjam;
			  	$jen = getValue("jenis","kendi_jen","id='$d[bjenis]'");
			 	$merek = getValue("merek","kendi_merk","id='$d[bmerek]'");
			 	$tipe = getValue("tipe","kendi_tipe","id='$d[btipe]'");

				$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$jen</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$merek</td>
						<td style='border:1px solid #000; padding: 4px;' align='left'>$tipe</td>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$jtotal</td>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$jbaik</td>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$jrusakr</td>
						<td style='border:1px solid #000; padding: 4px;' align='center'>$jrusakb</td>
					</tr>";
				}	

				$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' align='center' colspan='4'><b>Jumlah</b></td>					
						<td style='border:1px solid #000; padding: 4px;' align='center'><b>$jjtotal</b></td>
						<td style='border:1px solid #000; padding: 4px;' align='center'><b>$jjbaik</b></td>
						<td style='border:1px solid #000; padding: 4px;' align='center'><b>$jjrr</b></td>
						<td style='border:1px solid #000; padding: 4px;' align='center'><b>$jjrb</b></td>
					</tr>";	
				$content .= "
				</table>
				<br><br><br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<td style='border:0px solid #000; padding: 4px;' align='center'>
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
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(2, 2, 2, 2)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>