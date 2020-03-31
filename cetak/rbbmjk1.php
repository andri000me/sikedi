<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

    $host="localhost";
    $user="bapustaw";
    $pass="xO70w7c2xG";
    $db="bapustaw_ow_invendp";
    $mysqli = new mysqli($host,$user,$pass,$db);
    if ($mysqli->connect_errno) {
      printf("Eror koneksi", $mysqli->connect_error);
      exit();
  }
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
    $sql = "SELECT DISTINCT bkode AS bk FROM rep_kendi WHERE kdkab='$kd' AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'";
    $modal=mysqli_query($mysqli, $sql);
    while($r=mysqli_fetch_array($modal)){
    $plat  = getValue("no_plat","kendi","bId='$r[bk]'");
    $no++;
      /* Inisiasi Format Bulan */
      if($r['bln']<10){ $b='%-0'.$r['bln'].'-%';}
      if($r['bln']>10){ $b='%-'.$r['bln'].'-%';}

    
      $sql2 = "SELECT SUM(biaya) AS pertalite FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=3 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'";
      $con2=mysqli_query($mysqli, $sql2);
      $pertalite=mysqli_fetch_assoc($con2);

     
      $sql1 = "SELECT SUM(biaya) AS pertamax FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=2 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'";
      $con1=mysqli_query($mysqli, $sql1);
      $pertamax=mysqli_fetch_assoc($con1);  

    
      $sql5 = "SELECT SUM(biaya) AS bensin FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=1 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'";
      $con5=mysqli_query($mysqli, $sql5);
      $bensin=mysqli_fetch_assoc($con5);    

     
      $sql6 = "SELECT SUM(biaya) AS solar FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=4 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'";
      $con6=mysqli_query($mysqli, $sql6);
      $solar=mysqli_fetch_assoc($con6); 

      /* Ambil Total Uncategorized */
      $sql3 = "SELECT SUM(biaya) AS uncat FROM rep_kendi WHERE bkode=$r[bk] AND (jbbm=0 OR jbbm IS NULL) AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'";
      $con3=mysqli_query($mysqli, $sql3);
      $uncat=mysqli_fetch_assoc($con3);

      /* Ambil Total Semua */
      $sql4 = "SELECT SUM(biaya) AS total FROM rep_kendi WHERE bkode=$r[bk] AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'";
      $con4=mysqli_query($mysqli, $sql4);
      $total=mysqli_fetch_assoc($con4);
  
					
					$nmbln = getBulan($r[bln]);
					$n_bensin    +=$bensin['bensin'];			
	    			$n_pertalite +=$pertalite['pertalite'];	
	    			$n_pertamax  +=$pertamax['pertamax'];	
	    			$n_solar     +=$solar['solar'];	
	    			$n_uncat     +=$uncat['uncat'];	
	    			$n_total     +=$total['total'];	

	    			$t_bensin    = number_format($n_bensin, 0, "-", ",");
	    			$t_pertalite = number_format($n_pertalite, 0, "-", ",");
	    			$t_pertamax  = number_format($n_pertamax, 0, "-", ",");	
	    			$t_solar     = number_format($n_solar, 0, "-", ",");
	    			$t_uncat     = number_format($n_uncat, 0, "-", ",");
	    			$t_total     = number_format($n_total, 0, "-", ",");
                    
                    /*if $bensin ==0) {
	    			    $nt_bensin='-';
	    			} else {
	    			    $bensin='$t_bensin;'
	    			}
	    			if $t_pertalite ==0) {
	    			    $nt_pertalite='-';
	    			} else {
	    			    $nt_pertalite='$t_pertalite;'
	    			}
	    			if $t_pertamax ==0) {
	    			    $nt_pertamax='-';
	    			} else {
	    			    $nt_pertamax='$t_pertamax;'
	    			}
	    			if $t_solar ==0) {
	    			    $nt_solar='-';
	    			} else {
	    			    $nt_solar='$t_solar;'
	    			}
	    			if $t_uncat ==0) {
	    			    $nt_uncat='-';
	    			} else {
	    			    $nt_uncat='$t_uncat;'
	    			}*/
	    			
	    			$bensin    = number_format($bensin['bensin'], 0, "-", ",");
	    			$pertalite = number_format($pertalite['pertalite'], 0, "-", ",");
	    			$pertamax  = number_format($pertamax['pertamax'], 0, "-", ",");
	    			$solar     = number_format($solar['solar'], 0, "-", ",");
	    			$uncat     = number_format($uncat['uncat'], 0, "-", ",");
	    			$total     = number_format($total['total'], 0, "-", ",");
	    			
					$content  .= 
					"<tr>				
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$no</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='left'>$plat</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$bensin</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$pertalite</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$pertamax</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$solar</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$uncat</td>						
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$total</td>
					</tr>";
					
					$terb = terbilang($biaya, $style=2);
					}
					$content .= "
					<tr>				
						<td colspan='2' style='border:0.5px solid #000; padding: 4px;' align='center'>Jumlah</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$t_bensin</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$t_pertalite</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$t_pertamax</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$t_solar</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$t_uncat</td>
						<td style='border:0.5px solid #000; padding: 4px;' align='center'>$t_total</td>				
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