<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");


header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_daya_jasa_".$_GET['bln']."_".$_GET['thn'].".xls ");

include "../config/koneksi.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_thumb.php";
include "../config/fungsiku.php";
include '../config/konfigurasi.php';

if (empty($_SESSION['dpId'])){
	echo "<script>window.close();</script>";
}


	
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	
	$kd     = $_SESSION['dpkode'];   
    $t      = $_GET['thn'];     
    $bl      = $_GET['bln']; 

	$nmbln = getBulan($bl);
   	
	echo "
				<table cellpadding=0 border='0' cellspacing='0' align='left'>
					<tr>
						<td colspan='16' align='left'>		
						<b>REALISASI DAYA JASA DAN INTERNET TAHUN $t</b></td>						
					</tr>				
				</table><br>

				<table cellpadding=0 border='0' cellspacing='0' align='left'>
					<tr>
						<td valign='left' width='200' colspan='2'>PROVINSI</td>	
						<td valign='left' width='10' colspan='4'>: SUMATERA UTARA</td>										
					</tr>					
					<tr>
						<td valign='left' width='200' colspan='2'>BULAN</td>	
						<td valign='left' width='10' colspan='4'>: $nmbln</td>							
					</tr>		
				</table><br>

				<table cellpadding=0 border='1' cellspacing='0' align='left'>
					<tr>
					<td align='center' widtd='20px' rowspan='3'>No</td>
	   				<td align='center' widtd='200px' rowspan='3'>Provinsi/Kabupaten/Kota</td>
	    			<td align='center' widtd='100px' colspan='7'>Daya dan Jasa</td>
	    			<td align='center' widtd='100px' rowspan='3'>Total (Rp)</td>
	   			 	<td align='center' widtd='200px' rowspan='2' colspan='2'>Internet</td>
	    			<td align='center' widtd='100px' rowspan='2' colspan='2'>Premium</td>
	    			<td align='center' widtd='100px' rowspan='2' colspan='2'>Pertalite</td>
	    			<td align='center' widtd='100px' rowspan='2' colspan='2'>Pertamax</td>
	   				<td align='center' widtd='100px' rowspan='2' colspan='2'>Solar</td>
	   				<td align='center' widtd='100px' rowspan='2' colspan='2'>Total (Rp)</td>
	    			<td align='center' widtd='50px' rowspan='3'>Keterangan</td>	    			
	   				</tr>
	    			<tr>
	    			<td align='center' colspan='3'>Listrik</td>
	    			<td align='center' colspan='2'>Telepon</td>
	    			<td align='center' colspan='2'>Air</td>	   
	    			</tr>
	    			<tr>
	    			<td align='center'>Kva</td>
	    			<td align='center'>Kwh</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Sambungan</td>
	    			<td align='center'>m3</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Nama Layanan</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Liter</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Liter</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Liter</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Liter</td>
	    			<td align='center'>Rp</td>
	    			<td align='center'>Liter</td>
	    			<td align='center'>Rp</td>	    
	    			</tr>
					<tr>
						<td align='center'>[1]</td>						
						<td align='center'>[2]</td>
						<td align='center'>[3]</td>
						<td align='center'>[4]</td>
						<td align='center'>[5]</td>
						<td align='center'>[6]</td>
						<td align='center'>[7]</td>
						<td align='center'>[8]</td>
						<td align='center'>[9]</td>
						<td align='center'>[10]</td>
						<td align='center'>[11]</td>
						<td align='center'>[12]</td>
						<td align='center'>[13]</td>
						<td align='center'>[14]</td>
						<td align='center'>[15]</td>
						<td align='center'>[16]</td>
						<td align='center'>[17]</td>
						<td align='center'>[18]</td>
						<td align='center'>[19]</td>
						<td align='center'>[20]</td>
						<td align='center'>[21]</td>
						<td align='center'>[22]</td>
						<td align='center'>[23]</td>											
					</tr>";
					
		$no=0;
		if ($kd==1200) {
		$qry = mysql_query("SELECT * FROM dayajasa WHERE thn='$_GET[thn]' AND bln='$_GET[bln]' ORDER BY kdkab ASC");
	} else {
		$qry = mysql_query("SELECT * FROM dayajasa WHERE kdkab='$kd' AND thn='$_GET[thn]' AND bln='$_GET[bln]'");
	}
		while ($d = mysql_fetch_array($qry)){
		$no++;
		
		$l1 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jbensin FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='1' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$jbensin  = $l1['jbensin'];
		$tjbensin  ==0;
		$tjbensin  +=$jbensin;
		$ntjbensin = number_format ($tjbensin, 0, ',', ',');
		$njbensin = number_format ($jbensin, 0, ',', ',');

		$l2 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jpertalite FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='2' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$jpertalite  = $l2['jpertalite'];
		$tjpertalite  ==0;
		$tjpertalite  +=$jpertalite;
		$ntjpertalite = number_format ($tjpertalite, 0, ',', ',');
		$njpertalite = number_format ($jpertalite, 0, ',', ',');

		$l3 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jpertamax FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='3' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$jpertamax  = $l3['jpertamax'];
		$tjpertamax  ==0;
		$tjpertamax  +=$jpertamax;
		$ntjpertamax = number_format ($tjpertamax, 0, ',', ',');
		$njpertamax = number_format ($jpertamax, 0, ',', ',');

		$l4 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jsolar FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='4' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$jsolar  = $l4['jsolar'];
		$tjsolar  ==0;
		$tjsolar  +=$jsolar;
		$ntjsolar = number_format ($tjsolar, 0, ',', ',');
		$njsolar = number_format ($jsolar, 0, ',', ',');



		$t1 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as bensin FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='1' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$bensin  = $t1['bensin'];
		$nbensin = number_format ($bensin, 0, ',', ',');
		$tbensin  ==0;
		$tbensin  +=$bensin;
		$ntbensin = number_format ($tbensin, 0, ',', ',');

		$t2 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertalite FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='2' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$pertalite  = $t2['pertalite'];
		$npertalite = number_format ($pertalite, 0, ',', ',');
		$tpertalite  ==0;
		$tpertalite  +=$pertalite;
		$ntpertalite = number_format ($tpertalite, 0, ',', ',');

		$t3 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertamax FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='3' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$pertamax  = $t3['pertamax'];
		$npertamax = number_format ($pertamax, 0, ',', ',');
		$tpertamax  ==0;
		$tpertamax  +=$pertamax;
		$ntpertamax = number_format ($tpertamax, 0, ',', ',');

		$t4 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as solar FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='4' AND MONTH(tglrep)='$d[bln]' AND YEAR(tglrep)='$d[thn]'"));
		$solar  = $t4['solar'];
		$nsolar = number_format ($solar, 0, ',', ',');
		$tsolar  ==0;
		$tsolar  +=$solar;
		$ntsolar = number_format ($tsolar, 0, ',', ',');

		$tot_l  = $jbensin+$jpertalite+$jpertamax+$jsolar;
		$ntot_l = number_format ($tot_l, 0, ',', ',');
		$ttot_l  ==0;
		$ttot_l  +=$tot_l;
		$nttot_l = number_format ($ttot_l, 0, ',', ',');

		$tot_rp  = $bensin+$pertalite+$pertamax+$solar;
		$ntot_rp = number_format ($tot_rp, 0, ',', ',');
		$ttot_rp  ==0;
		$ttot_rp  +=$tot_rp;
		$nttot_rp = number_format ($ttot_rp, 0, ',', ',');

	   	$nmkab    = getValue("nama_kabkot","kdkab","id_kabkot='$d[kdkab]'");
	   	$lis_kva  = $d[lis_kva];
	   	$lis_kwh  = $d[lis_kwh];
	   	$lis_rp   = $d[lis_rp];
	   	$tel_rp   = $d[tel_rp];
	   	$tel_sat  = $d[tel_sat];
	   	$air_m3   = $d[air_m3];
	   	$air_rp   = $d[air_rp];
	   	$int_nama = $d[int_nama];
	   	$int_rp   = $d[int_rp];

	    $nlis_kva  = number_format ($lis_kva, 0, ',', ',');
	   	$nlis_kwh  = number_format ($lis_kwh, 0, ',', ',');
	   	$nlis_rp   = number_format ($lis_rp, 0, ',', ',');
	   	$ntel_rp   = number_format ($tel_rp, 0, ',', ',');
	   	$ntel_sat  = number_format ($tel_sat, 0, ',', ',');
	   	$nair_m3   = number_format ($air_m3, 0, ',', ',');
	   	$nair_rp   = number_format ($air_rp, 0, ',', ',');	  
	   	$nint_rp   = number_format ($int_rp, 0, ',', ',');     

	   	$tlis_kva  ==0;
	   	$tlis_kva  +=$d[lis_kva];
		$ntlis_kva  = number_format ($tlis_kva, 0, ',', ',');

		$tlis_kwh  ==0;
	   	$tlis_kwh  +=$d[lis_kwh];
		$ntlis_kwh  = number_format ($tlis_kwh, 0, ',', ',');

		$tlis_rp  ==0;
	   	$tlis_rp  +=$d[lis_rp];
		$ntlis_rp  = number_format ($tlis_rp, 0, ',', ',');

		$ttel_rp  ==0;
	   	$ttel_rp  +=$d[tel_rp];
		$nttel_rp  = number_format ($ttel_rp, 0, ',', ',');

		$ttel_sat  ==0;
	   	$ttel_sat  +=$d[tel_sat];
		$nttel_sat  = number_format ($ttel_sat, 0, ',', ',');

		$tair_m3  ==0;
	   	$tair_m3  +=$d[air_m3];
		$ntair_m3  = number_format ($tair_m3, 0, ',', ',');

		$tair_rp  ==0;
	   	$tair_rp  +=$d[air_rp];
		$ntair_rp  = number_format ($tair_rp, 0, ',', ',');

		$tint_rp  ==0;
	   	$tint_rp  +=$d[int_rp];
		$ntint_rp  = number_format ($tint_rp, 0, ',', ',');

  
	  	$tot_dayajasa   = $lis_rp + $air_rp + $tel_rp;
     	$ntot_dayajasa  = number_format ($tot_dayajasa, 0, ',', ',');
		
		$ttot_dayajasa  +=$tot_dayajasa;
		$nttot_dayajasa  = number_format ($ttot_dayajasa, 0, ',', ',');

	echo "<tr>
		  <td class='center'>$no</td>
	      <td class='left'>$nmkab</td>	      
	      <td class='center'>$nlis_kva</td>
	      <td class='center'>$nlis_kwh</td>	     
	      <td class='center'>$nlis_rp</td>     
	      <td class='center'>$ntel_rp</td>
	      <td class='center'>$ntel_sat</td>
	      <td class='center'>$nair_m3</td>	      
	      <td class='center'>$nair_rp</td>
	      <td class='center'>$ntot_dayajasa</td>
	      <td class='left'>$int_nama</td>
	      <td class='center'>$nint_rp</td>

	       <td class='center'>$njbensin</td>
	      <td class='center'>$nbensin</td>
	      <td class='center'>$njpertalite</td>
	      <td class='center'>$npertalite</td>
	      <td class='center'>$njpertamax</td>
	      <td class='center'>$npertamax</td>
	      <td class='center'>$nsolar</td>
	      <td class='center'>$njsolar</td>
	      <td class='center'>$ntot_l</td>
	      <td class='center'>$ntot_rp</td>
	      <td class='center'></td>			
		  </tr>";	
			}	
			
	echo "<tr>
		  <td class='center' colspan='2'>T o t a l</td>	      
	      <td class='center'>$ntlis_kva</td>
	      <td class='center'>$ntlis_kwh</td>	     
	      <td class='center'>$ntlis_rp</td>     
	      <td class='center'>$nttel_rp</td>
	      <td class='center'>$nttel_sat</td>
	      <td class='center'>$ntair_m3</td>	      
	      <td class='center'>$ntair_rp</td>
	      <td class='center'>$nttot_dayajasa</td>
	      <td class='left'></td>
	      <td class='center'>$ntint_rp</td>

	      <td class='center'>$ntjbensin</td>
	      <td class='center'>$ntbensin</td>
	      <td class='center'>$ntjpertalite</td>
	      <td class='center'>$ntpertalite</td>
	      <td class='center'>$ntjpertamax</td>
	      <td class='center'>$ntpertamax</td>
	      <td class='center'>$ntjsolar</td>
	      <td class='center'>$ntsolar</td>
	      <td class='center'>$nttot_l</td>
	      <td class='center'>$nttot_rp</td>
	      <td class='center'></td>			
		  </tr>		  
    </table><br>";	
    			

?>