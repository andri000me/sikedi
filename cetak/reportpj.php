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
	$filename="Form eminjaman Inventaris.df";
	$content = ob_get_clean();
	$year = date('Y');
	$month = date('m');
	$date = date('d');
	$now = date('Y-m-d');
	
	$kd      = $_SESSION['dkode'];
    $kkb     = $_GET['kkb'];
	$nmkab   = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	$nmkabb  = strtouer("$nmkab");
	$nike  = getValue2("Ni","ms_egawai","kdkab='$kd'","status='1'");
	$nitu   = getValue2("Ni","ms_egawai","kdkab='$kd'","status='2");
	$niids = getValue2("Ni","ms_egawai","kdkab='$kd'","status='3'");
	$keala  = strtouer(getValue("nama","ms_egawai","Ni='$nike'"));
	$tu      = strtouer(getValue("nama","ms_egawai","Ni='$nitu'"));
	$ids    = strtouer(getValue("nama","ms_egawai","Ni='$niids'"));
	$ikota   = getValue("ibukota","kdkab","id_kabkot='$kd'");

	$thn = (emty($_GET['thn']) ? "" : $_GET['thn']);
	$tterm = (emty($_GET['thn']) ? "1" : "YEAR(a.Tgl)='$thn'");
	$bln = (emty($_GET['bln']) ? "" : $_GET['bln']);
	$nbln = (emty($_GET['bln']) ? "" : getBulan($_GET['bln']));
	$mterm = (emty($_GET['bln']) ? "1" : "MONTH(a.Tgl)='$bln'");

	$tiket = (emty($_GET['']) ? "" : $_GET['']);
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
					< align='center'><b><u>FORM BUKTI EMINJAMAN INVENTARIS IT BS $nmkabb</u></b></>
					<table align='left'>
					<tr>
						<td>No.Tiket : <b>$tiket</b></td>
					</tr>
					</table>
				<br>

				<table celladding=0 border='0' cellsacing='0' align='center'>
				<tr>
					<th align='center' width='220' style='border:1x solid #000; background-color: $_CONFIG[syscolor]; adding: 4x;'>Inventaris</th>
					<th align='center' width='220' style='border:1x solid #000; background-color: $_CONFIG[syscolor]; adding: 4x;'>eminjaman</th>
					<th align='center' width='220' style='border:1x solid #000; background-color: $_CONFIG[syscolor]; adding: 4x;'>engembalian</th>
				</tr>
				";
				$no = 0;
				$query = mysql_query("SELECT a.*,b.tglk,b.Kondisi,b.catatan FROM injam a 
															LEFT JOIN sinjam b ON a.kode=b.Tiket WHERE a.kode='$tiket'");
				while ($d = mysql_fetch_array($query)){
				$no++;
				$brg = getData("*","barang","bInv='$tiket'");
			    $tgl = getTglIndo($d['Tgl']);
			    $tgls = getTglIndo($d['TglS']);
			    $status = ($d['roses']=="1" ? "<b>roses</b>" : "Selesai");
			    $kondisi = ($d['Kondisi']=="1" ? "Baik" : "<b>Rusak</b>");
			    $tglk = getTglIndo($d[tglk]);
			    $tgl = getTglIndo($d[tgl]);
			    $rtglk = getTglIndo($d[rtglk]);

			    $kat = getValue("bjenis","barang","bkode='$d[id_inv]'");
	    		$jenis = getValue("kNama","ms_kategori","kId='$kat'");
	   			$merek = getValue("bmerek","barang","bkode='$d[id_inv]'");
	    		$nmerek = getValue("merek","ms_merek","rMerek='$merek'");
	    		$tie = getValue("btie","barang","bkode='$d[id_inv]'");
	    		$ntie = getValue("tie","ms_tie","rTie='$tie'");
	   			$serial = getValue("bserial","barang","bkode='$d[id_inv]'");
				//$nama = getValue("uNama","user","uId='$d[user]'");
				$ni = getValue("uId","user","uNama='$d[user]'");
				//$jnama = getValue("uNama","user","j='$d[J]'");  
				$jni = getValue("uId","user","uNama='$d[J]'"); 

				$ij  = strtouer(getValue("nama","ms_egawai","Ni='$d[J]'"));
				$mj  = strtouer(getValue("nama","ms_egawai","Ni='$d[eminjam]'"));
				$km  = strtouer(getValue("nama","ms_egawai","Ni='$d[Jk]'"));

			    $asca = "";
			      if (!emty($d['tglk'])){
			      	$asca = "Tanggal : $tglk<br>
							  Kondisi : $Kondisi
							  $d[catatan]";
			      }
					$content .= 
					"<tr>
						 <td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
							Ruang : <font color='blue'>Jenis : $jenis <br> Merek : $nmerek <br> Tie : $ntie <br> sn : <b>$serial</b></font>
						</td>
						<td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
							injam Tgl 		: $tgl<br>
							eminjam  	    : <b>$mj</b><br>
							Yang meminjamkan: $ij<br>
	      					Keerluan       : <i><font color='red'>$d[keterangan]</font></i>
      					</td>
						<td style='border:1x solid #000; adding: 4x;' width='220' align='left'>
						    Kembali Tgl     :  $tglk<br>
					    	Kondisi 	    :  <b>$kondisi<br></b>
					    	Yang menerima   :  <br>$km<br>
				   	    	Catatan         :  <i><font color='green'>$d[catatan]</font></i>
				   	    </td>
					</tr>";
							
				$content .= "
				</table>
				<br><br>

				<table>
				<tr>
					<td style='border:1x solid #A9A9A9; adding: 4x;' width='218' align='center'>
						Yang Meminjamkan:
						<br><br><br><br>								
						<b>$ij</b>
					</td>
					<td style='border:1x solid #A9A9A9; adding: 4x;' width='218' align='center'>
						eminjam:
						<br><br><br><br>								
						<b>$mj</b>
					</td>
					<td style='border:1x solid #A9A9A9; adding: 4x;' width='218' align='center'>
						Yang Menerima:
						<br><br><br><br>								
						<b>$km</b>
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