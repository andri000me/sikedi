<?php
$kd=$_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$thn = (empty($_GET['thn']) ? "" : $_GET['thn']);
$tterm = (empty($_GET['thn']) ? "1" : "YEAR(bTgl)='$thn'");
$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
$mterm = (empty($_GET['bln']) ? "1" : "MONTH(bTgl)='$bln'");
?>
<div class="row-fluid">
	<div class="span12">
	<div class="page-header">
		<h1>REKAPITULASI</h1>
	</div>
	<?php
	if ($ulevel=='0') {
	echo "	
	<a href='?page=$page&act=tambah' class='btn btn-primary'>
		<i class='icon-download-alt bigger-100'></i>Tambah
	</a><br><br>";
	} else {
	echo " ";
	}
	if ($kd=='1200') {
		echo "
		<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='rekap'>			
			<select class='span3' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";
				$qsp = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
				while ($s=mysql_fetch_array($qsp)) {
					echo "<option value='$s[id_kabkot]'>$s[nama_kabkot]</option>";
				}
			echo "
			</select>
			<button type='submit' class='btn btn-primary btn-small'>
				Filter
				<i class='icon-search icon-on-right bigger-110'></i>
			</button>
			<a href='?page=minv' type='button' class='btn btn-primary btn-small'>
				Reset
				<i class='icon-refresh icon-on-right bigger-110'></i>
			</a>
		</form>";
		$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$_GET[kkb]'"));
		echo "
		<div class='table-header'>
		   REKAPITULASI KENDERAAN DINAS BPS $nmkab MENURUT TIPE"; 
		echo "
		</div>
		<div class='row-fluid'>
		<table id='myTable' class='table table-striped table-bordered table-hover'>
		<thead>
		    <tr>
		    <th class='center' width='30px'>No</th>
		    <th class='center' width='120'>Jenis</th>
		    <th class='center' width='120'>Merek</th>
		    <th class='center' width='120'>Tipe</th>
		    <th class='center' width='70'>Total</th>
		    <th class='center' width='70'>Baik</th>
		    <th class='center' width='70'>Rusak Ringan</th>
		    <th class='center' width='70'>Rusak Berat</th>		    
		    </tr>
		</thead>
		<tbody>";
		    $qry = mysql_query("SELECT DISTINCT bjenis, bmerek, btipe FROM kendi WHERE kdkab='$_GET[kkb]' ORDER BY bjenis");
			while ($d = mysql_fetch_array($qry)){
		      $no++;
		      $jtotal = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]' AND $tterm AND $mterm");
		      $jbaik = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]' AND bkondisi='1' AND $tterm AND $mterm");
		      $jrusakr = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]' AND bkondisi='2' AND $tterm AND $mterm");
		      $jrusakb = getJumlah("SELECT bId FROM kendi WHERE kdkab='$_GET[kkb]' AND btipe='$d[btipe]' AND bkondisi='3' AND $tterm AND $mterm");		     
		      
			  $jttersedia = $jtotal-$jterpakai-$jpinjam;
			  $jen = getValue("jenis","kendi_jen","id='$d[bjenis]'");
			  $merek = getValue("merek","kendi_merk","id='$d[bmerek]'");
			  $tipe = getValue("tipe","kendi_tipe","id='$d[btipe]'");

			  if ($jtotal  =='0') {
		      	  $rjtotal ='-';
		      	} else {
		      	  $rjtotal =$jtotal;
		      	}
		    if ($jbaik  =='0') {
		      	  $rjbaik ='-';
		      	} else {
		      	  $rjbaik =$jbaik;
		      	}	

		    if ($jrusakr  =='0') {
		      	  $rjrusakr ='-';
		      	} else {
		      	  $rjrusakr =$jrusakr;
		      	}	

		    if ($jrusakb  =='0') {
		      	  $rjrusakb ='-';
		      	} else {
		      	  $rjrusakb =$jrusakb;
		      	}		
		      	
		      echo "
		      <tr>
		      <td class='center'>$no</td>
		      <td class='left'>$jen</td>
		      <td class='left'>$merek</td>
		      <td class='left'>$tipe</td>
		      <td class='center'>$rjtotal</td>
		      <td class='center'>$rjbaik</td>
		      <td class='center'>$rjrusakr</td>
		      <td class='center'>$rjrusakb</td>			 
			   </tr>";
		   }
		} else {
			
		echo "
		<div class='table-header'>";
		$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$kd'"));
		echo "
		   REKAPITULASI KENDERAAN DINAS BPS $nmkab MENURUT TIPE"; 
		echo "
		</div>
		<div class='row-fluid'>
		<table id='myTable' class='table table-striped table-bordered table-hover'>
		<thead>
		    <tr>
		    <th class='center' width='30px'>No</th>
		    <th class='center' width='120'>Jenis</th>
		    <th class='center' width='120'>Merek</th>
		    <th class='center' width='120'>Tipe</th>
		    <th class='center' width='70'>Total</th>
		    <th class='center' width='70'>Baik</th>
		    <th class='center' width='70'>Rusak Ringan</th>
		    <th class='center' width='70'>Rusak Berat</th>	
		    </tr>
		</thead>
		<tbody>";
		    $qry = mysql_query("SELECT DISTINCT bjenis, bmerek, btipe FROM kendi WHERE kdkab='$kd' ORDER BY bjenis");
			while ($d = mysql_fetch_array($qry)){
		      $no++;
		      $jtotal = getJumlah("SELECT bId FROM kendi WHERE kdkab='$kd' AND btipe='$d[btipe]' AND $tterm AND $mterm");
		      $jbaik = getJumlah("SELECT bId FROM kendi WHERE kdkab='$kd' AND btipe='$d[btipe]' AND bkondisi='1' AND $tterm AND $mterm");
		      $jrusakr = getJumlah("SELECT bId FROM kendi WHERE kdkab='$kd' AND btipe='$d[btipe]' AND bkondisi='2' AND $tterm AND $mterm");
		      $jrusakb = getJumlah("SELECT bId FROM kendi WHERE kdkab='$kd' AND btipe='$d[btipe]' AND bkondisi='3' AND $tterm AND $mterm");

		    if ($jtotal  =='0') {
		      	  $rjtotal ='-';
		      	} else {
		      	  $rjtotal =$jtotal;
		      	}
		    if ($jbaik  =='0') {
		      	  $rjbaik ='-';
		      	} else {
		      	  $rjbaik =$jbaik;
		      	}	

		    if ($jrusakr  =='0') {
		      	  $rjrusakr ='-';
		      	} else {
		      	  $rjrusakr =$jrusakr;
		      	}	

		    if ($jrusakb  =='0') {
		      	  $rjrusakb ='-';
		      	} else {
		      	  $rjrusakb =$jrusakb;
		      	}		
		      
			  $jttersedia = $jtotal-$jterpakai-$jpinjam;
			  $jen   = getValue("jenis","kendi_jen","id='$d[bjenis]'");
			  $merek = getValue("merek","kendi_merk","id='$d[bmerek]'");
			  $tipe  = getValue("tipe","kendi_tipe","id='$d[btipe]'");
			  $jttersedia = $jtotal-$jterpakai-$jpinjam;
		      echo "
		      <tr>
		      <td class='center'>$no</td>
		      <td class='left'>$jen</td>
		      <td class='left'>$merek</td>
		      <td class='left'>$tipe</td>
		      <td class='center'>$rjtotal</td>
		      <td class='center'>$rjbaik</td>
		      <td class='center'>$rjrusakr</td>
		      <td class='center'>$rjrusakb</td>		 
			  </tr>";

		}
	}
		 ?>
		
		</tbody>
		</table>
		</div>
	</div>
</div>