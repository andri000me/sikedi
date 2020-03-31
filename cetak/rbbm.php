<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

$ulevel = $_SESSION['dpLevel'];
$uid    = $_SESSION['dpId'];
$kd     = $_SESSION['dpkode'];
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
							<b>Rekapitulasi Penggunaan BBM Menurut Jenis<br>
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
							Tahun :&nbsp;<b>$thn</b><br><br>
						</td>
					</tr>
				</table>
				<table cellpadding=0 border='0' cellspacing='0' align='center'>
				<tr>
					<th align='center' rowspan='2' width='5' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 12px;'>No</th>
					<th align='center' rowspan='2' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Bulan</th>
					<th align='center' colspan='2' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Bensin</th>
					<th align='center' colspan='2' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pertalite</th>
					<th align='center' colspan='2' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Pertamax</th>
					<th align='center' colspan='2' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Solar</th>
					<th align='center' rowspan='2' width='60' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Non BBM</th>	
					<th align='center' rowspan='2' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Total</th>						
				</tr>

				<tr>					
					<th align='center' width='20' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Ltr</th>
					<th align='center' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rp</th>
					<th align='center' width='20' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Ltr</th>
					<th align='center' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rp</th>
					<th align='center' width='20' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Ltr</th>
					<th align='center' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rp</th>	
					<th align='center' width='20' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Ltr</th>
					<th align='center' width='80' style='border:0.5px solid #000; background-color: $_CONFIG[syscolor]; padding: 4px;'>Rp</th>	
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
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[9]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[10]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[11]</td>
					<td style='border:0.5px solid #000; padding: 4px;' align='center'>[12]</td>
				</tr>
				";
		$no = 0;
		$qry = mysql_query("SELECT DISTINCT(MONTH(tglrep)) AS bln FROM rep_kendi WHERE kdkab='$kd' AND (YEAR(tglrep))='$_GET[thn]'");
		while ($r = mysql_fetch_array($qry)){
		$no++;
		  if($r['bln']<10){ $b='%-0'.$r['bln'].'-%';}
          if($r['bln']>10){ $b='%-'.$r['bln'].'-%';}

	   	$t1 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as bensin FROM rep_kendi WHERE kdkab='$kd' AND jbbm='1' AND tglrep LIKE '$b'"));
		$bensin  = $t1['bensin'];
		$nbensin = number_format ($bensin, 0, ',', ',');
		$tbensin  ==0;
		$tbensin  +=$bensin;
		$ntbensin = number_format ($tbensin, 0, ',', ',');

		$t1l = mysql_fetch_array(mysql_query("SELECT sum(bbm) as bensinl FROM rep_kendi WHERE kdkab='$kd' AND jbbm='1' AND tglrep LIKE '$b'"));
		$bensinl  = $t1l['bensinl'];
		$nbensinl = number_format ($bensinl, 2, ',', ',');
		$tbensinl  ==0;
		$tbensinl  +=$bensinl;
		$ntbensinl = number_format ($tbensinl, 2, ',', ',');

		$t2 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertalite FROM rep_kendi WHERE kdkab='$kd' AND jbbm='2' AND tglrep LIKE '$b'"));
		$pertalite  = $t2['pertalite'];
		$npertalite = number_format ($pertalite, 0, ',', ',');
		$tpertalite  ==0;
		$tpertalite  +=$pertalite;
		$ntpertalite = number_format ($tpertalite, 0, ',', ',');

		$t2l = mysql_fetch_array(mysql_query("SELECT sum(bbm) as pertalitel FROM rep_kendi WHERE kdkab='$kd' AND jbbm='2' AND tglrep LIKE '$b'"));
		$pertalitel  = $t2l['pertalitel'];
		$npertalitel = number_format ($pertalitel, 2, ',', ',');
		$tpertalitel  ==0;
		$tpertalitel  +=$pertalitel;
		$ntpertalitel = number_format ($tpertalitel, 2, ',', ',');		

		$t3 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertamax FROM rep_kendi WHERE kdkab='$kd' AND jbbm='3' AND tglrep LIKE '$b'"));
		$pertamax  = $t3['pertamax'];
		$npertamax = number_format ($pertamax, 0, ',', ',');
		$tpertamax  ==0;
		$tpertamax  +=$pertamax;
		$ntpertamax = number_format ($tpertamax, 0, ',', ',');

		$t3l = mysql_fetch_array(mysql_query("SELECT sum(bbm) as pertamaxl FROM rep_kendi WHERE kdkab='$kd' AND jbbm='3' AND tglrep LIKE '$b'"));
		$pertamaxl  = $t3l['pertamaxl'];
		$npertamaxl = number_format ($pertamaxl, 2, ',', ',');
		$tpertamaxl  ==0;
		$tpertamaxl  +=$pertamaxl;
		$ntpertamaxl = number_format ($tpertamaxl, 2, ',', ',');

		$t4 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as solar FROM rep_kendi WHERE kdkab='$kd' AND jbbm='4' AND tglrep LIKE '$b'"));
		$solar  = $t4['solar'];
		$nsolar = number_format ($solar, 0, ',', ',');
		$tsolar  ==0;
		$tsolar  +=$solar;
		$ntsolar = number_format ($tsolar, 0, ',', ',');

		$t4l = mysql_fetch_array(mysql_query("SELECT sum(bbm) as solarl FROM rep_kendi WHERE kdkab='$kd' AND jbbm='4' AND tglrep LIKE '$b'"));
		$solarl  = $t4l['solarl'];
		$nsolarl = number_format ($solarl, 2, ',', ',');
		$tsolarl  ==0;
		$tsolarl  +=$solarl;
		$ntsolarl = number_format ($tsolarl, 2, ',', ',');

		$t5 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as uncat FROM rep_kendi WHERE (jbbm=0 OR jbbm IS NULL) AND tglrep LIKE '$b'"));
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
		
		$nmkab    = getValue("nama_kabkot","kdkab","id_kabkot='$d[kdkab]'");
	    $nmbln = getBulan($r[bln]);

        			
					$content  .= 
					"<tr>				
						<td style='text-align:center; border:0.5px solid #000; padding: 4px;'>$no</td>
						<td style='text-align:left; border:0.5px solid #000; padding: 4px;'>$nmbln</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nbensinl</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nbensin</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$npertalitel</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$npertalite</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$npertamaxl</td>						
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$npertamax</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nsolarl</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nsolar</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$nuncat</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntot</td>						
					</tr>";
					
					$terb = terbilang($biaya, $style=2);
					}
					$content .= "
					<tr>				
						<td colspan='2' style='border:0.5px solid #000; padding: 4px;' align='center'>Jumlah</td>						
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntbensinl</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntbensin</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntpertalitel</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntpertalite</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntpertamaxl</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntpertamax</td>
						<td style='text-align:right; border:0.5px solid #000; padding: 4px;'>$ntsolarl</td>
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
		$html2pdf = new HTML2PDF('L','A4','fr', false, 'ISO-8859-15',array(2, 2, 2, 2)); //setting ukuran kertas dan margin pada dokumen anda
		// $html2pdf->setModeDebug();
		$html2pdf->setDefaultFont('Arial');
		$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		$html2pdf->Output($filename);
	}
	catch(HTML2PDF_exception $e) { echo $e; }
}
?>