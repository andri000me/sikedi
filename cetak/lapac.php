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
	$filename="Form Peminjaman Inventaris.pdf";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	
	$kd      = $_SESSION['dpkode'];
    $rep_ac  = $_GET['rep_ac'];
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='2");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='3'");
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");

	$thn = (empty($_GET['thn']) ? "" : $_GET['thn']);
	$tterm = (empty($_GET['thn']) ? "1" : "YEAR(a.pTgl)='$thn'");
	$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (empty($_GET['bln']) ? "1" : "MONTH(a.pTgl)='$bln'");

	$ptiket = (empty($_GET['r']) ? "" : $_GET['r']);
	$rng = getData("*","perbaikan","pTiket='$ptiket'");
	$user = getValue("user","perbaikan","pTiket='$ptiket'");

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
					<p align='center'><b><u>KARTU KENDALI PERAWATAN AC BPS $nmkabb</u></b></p>
					<table align='left'>
					
					</table>
				<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='280' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Inventaris</th>
					<th align='center' width='380' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Perawatan</th>			
				</tr>
				";
				$no = 0;
				$query = mysql_query("SELECT * FROM rep_ac WHERE bkode='$rep_ac'");
				while ($d = mysql_fetch_array($query)){
				$no++;
			
			    $tglrep = getTglIndo($d[tglrep]);
			   
			    $ruang = getValue("pRuang","penempatan","pInv='$rep_ac'");
	    		$nruang = getValue("rNama","ms_ruangan","idruang='$ruang'");
	    		$merek = getValue("bmerek","barang","bkode='$rep_ac'");
	    		$nmerek = getValue("merek","ms_merek","rMerek='$merek'");
	    		$tipe = getValue("btipe","barang","bkode='$rep_ac'");
	    		$ntipe = getValue("tipe","ms_tipe","rTipe='$tipe'");
	    		$serial = getValue("bserial","barang","bkode='$rep_ac'");


			    $pasca = "";
			   		$content .= 
					"<tr>
						 <td style='border:1px solid #000; padding: 4px;' width='280' align='left'>Kode Barang : <b>$rep_ac</b><br>
							Ruang : $nruang <font color='blue'><br>Merek : $nmerek <br> Tipe : $ntipe <br> sn : <b>$serial</b></font>
						</td>
						<td style='border:1px solid #000; padding: 4px;' width='380' align='left'>
							Tgl Servis 	: $tglrep<br>
							Rekanan  	: <br><b>$d[rekrep]</b><br>
							Perawatan   : <i><font color='red'>$d[detrep]</font></i>
      					</td>					
					</tr>";
							
				    $content .= "
				</table>
				<br><br>

				<table>
				<tr>
					<td style='border:1px solid #A9A9A9; padding: 4px;' width='220' align='center'>
						Pejabat Pengadaan:
						<br><br><br><br>								
						<b>OLIVER BOBBY REYNOLD SIMARMATA</b>
					</td>
					<td style='border:1px solid #A9A9A9; padding: 4px;' width='220' align='center'>
						Rekanan:
						<br><br><br><br>								
						<b>DESAY BAKARA</b>
					</td>
					<td style='border:1px solid #A9A9A9; padding: 4px;' width='220' align='center'>
						Pejabat Penerima Hasil Pekerjaan:
						<br><br><br><br>								
						<b>HELMI</b>
					</td>
					
				</tr>

				</table>";
			}
			
	// conversion HTML => PDF
	try
	{
		$html2pdf = new HTML2PDF('L','A5','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>