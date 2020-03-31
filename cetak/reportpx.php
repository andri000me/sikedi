<?php
session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=file_rk.xls");

include "../config/koneksi.php";
include "../config/fungsi_indotgl.php";
include "../config/fungsi_thumb.php";
include "../config/fungsiku.php";
include '../config/konfigurasi.php';


	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = getTglIndo($now);

	$kd      = $_SESSION['dpkode'];   
    $kk      = $_GET['r'];     
       
	$nosrt   = getValue("nosrt","administrasi","idkeg='$kk'");
	$nkeg    = strtoupper(getValue("keg","keg","kode='$kk'"));
	$tgl     = getValue("tgl","keg","kode='$kk'");
	$asal    = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$kd'"));
	$asal1   = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");
	$filename="Rekap Biodata Peserta no.$nosrt.pdf";
	echo "
				<table cellpadding=0 border='0' cellspacing='0' align='left'>
					<tr>
						<td align='left'>		
						<b>REKAP BIODATA PESERTA $nkeg</b></td>						
					</tr>				
				</table><br>

				<table cellpadding=0 border='0' cellspacing='0' align='left'>
								
					<tr>
						<td valign='left' width='200'>Tanggal Penyelenggaraan</td>	
						<td valign='left' width='10'>:</td>	
						<td valign='left'>$tgl</td>						
					</tr>					
					<tr>
						<td valign='left' width='200'>Kota Tempat Penyelenggaraan</td>	
						<td valign='left' width='10'>:</td>	
						<td valign='left'>Medan</td>						
					</tr>				
					<tr>
						<td valign='left' width='200'>Satuan Kerja</td>	
						<td valign='left' width='10'>:</td>	
						<td valign='left'>BPS $asal</td>				
					</tr>			
					
				</table><br>

				<table cellpadding=0 border='0.5' cellspacing='0' align='left'>
					<tr>
						<td align='center' width='30'>No</td>
						<td align='center'>Kab/Kot</td>						
						<td align='center' width='240'>Nama Pelaksana SPD</td>
						<td align='center' width='160'>NIP</td>
						<td align='center'>Golongan</td>
						<td align='center'>Jenis Kelamin</td>
						<td align='center'>Jabatan</td>
						<td align='center' width='120'>Asal</td>	
						<td align='center' width='100'>No. HP</td>
						<td align='center'>Merokok</td>
						<td align='center'>Kaos</td>
											
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
					</tr>";
					$no = 0;
					$query = mysql_query("SELECT * FROM alokasi WHERE idkeg='$kk' ORDER BY kdkab ASC");
					while ($d = mysql_fetch_array($query)){
					$no++;
					$nama    = getValue("nama","ms_pegawai","pNip='$d[idpeg]'");
					$gol     = getValue("gol","ms_pegawai","pNip='$d[idpeg]'");
					$ngol    = getValue("gol","_gol","id='$gol'");
					$kjab    = getValue("jb","ms_pegawai","pNip='$d[idpeg]'");
					$jab     = getValue("jb","_jabatan","id='$kjab'");
					$kdkab   = getValue("kdkab","ms_pegawai","pNip='$d[idpeg]'");
					$kep     = getValue2("pNip","ms_pegawai","kdkab='$kd'","status='1'");
					$nkep    = getValue("nama","ms_pegawai","pNip='$kep'");

					$jk      = getValue("jk","ms_pegawai","pNip='$d[idpeg]'");
					$njk     = getValue("jk","_jk","id='$jk'");
					$jb      = getValue("jb","ms_pegawai","pNip='$d[idpeg]'");
					$njb     = getValue("jb","_jabatan","id='$jb'");
					$lokasi  = getValue("lokasi","ms_pegawai","pNip='$d[idpeg]'");
					$hp      = getValue("hp","ms_pegawai","pNip='$d[idpeg]'");
					$rk      = getValue("rk","ms_pegawai","pNip='$d[idpeg]'");
					/*$nrk     = getValue("rk","_rk","id='$rk'");*/
					$kaos    = getValue("kaos","ms_pegawai","pNip='$d[idpeg]'");
					$nkaos   = getValue("rk","_kaos","id='$kaos'");
				
	echo "			
				<tr>
					<td align='center'>$no</td>						
					<td align='left'>$d[kdkab]</td>
					<td align='left'>$nama</td>
					<td align='center'>'$d[idpeg]'</td>
					<td align='center'>$ngol</td>
					<td align='center'>$njk</td>		
					<td align='center'>$njb</td>		
					<td align='left'>$lokasi</td>		
					<td align='left'>'$hp'</td>					
					<td align='center'>$rk</td>		
					<td align='center'>$nkaos</td>		
				</tr>";
				}
							
	echo "
				</table><br>
				<table cellpadding=0 border='0' cellspacing='0' align='center'>	
					<tr>					
						<td align='left'>$ikota, $date_now<br>
						Kepala BPS $asal1,<br><br><br><br>$nkep<br>NIP. $kep</td>				
					</tr>				
				</table>";			
			
