<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

$ulevel = $_SESSION['dpLevel'];
$uid    = $_SESSION['dpId'];
$uname  = strtoupper($_SESSION['dpNama']);
$kd     = $_SESSION['dpkode'];

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
	$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (empty($_GET['bln']) ? "1" : "MONTH(tglrep)='$bln'");

	$ruang   = (empty($_GET['r']) ? "" : $_GET['r']);
	$rng     = getData("*","ms_ruangan","rKode='$ruang'");
	$kd      = $_SESSION['dpkode'];
	if ($kd==1200) {
	    $tt ='Kasubbag Umum';
	} else {
	    $tt ='Kasubbag Tata Usaha';
	}
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

	$e = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));
	$jenis = getValue("jenis","kendi_jen","id='$e[bjenis]'");
	$merek = getValue("merek","kendi_merk","id='$e[bmerek]'");
	$tipe  = getValue("tipe","kendi_tipe","id='$e[btipe]'");

	$title   = "$nbln $thn";
	$filename= "$merek [$tipe] $bk $nbln $thn.pdf";
	$content = "
				<table border='0' style='margin:50px 50px 50px 200px;'>
				<tr valign='middle'>						
						<td width='20'></td>
						<td align='center'>
							<b>Rekapitulasi Penggunaan BBM Menurut Jenis BBM<br>
							   KENDERAAN OPERASIONAL  $nmkabb<br></b>							
						</td>
					</tr>
				</table>
				<hr>
				<table>
				<tr valign='middle'>						
						<td width='34'></td>
						<td>							
							Mata Anggaran : &nbsp;<b>523121</b><br>
							Bulan/Tahun :&nbsp;<b>$nbln - $thn</b><br><br>
						</td>
					</tr>
				</table>
				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' width='5' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 12px;'>No</th>
					<th align='center' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>No Polisi</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Bensin</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pertalite</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pertamax</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Solar</th>
					<th align='center' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Non BBM</th>	
					<th align='center' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Total</th>						
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
	$no = 0;
    $qry = mysql_query("SELECT DISTINCT bkode AS bk FROM rep_kendi WHERE kdkab='$kd' AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'");
		while ($r = mysql_fetch_array($qry)){



    $plat  = getValue("no_plat","kendi","bId='$r[bk]'");
    $no++;
      /* Inisiasi Format Bulan */
      if($r['bln']<10){ $b='%-0'.$r['bln'].'-%';}
      if($r['bln']>10){ $b='%-'.$r['bln'].'-%';}

    $t1 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as bensin FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=1 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'"));
	$bensin  = $t1['bensin'];
	$nbensin = number_format ($bensin, 0, ',', ',');
	$tbensin  ==0;
	$tbensin  +=$bensin;
	$ntbensin = number_format ($tbensin, 0, ',', ',');

	$t2 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertalite FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=2 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'"));
	$pertalite  = $t2['pertalite'];
	$npertalite = number_format ($pertalite, 0, ',', ',');
	$tpertalite  ==0;
	$tpertalite  +=$pertalite;
	$ntpertalite = number_format ($tpertalite, 0, ',', ',');

	$t3 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertamax FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=3 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'"));
	$pertamax  = $t3['pertamax'];
	$npertamax = number_format ($pertamax, 0, ',', ',');
	$tpertamax  ==0;
	$tpertamax  +=$pertamax;
	$ntpertamax = number_format ($tpertamax, 0, ',', ',');

	$t4 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as solar FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=4 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'"));
	$solar  = $t4['solar'];
	$nsolar = number_format ($solar, 0, ',', ',');
	$tsolar  ==0;
	$tsolar  +=$solar;
	$ntsolar = number_format ($tsolar, 0, ',', ',');

	$t5 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as uncat FROM rep_kendi WHERE bkode=$r[bk] AND (jbbm=0 OR jbbm IS NULL) AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'"));
	$uncat  = $t5['uncat'];
	$nuncat = number_format ($uncat, 0, ',', ',');
	$tuncat  ==0;
	$tuncat  +=$uncat;
	$ntuncat = number_format ($tuncat, 0, ',', ',');


	$tot   = $bensin+$pertalite+$pertamax+$solar+$uncat;
	$ntot  = number_format ($tot, 0, ',', ',');
	$ttot  ==0;
	$ttot  +=$tot;
	$nttot = number_format ($ttot, 0, ',', ',');
   
	    			
					$content  .= 
					"<tr>				
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='left'>$plat</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nbensin</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$npertalite</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$npertamax</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nsolar</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nuncat</td>						
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntot</td>
					</tr>";
					
					$terb = terbilang($biaya, $style=2);
					}
					$content .= "
					<tr>				
						<td colspan='2' style='border:0.5px solid #000; padding: 4px;' align='center'>Jumlah</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntbensin</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntpertalite</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntpertamax</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntsolar</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntuncat</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nttot</td>				
					</tr>
				</table>
				<br><br><br>

				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='240' align='left'>					
					</td>
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='120' align='left'>			
					</td>					
					<td style='border:0px solid #A9A9A9; padding: 4px;' width='280' align='left'>
						$ikota, $date_now<br>
						$tt,		
						<br><br><br><br>								
						<u>$tu</u><br>
						$niptu
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
				";
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