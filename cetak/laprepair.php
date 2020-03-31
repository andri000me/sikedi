<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Makassar");

include "../config/koneksi.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_thumb.php";
include "../config/fungsiku.php";
include '../config/konfigurasi.php';
$kd     = $_SESSION['dpkode'];
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
	$tterm = (empty($_GET['thn']) ? "1" : "YEAR(a.pTgl)='$thn'");
	$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (empty($_GET['bln']) ? "1" : "MONTH(a.pTgl)='$bln'");

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
					<br><p align='center'><b><u>LAPORAN PERAWATAN INVENTARIS IT</u></b><br>
					$title</p>
					<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='15' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' width='80' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>ID Tiket</th>
					<th align='center' width='200' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Inventaris</th>
					<th align='center' width='300' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kerusakan</th>
					<th align='center' width='300' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pasca Perbaikan</th>
				</tr>
				";
				$no = 0;
				$query = mysql_query("SELECT a.*,b.pTglS,b.pKondisi,b.pKet FROM perbaikan a 
															LEFT JOIN sperbaikan b ON a.pTiket=b.pTiket 
															WHERE $tterm AND $mterm");
				while ($d = mysql_fetch_array($query)){
				$no++;

				$brg = getData("*","barang","bInv='$d[pInv]'");
			    $tglp = getTglIndo($d['pTgl']);
			    $tgls = getTglIndo($d['pTglS']);
			    //$status = ($d['pProses']=="1" ? "<span class='badge badge-warning'>Proses</span>" : "<span class='badge badge-success'>Selesai</span>");
      			//$kondisi = ($d['pKondisi']=="1" ? "<span class='badge badge-success'>Baik</span>" : "<span class='badge badge-warning'>Rusak Ringan</span>");
			    $status = ($d['pProses']=="1" ? "<i>Proses</i>" : "Selesai");
			    $kondisi = ($d['pKondisi']=="1" ? "Baik" : "<b>Rusak</b>");

			    $tiket=$d[pInv];
      			$ruang = getValue("pRuang","penempatan","pInv='$d[pInv]'");
	   			$nruang = getValue("rNama","ms_ruangan","rKode='$ruang'");
	    
	    		$kat = getValue("bjenis","barang","bkode='$d[pInv]'");
	    		$jenis = getValue("kNama","ms_kategori","kId='$kat'");
	   			$merek = getValue("bmerek","barang","bkode='$d[pInv]'");
	    		$nmerek = getValue("merek","ms_merek","rMerek='$merek'");
	    		$tipe = getValue("btipe","barang","bkode='$d[pInv]'");
	    		$ntipe = getValue("tipe","ms_tipe","rTipe='$tipe'");
	   			$serial = getValue("bserial","barang","bkode='$d[pInv]'");
				$nama = getValue("uNama","user","uId='$d[user]'"); 

				$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
				$nmkabb  = strtoupper("$nmkab");
				$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='1'");
				$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='2");
				$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='3'");
				$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
				$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
				$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
				$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");

			      $pasca = "";
			      if (!empty($d['pTglS'])){
			      	$pasca = "Selesai : $tgls<br>
							  Kondisi : <b>$kondisi</b><br>
							  Sie JRS : $d[pPJ]<br>
							  Laporan : <i>$d[pKet]</i>";
			      }
					$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' width='15' align='center'>$no</td>
						<td style='border:1px solid #000; padding: 4px;' width='80' align='center'>$d[pTiket]</td>
						<td style='border:1px solid #000; padding: 4px;' width='200'>
							ID Inventaris : $d[pInv]<br>
							[$ruang] - $nruang<br>
							$jenis - $nmerek - $ntipe<br> sn: $serial
						</td>
						<td style='border:1px solid #000; padding: 4px;' width='200' align='left'>
							Lapor : $tglp<br>
							Pemilik Barang : <b>$d[user]</b><br>
      						Keluhan : <i>$d[pKerusakan]</i>
						</td>
						<td style='border:1px solid #000; padding: 4px;' width='200' align='left'>
							$pasca
						</td>
					</tr>";
				}			
				$content .= "
				</table>
				<br>

				<table>
				<tr>
					<td align='center'>
						Mengetahui :<br><br>
						<b>Kepala  $nmkab</b>
						<br><br><br><br>								
						<u><b>$kepala</b></u><br>
						NIP. $nipkep
					</td>
					<td width='450'></td>
					<td align='center'>
						$ikota, $date_now<br>
						Penanggungjawab :<br><br>
						<b>Kasie IPDS  $nmkab</b>
						<br><br><br><br>								
						<u><b>$ipds</b></u><br>
						NIP. $nipipds
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