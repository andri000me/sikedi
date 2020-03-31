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
	
	$filename="Form Perbaikan Inventaris.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = getTglIndo($now);

	$kd     = $_SESSION['dpkode'];
    $kkb    = $_GET['kkb'];
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kkb'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='2");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='3'");
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kkb'");
	
	$query = mysql_query("SELECT a.*,b.pTglS,b.pKondisi,b.pKet FROM perbaikan a LEFT JOIN sperbaikan b ON a.pTiket=b.pTiket WHERE a.pTiket='$_GET[ptiket]'");
	while ($p = mysql_fetch_array($query)){

	$ptiket = (empty($_GET['r']) ? "" : $_GET['r']);
	$rng = getData("*","ms_ruangan","rKode='$ruang'");
	$jruan = getValue("jNama","_jruangan","jId='$rng[rJenis]'");
	error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
	$title = "$nbln $thn";

	$content = "
				<small>Tanggal Print : $p[pTgls]</small>
				<hr>
				<table border='0' style='margin:10px 50px 50px 50px;'>
					<tr valign='middle'>
						<td><img src='$_CONFIG[llogo]' height='$_CONFIG[sysrptheight]'></td>
						<td width='20'></td>
						<td>
							$_CONFIG[sysrptname]<br>
							<h3><b>$_CONFIG[sysowner]</b></h3>
							Alamat : $_CONFIG[sysaddress] - $_CONFIG[syscity] $_CONFIG[syspostal]<br>
							Telp. $_CONFIG[systelp] | Fax. $_CONFIG[sysfax]	| Email : $_CONFIG[sysemail]
						</td>
					</tr>
				</table>
				<hr>
					<br><p align='center'><b><u>FORM BUKTI PERBAIKAN INVENTARIS</u></b></p>
					<table align='left'>
					<tr>
						<td><b>No. TIKET : $ptiket</b></td>
					</tr>
					<tr>
						<td><b>Pelapor : $p[user]</b></td>
					</tr>
					</table>
				<br>

				<br>
				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='220' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Inventaris</th>
					<th align='center' width='220' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kerusakan</th>
					<th align='center' width='220' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pasca Perbaikan</th>
				</tr>
				";
				//$no = 0;
				//$query = mysql_query("SELECT a.*, b.* FROM perbaikan a 
																  //LEFT JOIN sperbaikan b ON a.pTiket=b.pTiket
																  //WHERE a.pTiket='$ptiket'"); 
				//while ($d = mysql_fetch_array($query)){
				//$no++;
				$ruang = getValue("pRuang","penempatan","pInv='$ptiket'");
	    		$nruang = getValue("rNama","ms_ruangan","rKode='$ruang'");
	      		$kat = getValue("bjenis","barang","bkode='$ptiket'");
	    		$jenis = getValue("kNama","ms_kategori","kId='$kat'");
	    		$merek = getValue("bmerek","barang","bkode='$ptiket'");
	    		$nmerek = getValue("merek","ms_merek","rMerek='$merek'");
	    		$tipe = getValue("btipe","barang","bkode='$ptiket'");
	    		$ntipe = getValue("tipe","ms_tipe","rTipe='$tipe'");
	   		 	$serial = getValue("bserial","barang","bkode='$ptiket'");
				$nama = getValue("uNama","user","uId='$ptiket'");

				$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' width='15' align='center'>
						Ruang : [$ruang] $nruang<br>$kat - $nmerek - $tipe <br> Serial : $serial
						</td>
						<td style='border:1px solid #000; padding: 4px;' width='120' align='center'>
							<b>Tanggal : </b> $tglp<br>
	      					<b>Pelapor : </b> $d[user]<br>
      						<b>Keluhan : </b> $d[pKerusakan]
      					</td>
						<td style='border:1px solid #000; padding: 4px;' width='80' align='center'>
						<b>Tanggal : </b> $tgls<br>
					    	<b>Kondisi : </b> $kondisi<br>
					    	<b>Teknisi : </b> $d[pPJ]<br>
				   	    	<b>Aksi : </b>$d[pKet]<br>
				   	    </td>
					</tr>
					";
				}			
				$content .= "
				</table>
				<br>

				<table>
				<tr>
					<td width='450'></td>
					<td align='center'>
						Medan, $date_now<br>
						Mengetahui :<br>
						<b>$_CONFIG[sysjabatan]</b>
						<br><br><br><br><br>								
						<u><b>$_CONFIG[syspejabat]</b></u><br>
						$_CONFIG[sysnippejabat]
					</td>
				</tr>
				</table>";
			
			
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>