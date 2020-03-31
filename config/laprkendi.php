<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

$ulevel = $_SESSION['dpLevel'];
$uid    = $_SESSION['dpId'];
$uname  = strtoupper($_SESSION['dpNama']);

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
	$filename="Data Perawatan Kenderaan Dinas.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = getTglIndo($now);

	$thn = (empty($_GET['thn']) ? "" : $_GET['thn']);
	$tterm = (empty($_GET['thn']) ? "1" : "YEAR(tglrep)='$thn'");
	$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (empty($_GET['bln']) ? "1" : "MONTH(tglrep)='$bln'");

	$ruang   = (empty($_GET['r']) ? "" : $_GET['r']);
	$rng     = getData("*","ms_ruangan","rKode='$ruang'");
	$kd      = $_SESSION['dpkode'];
    $kkb     = $_GET['kkb'];
   
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='2'");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='3'");
	$nipbendh = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='6'");
	$nipppk  = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='5'");
	$pem     = getValue("nama","ms_pegawai","pNip='uid'");		
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");
	
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$bendh   = strtoupper(getValue("nama","ms_pegawai","pNip='$nipbendh'"));
	$ppk     = strtoupper(getValue("nama","ms_pegawai","pNip='$nipppk'"));	
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$kdk = getValue("bId","kendi","bpemegang='$uid'");
	$bk  = getValue("no_plat","kendi","bId='$kdk'");

	$title   = "$nbln $thn";
	$content = "
				<table border='0' style='margin:50px 50px 50px 50px;'>
				<tr valign='middle'>						
						<td width='20'></td>
						<td>
							<b>Daftar Rincian Biaya Pembelian BBM (Premium) dan Perawatan</b><br>
							Kendaraan Bermotor Nopol : <b>$bk</b><br>
							atas nama : <b>$uname</b>
						</td>
					</tr>
				</table>
				<hr>
				<table>
				<tr valign='middle'>						
						<td width='34'></td>
						<td>
							Bulan :&nbsp;<b>$nbln</b><br>
							Mata Anggaran : &nbsp;<b>523121</b><br>
							Tahun :&nbsp;<b>$thn</b><br><br>
						</td>
					</tr>
				</table>
				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='20' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tanggal</th>
					<th align='center' width='280' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Uraian</th>
					<th align='center' width='90' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Banyak Liter</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kilometer</th>
					<th align='center' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Jumlah</th>					
				</tr>
				<tr>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[1]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[2]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[3]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[4]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[5]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[6]</td>	
				</tr>
				";
				$no=0;
				
				$d   = mysql_query("SELECT * FROM kendi WHERE id='$kdk'");

	    		$qry = mysql_query("SELECT * FROM rep_kendi WHERE $tterm AND $mterm AND bkode='$kdk'");
	
				while ($d = mysql_fetch_array($qry)){
	    		$no++;
	    		$kat      = getValue("jenis","kendi_jen","id='$d[bjenis]'");
	    		$merek    = getValue("merek","kendi_merk","id='$d[bmerek]'");
	    		$tipe     = getValue("tipe","kendi_tipe","id='$d[btipe]'");
	    		$kon      = getValue("nama","_kondisi","id='$d[bkondisi]'");	    		
	    		$f_km     = number_format ($d[km], 0, ',', '.');
	    		$f_biaya  = number_format ($d[biaya], 2, ',', '.');
	    		$pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	
					$content .= 
					"<tr>				
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='left'>$d[tglrep]</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='left'>$d[rekrep]</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$d[bbm]</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$f_km</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$f_biaya</td>
					</tr>";
					
				/*$b = mysql_fetch_array(mysql_query("SELECT sum(bbm) as bbm FROM rep_kendi WHERE $tterm AND $mterm AND bkode='$kdk'");
				$f_bbm = $b['bbm'];
				$sum_bbm  = number_format ($f_bbm, 0, ',', '.');		
*/				
				$terb = terbilang($d['biaya'], $style=2);
				}
				$content .= "

				<tr>
					<td style='border:0.5px solid #000; padding: 4px;' align='center' colspan='3'>Jumlah
					</td>			
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>$sum_bbm</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>-</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>$sum_biaya</td>	
				</tr>

				<tr>
					<td style='border:0.5px solid #000; padding: 4px;' align='center' colspan='6'><i>$terb rupiah,-</i>
					</td>									
				</tr>

				</table>
				<br><br><br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='240' align='left'>
						Mengetahui :
						<br>
						Tata Usaha/Kasubbag Urdal
						<br><br><br>								
						<u>$tu</u><br>
						$niptu
					</td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='120' align='left'>			
					</td>					
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='280' align='left'>
						$ikota, $date_now<br>
						Yang menerima,		
						<br><br><br><br>								
						<u>$uname</u><br>
						NIP. $uid
					</td>
				</tr>

				<tr>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='240' align='left'></td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='120' align='left'></td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='280' align='left'></td>
				</tr>

				<tr>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='240' align='left'></td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='120' align='left'></td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='280' align='left'></td>
				</tr>

				<tr>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='240' align='left'>
						Setuju dibayar,
						<br>
						Pejabat Pembuat Komitmen<br>
						BPS $nmkab
						<br><br><br>								
						<u>$ppk</u><br>
						$nipppk
					</td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='120' align='left'>			
					</td>					
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='280' align='left'>
						<br>Lunas pada tanggal,<br>
						Bendahara Pengeluaran 
						<br><br><br><br>								
						<u>$bendh</u><br>
						NIP. $nipbendh
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