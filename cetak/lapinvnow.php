<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");
$kd=$_SESSION['dpkode'];
$tterm = (empty($_GET['thn']) ? "1" : "YEAR(bTgl)='$thn'");
$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
$mterm = (empty($_GET['bln']) ? "1" : "MONTH(bTgl)='$bln'");
$kkb    = $_GET['kkb'];
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

	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kkb'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='2");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kkb'","status='3'");
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kkb'");

	$ruang = (empty($_GET['r']) ? "" : $_GET['r']);
	$rng = getData("*","ms_ruangan","rKode='$ruang'");
	$jruang = getValue("jNama","_jruangan","jId='$rng[rJenis]'");
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
					<p align='center'><b><u>LAPORAN KONDISI INVENTARIS IT BPS $nmkabb</u></b><br>
					Kondisi : $date_now</p>
					<br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='15' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No</th>
					<th align='center' width='160' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Kategori</th>
					<th align='center' width='60' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Total</th>
					<th align='center' width='60' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Baik</th>
					<th align='center' width='60' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rusak Ringan</th>
					<th align='center' width='60' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rusak Berat</th>
					<th align='center' width='60' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Terpakai</th>
					<th align='center' width='60' style='border:1px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tersedia</th>
				</tr>
				";
				$no = 0;
				$query = mysql_query("SELECT a.kId,a.kNama FROM ms_kategori a ORDER BY kNama ASC");
				while ($d = mysql_fetch_array($query)){
					$no++;
					$jtotal = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND kdkab='$kkb'");
			        $jbaik = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bKondisi='1' AND kdkab='$kkb'");
			        $jrusakr = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bKondisi='2' AND kdkab='$kkb'");
			        $jrusakb = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bKondisi='3' AND kdkab='$kkb'");
			        $jterpakai = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bkode IN (SELECT pInv FROM penempatan) AND kdkab='$kkb'");
			        $jtersedia = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bkode NOT IN (SELECT pInv FROM penempatan) AND kdkab='$kkb'");
					$content .= 
					"<tr>
						<td style='border:1px solid #000; padding: 4px;' width='15' align='center'>$no</td>
						<td style='border:1px solid #000; padding: 4px;' width='160' align='left'>$d[kNama]</td>
						<td style='border:1px solid #000; padding: 4px;' width='60' align='center'>$jtotal</td>
						<td style='border:1px solid #000; padding: 4px;' width='60' align='center'>$jbaik</td>
						<td style='border:1px solid #000; padding: 4px;' width='60' align='center'>$jrusakr</td>
						<td style='border:1px solid #000; padding: 4px;' width='60' align='center'>$jrusakb</td>
						<td style='border:1px solid #000; padding: 4px;' width='60' align='center'>$jterpakai</td>
						<td style='border:1px solid #000; padding: 4px;' width='60' align='center'>$jtersedia</td>
					</tr>";
				}			
				$content .= "
				</table>
				<br>

				<table>
				<tr>
					<td width='470'></td>
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
		$html2pdf = new HTML2PDF('P','A4','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>