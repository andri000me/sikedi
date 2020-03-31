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
	
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = getTglIndo($now);

	$thn = (empty($_GET['thn']) ? "" : $_GET['thn']);
	$tterm = (empty($_GET['thn']) ? "1" : "YEAR(tglrep)='$thn'");
	$bln1 = (empty($_GET['bln1']) ? "" : $_GET['bln1']);
	$nbln1 = (empty($_GET['bln1']) ? "" : getBulan($_GET['bln1']));
	$mterm1 = (empty($_GET['bln1']) ? "1" : "MONTH(tglrep)='$bln1'");
	$bln2 = (empty($_GET['bln2']) ? "" : $_GET['bln2']);
	$nbln2 = (empty($_GET['bln2']) ? "" : getBulan($_GET['bln2']));
	$mterm2 = (empty($_GET['bln2']) ? "1" : "MONTH(tglrep)='$bln2'");


	$ruang   = (empty($_GET['r']) ? "" : $_GET['r']);
	$rng     = getData("*","ms_ruangan","rKode='$ruang'");
	$kd      = $_SESSION['dpkode'];
    $kkb     = $_GET['kkb'];
   
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	$kk      = getValue("kk","kdkab","id_kabkot='$kd'");
	$nmkabb  = strtoupper("$nmkab");
	$nipkep  = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='1'");
	$niptu   = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='2'");
	$nipipds = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='3'");
	$nipbendh = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='5'");
	$nipppk  = getValue("ppk","kdkab","id_kabkot='$kd'");
	$pem     = getValue("nama","ms_pegawai","pNip='uid'");		
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");
	
	$kepala  = strtoupper(getValue("nama","ms_pegawai","pNip='$nipkep'"));
	$tu      = strtoupper(getValue("nama","ms_pegawai","pNip='$niptu'"));
	$bendh   = strtoupper(getValue("nama","ms_pegawai","pNip='$nipbendh'"));
	$ppk     = strtoupper(getValue("nama","ms_pegawai","pNip='$nipppk'"));	
	$ipds    = strtoupper(getValue("nama","ms_pegawai","pNip='$nipipds'"));
	$kdk = getValue("bId","kendi","bpemegang='$uid'");
	$bk  = getValue("no_plat","kendi","bId='$kdk'");

	$e = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));
	$jenis = getValue("jenis","kendi_jen","id='$e[bjenis]'");
	$merek = getValue("merek","kendi_merk","id='$e[bmerek]'");
	$tipe  = getValue("tipe","kendi_tipe","id='$e[btipe]'");

	$title   = "$nbln $thn";
	$filename= "$merek [$tipe] $bk $nbln $thn.pdf";
	$content = "
				<table border='0' style='margin:50px 50px 50px 160px;'>
				<tr valign='middle'>						
						<td width='20'></td>
						<td align='center'>
							<b>Daftar Rincian Biaya Pembelian BBM dan Perawatan</b><br>
							Kendaraan Bermotor $jenis - $merek [$tipe] No Polisi : <b>$bk</b><br>
							atas nama : <b>$uname</b>
						</td>
					</tr>
				</table>
				<hr>
				<table>
				<tr valign='middle'>						
						<td width='34'></td>
						<td>
						Bulan :&nbsp;<b>";

							if ($nbln1==$nbln2) {
								$bln = $nbln1;
							} else {
								$bln = $nbln1.' - '.$nbln2;
							}
	$content .= "
							$bln</b><br>
							Mata Anggaran : &nbsp;<b>523121</b><br>
							Tahun :&nbsp;<b>$thn</b><br><br>
						</td>
					</tr>
				</table>
				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='4' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 12px;'>No</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Tanggal</th>
					<th align='center' width='120' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Uraian</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>BBM</th>
					<th align='center' width='40' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Liter</th>
					<th align='center' width='40' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Km</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Jumlah</th>		
					<th align='center' width='140' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Keterangan</th>				
				</tr>
				<tr>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[1]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[2]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[3]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[4]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[5]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[6]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[7]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[8]</td>	
				</tr>
				";
				$no=0;
				
				$d   = mysql_query("SELECT * FROM kendi WHERE id='$kdk'");

	    		$qry = mysql_query("SELECT bkode,tglrep,rekrep,detrep,jbbm,bbm,km,biaya FROM rep_kendi WHERE kdkab='$kd' AND $tterm AND MONTH(tglrep) between $bln1 AND $bln2 AND bkode='$kdk' ORDER BY tglrep ASC");			
	    		$biaya =0;
	    		$tbbm =0;
				while ($d = mysql_fetch_array($qry)){
	    		$no++;
	    		$biaya +=$d[biaya];
	    		$tbbm  +=$d[bbm];
	    		$tglrep   = getTglIndo($d[tglrep]);
	    		$jbbm     = getValue("nbbm","_jbbm","id='$d[jbbm]'");
	    		$kat      = getValue("jenis","kendi_jen","id='$d[bjenis]'");
	    		$merek    = getValue("merek","kendi_merk","id='$d[bmerek]'");
	    		$tipe     = getValue("tipe","kendi_tipe","id='$d[btipe]'");
	    		$kon      = getValue("nama","_kondisi","id='$d[bkondisi]'");
	    		if ($d['km']=='0') {
	    			$km ='-';	
				} else {
					$km = number_format ($d[km], 0, ',', ',');
				}	 

				if ($d['bbm']=='0') {
	    			$bkm ='-';	
				} else {
					$bkm = $d['bbm'];
				}	  

	    		$f_biaya  = number_format ($d[biaya], 0, ',', ',');
	    		$f_tbiaya  = number_format ($biaya, 0, ',', ',');
	    		$pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	
					$content .= 
					"<tr>				
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='left'>$tglrep</td>
						<td width='120' style='border:0.5px solid #000; padding: 4px;' align='left'>$d[rekrep]</td>
						<td style='text-align:left; border:0.5px solid #000; padding: 4px;'>$jbbm</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$bkm</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$km</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$f_biaya</td>
						<td style='text-align:justify; border:0.5px solid #000; padding: 4px;' width='160'>$d[detrep]</td>
					</tr>";
								
				$terb = terbilang($biaya, $style=2);
				}
				$content .= "

				<tr>
					<td style='border:0.5px solid #000; padding: 4px;' align='center' colspan='4'>Jumlah
					</td>			
					<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$tbbm</td>
					<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>-</td>
					<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$f_tbiaya</td>	
					<td style='text-align:right; border:0.5px solid #000; padding: 4px;'></td>	
				</tr>

				<tr>
					<td style='border:0.5px solid #000; padding: 4px;' align='center' colspan='8'><i>$terb rupiah,-</i>
					</td>									
				</tr>

				</table>
				<br><br><br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='240' align='left'>
						Mengetahui :
						<br>";
						if ($kd=='1200') {
							$nkk='Kasubbag Umum';
						} else {
							$nkk='Kasubbag Tata Usaha';
						}
	$content .= "
						$nkk
						<br><br><br>								
						<u>$tu</u><br>
						NIP. $niptu
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
						 $nmkab
						<br><br><br>								
						<u>$ppk</u><br>
						NIP. $nipppk
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

				</table>
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				
				<table border='0' style='margin:50px 50px 50px 160px;'>
				<tr valign='middle'>						
						<td width='20'></td>
						<td align='center'>
							<b>BIAYA OPERASIONAL PEMELIHARAAN KENDERAAN DINAS $jenis</b><br>
							No Polisi : <b>$bk</b><br>
							atas nama : <b>$uname</b>
						</td>
					</tr>
				</table>
				<hr>
				<table>
				<tr valign='middle'>						
						<td width='34'></td>
						<td>
						Bulan :&nbsp;<b>";

							if ($nbln1==$nbln2) {
								$bln = $nbln1;
							} else {
								$bln = $nbln1.' - '.$nbln2;
							}
	$content .= "
							$bln</b><br>
							Mata Anggaran : &nbsp;<b>523121</b><br>
							Tahun :&nbsp;<b>$thn</b><br><br>
						</td>
					</tr>
				</table>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<td align='center' width='540' style='border:0.5px solid #000; background-color: white; padding: 12px;'><br><br><br><br><br><br><br><br><br><br><br><br><br><br> - tempel struk perawatan disini - <br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>								
				</tr>
				</table>
				<br><br><br><br>
				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='240' align='left'>
						
					</td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='120' align='left'>			
					</td>					
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='280' align='left'>
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
					</td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='120' align='left'>			
					</td>					
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='280' align='left'>			
					</td>
				</tr>
				</table>

				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
				
				<table border='0' style='margin:100px 50px 50px 160px;'>
				<tr valign='middle'>						
						<td width='20'></td>
						<td align='center'>
							<b>BON/STRUK PENGGUNAAN BBM KENDERAAN DINAS $jenis</b><br>
							No Polisi : <b>$bk</b><br>
							atas nama : <b>$uname</b>
						</td>
					</tr>
				</table>
				<hr>
				<table>
				<tr valign='middle'>						
						<td width='34'></td>
						<td>
							Bulan :&nbsp;<b>";

							if ($nbln1==$nbln2) {
								$bln = $nbln1;
							} else {
								$bln = $nbln1.' - '.$nbln2;
							}
	$content .= "
							$bln</b><br>
							Mata Anggaran : &nbsp;<b>523121</b><br>
							Tahun :&nbsp;<b>$thn</b><br><br>
						</td>
					</tr>
				</table>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<td align='center' width='240' style='border:0.5px solid #000; background-color: white; padding: 12px;'><br><br><br><br><br><br><br><br><br><br><br><br> - tempel struk BBM disini - <br><br><br><br><br><br><br><br><br><br><br><br></td>
					<td align='center' width='10' style='border:0px solid #000; background-color: white; padding: 12px;'><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>	
					<td align='center' width='240' style='border:0.5px solid #000; background-color: white; padding: 12px;'><br><br><br><br><br><br><br><br><br><br><br><br> - tempel struk BBM disini - <br><br><br><br><br><br><br><br><br><br><br><br></td>						
				</tr>	
				<tr>
					<td align='center' width='240' style='border:0px solid #000; background-color: white; padding: 12px;'><br></td>
					<td align='center' width='10' style='border:0px solid #000; background-color: white; padding: 12px;'><br></td>	
					<td align='center' width='240' style='border:0px solid #000; background-color: white; padding: 12px;'><br></td>						
				</tr>	
				<tr>
					<td align='center' width='240' style='border:0.5px solid #000; background-color: white; padding: 12px;'><br><br><br><br><br><br><br><br><br><br><br><br> - tempel struk BBM disini - <br><br><br><br><br><br><br><br><br><br><br><br></td>
					<td align='center' width='10' style='border:0px solid #000; background-color: white; padding: 12px;'><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>	
					<td align='center' width='240' style='border:0.5px solid #000; background-color: white; padding: 12px;'><br><br><br><br><br><br><br><br><br><br><br><br> - tempel struk BBM disini - <br><br><br><br><br><br><br><br><br><br><br><br></td>						
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