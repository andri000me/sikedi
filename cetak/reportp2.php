<?h
session_start();
error_reorting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Jakarta");

include "../config/koneksi.h";
include "../config/fungsi_indotgl.h";
include "../config/fungsi_thumb.h";
include "../config/fungsiku.h";
include '../config/konfigurasi.h';

if (emty($_SESSION['dId'])){
	echo "<scrit>window.close();</scrit>";
}

else{
	require ("html2df/html2df.class.h");
	$filename="Form erbaikan Inventaris.df";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	$date_now = getTglIndo($now);

	$kd      = $_SESSION['dkode'];
    $kkb     = $_GET['kkb'];
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kkb'");
	$nmkabb  = strtouer("$nmkab");
	$nike  = getValue2("Ni","ms_egawai","kdkab='$kkb'","status='1'");
	$nitu   = getValue2("Ni","ms_egawai","kdkab='$kkb'","status='2");
	$niids = getValue2("Ni","ms_egawai","kdkab='$kkb'","status='3'");
	$keala  = strtouer(getValue("nama","ms_egawai","Ni='$nike'"));
	$tu      = strtouer(getValue("nama","ms_egawai","Ni='$nitu'"));
	$ids    = strtouer(getValue("nama","ms_egawai","Ni='$niids'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kkb'");

	$tiket = (emty($_GET['r']) ? "" : $_GET['r']);
	$rng = getData("*","erbaikan","Tiket='$tiket'");
	$user = getValue("user","erbaikan","Tiket='$tiket'");
	error_reorting(E_ALL ^ (E_NOTICE | E_WARNING));
	//$title = "$nbln $thn";
	$content = "
				<small>Tanggal rint : $date_now</small>
				<hr>
				<table border='0' style='margin:10x 50x 50x 50x;'>
					<tr valign='middle'>
						<td><img src='$_CONFIG[llogo]' height='$_CONFIG[sysrtheight]'></td>
						<td width='20'></td>
						<td>
							$_CONFIG[sysrtname]<br>
							<h3><b>$_CONFIG[sysowner]</b></h3>
							Alamat : $_CONFIG[sysaddress] - $_CONFIG[syscity] $_CONFIG[sysostal]<br>
							Tel. $_CONFIG[systel] | Fax. $_CONFIG[sysfax]	| Email : $_CONFIG[sysemail]
						</td>
					</tr>
				</table>
				<hr>
					<br>< align='center'><b><u>FORM BUKTI ERAWATAN INVENTARIS IT</u></b></>
					<table align='left'>
					<tr>
						<td>No.Tiket : <b>$tiket</b></td>
					</tr>
					<tr>
						<td>elaor : $user</td>
					</tr>
					</table>
				<br>

				<br>
				<table celladding=0 border='0' cellsacing='0' align='center'>
				<tr>
					<th align='center' width='220' style='border:1x solid #000; background-color: $_CONFIG[syscolor]; adding: 4x;'>Inventaris</th>
					<th align='center' width='220' style='border:1x solid #000; background-color: $_CONFIG[syscolor]; adding: 4x;'>Kerusakan</th>
					<th align='center' width='220' style='border:1x solid #000; background-color: $_CONFIG[syscolor]; adding: 4x;'>asca erbaikan</th>
				</tr>
				";
				$no = 0;
				$query = mysql_query("SELECT a.*,b.TglS,b.Kondisi,b.Ket FROM erbaikan a 
															LEFT JOIN serbaikan b ON a.Tiket=b.Tiket 
															WHERE $tterm AND $mterm");
				while ($d = mysql_fetch_array($query)){
				$brg = getData("*","barang","bInv='$d[Inv]'");
			    $tgl = getTglIndo($d['Tgl']);
			    $tgls = getTglIndo($d['TglS']);
			    $status = ($d['roses']=="1" ? "<b>roses</b>" : "Selesai");
			    $kondisi = ($d['Kondisi']=="1" ? "Baik" : "<b>Rusak</b>");

			    $tiket=$d[Inv];
      			$ruang = getValue("Ruang","enematan","Inv='$d[Inv]'");
	   			$nruang = getValue("rNama","ms_ruangan","rKode='$ruang'");
	    
	    		$kat = getValue("bjenis","barang","bkode='$d[Inv]'");
	    		$jenis = getValue("kNama","ms_kategori","kId='$kat'");
	   			$merek = getValue("bmerek","barang","bkode='$d[Inv]'");
	    		$nmerek = getValue("merek","ms_merek","rMerek='$merek'");
	    		$tie = getValue("btie","barang","bkode='$d[Inv]'");
	    		$ntie = getValue("tie","ms_tie","rTie='$tie'");
	   			$serial = getValue("bserial","barang","bkode='$d[Inv]'");
				$nama = getValue("uNama","user","uId='$d[user]'"); 

					$content .= 
					"<tr>
					    <td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
							Ruang : [$ruang] $nruang<br><font color='red'>$kat - $nmerek - $tie <br> Serial : $serial</font>
						</td>
						<td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
							Tanggal :  $tgl<br>
	      					elaor :  $nama<br>
      						Keluhan :  <font color='red'>$d[Kerusakan]</font>
      					</td>
						<td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
						    Tanggal :  $tgls<br>
					    	Kondisi :  $status<br>
					    	Sie JRS :  $d[J]<br>
				   	    	Aksi    :  <font color='green'>$d[Ket]</font><br>
				   	    </td>
					</tr>";
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
						<u><b>$_CONFIG[sysejabat]</b></u><br>
						$_CONFIG[sysniejabat]
					</td>
				</tr>
				</table>";
			
			
	// conversion HTML => DF
	try
	{
		$html2df = new HTML2DF('L','A5','fr', false, 'ISO-8859-15',array(10, 10, 10, 10)); //setting ukuran kertas dan margin ada dokumen anda
		// $html2df->setModeDebug();
		$html2df->setDefaultFont('Arial');
		$html2df->writeHTML($content, isset($_GET['vuehtml']));
		$html2df->Outut($filename);
	}
	catch(HTML2DF_excetion $e) { echo $e; }
}
?>