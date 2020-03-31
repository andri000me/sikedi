<?h
session_start();
error_reorting(E_ALL ^ (E_NOTICE | E_WARNING));
date_default_timezone_set("Asia/Makassar");

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
	
	$thn = (emty($_GET['thn']) ? "" : $_GET['thn']);
	$tterm = (emty($_GET['thn']) ? "1" : "YEAR(a.Tgl)='$thn'");
	$bln = (emty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (emty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (emty($_GET['bln']) ? "1" : "MONTH(a.Tgl)='$bln'");

	$tiket = (emty($_GET['r']) ? "" : $_GET['r']);
	$rng = getData("*","erbaikan","Tiket='$tiket'");
	$user = getValue("user","erbaikan","Tiket='$tiket'");

	$title = "$nbln $thn";
	$content = "
				<table border='0' style='margin:10x 50x 50x 50x;'>
					<tr valign='middle'>
						<td><img src='$_CONFIG[llogo]' height='50'></td>
						<td width='20'></td>
						<td>
							<b>$_CONFIG[sysrtname]</b><br>
							<b>$_CONFIG[syscoyright]</b> - Alamat : $_CONFIG[sysaddress] - $_CONFIG[syscity] $_CONFIG[sysostal]<br>
							Tel. $_CONFIG[systel] | Fax. $_CONFIG[sysfax]	| Email : $_CONFIG[sysemail]
						</td>
					</tr>
				</table>
				<hr>
					< align='center'><b><u>FORM BUKTI ERAWATAN INVENTARIS IT</u></b></>
					<table align='left'>
					<tr>
						<td>No.Tiket : <b>$tiket</b></td>
					</tr>
					</table>
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
															LEFT JOIN serbaikan b ON a.Tiket=b.Tiket WHERE a.Tiket='$tiket'");
				while ($d = mysql_fetch_array($query)){
				$no++;
				$brg = getData("*","barang","bInv='$tiket'");
			    $tgl = getTglIndo($d['Tgl']);
			    $tgls = getTglIndo($d['TglS']);
			    $status = ($d['roses']=="1" ? "<b>roses</b>" : "Selesai");
			    $kondisi = ($d['Kondisi']=="1" ? "Baik" : "<b>Rusak</b>");
			    $date_now = getTglIndo($d[TglS]);
			    $date_re = getTglIndo($d[Tgl]);

			    $tiket=$d[Inv];
      			$ruang = getValue("Ruang","enematan","inv='$d[Inv]'");
	   			$nruang = getValue("rNama","ms_ruangan","idruang='$ruang'");
	   			$lantai = getValue("rJenis","ms_ruangan","idruang='$ruang'");
	    
	    		$kat = getValue("bjenis","barang","bkode='$d[Inv]'");
	    		$jenis = getValue("kNama","ms_kategori","kId='$kat'");
	   			$merek = getValue("bmerek","barang","bkode='$d[Inv]'");
	    		$nmerek = getValue("merek","ms_merek","rMerek='$merek'");
	    		$tie = getValue("btie","barang","bkode='$d[Inv]'");
	    		$ntie = getValue("tie","ms_tie","rTie='$tie'");
	   			$serial = getValue("bserial","barang","bkode='$d[Inv]'");
				//$nama = getValue("uNama","user","uId='$d[user]'");
				$nama = getValue("uNama","user","uId='$d[user]'");
				//$jnama = getValue("uNama","user","j='$d[J]'");  
				$jni = getValue("uId","user","uNama='$d[J]'"); 

			    $asca = "";
			      if (!emty($d['TglS'])){
			      	$asca = "Tanggal : $tgls<br>
							  Kondisi : $kondisi
							  $d[Ket]";
			      }
					$content .= 
					"<tr>
						 <td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
							Ruang : $nruang [$ruang]<br>Lantai : $lantai<br><font color='blue'>Jenis : $jenis <br> Merek : $nmerek <br> Tie : $ntie <br> sn : <b>$serial</b></font>
						</td>
						<td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
							Laor Tgl : $date_re<br>
							elaor   : <br><b>$nama</b><br>
	      					Keluhan   : <i><font color='red'>$d[Kerusakan]</font></i>
      					</td>
						<td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
						    Selesai Tgl   :  $date_now<br>
					    	Kondisi Akhir :  <b>$kondisi<br></b>
					    	Sie JRS       :  <br>$d[J]<br>
				   	    	Hasil erbaikan :  <i><font color='green'>$d[Ket]</font></i>
				   	    </td>
					</tr>";
							
				$content .= "
				</table>
				<br><br>

				<table>
				<tr>
					<td style='border:1x solid #A9A9A9; adding: 4x;' width='158' align='center'>
						emilik Barang :
						<br><br><br><br>								
						<b>$nama</b>
					</td>
					<td style='border:1x solid #A9A9A9; adding: 4x;' width='158' align='center'>
						erbaikan Rekanan:
						<br><br><br><br>								
						<b>Suwarto</b>
					</td>
					<td style='border:1x solid #A9A9A9; adding: 4x;' width='158' align='center'>
						Identifikasi Urdal :
						<br><br><br><br>								
						<b>Helmi</b>
					</td>
					<td style='border:1x solid #A9A9A9; adding: 4x;' width='158' align='center'>
						Identifikasi JRS:
						<br><br><br><br>								
						<b>Oliver Simarmata</b>
					</td>
				</tr>

				</table>";
			}
			
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