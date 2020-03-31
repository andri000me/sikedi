<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$j = $_GET['j'];
$m = $_GET['m'];
$t = $_GET['t'];
$d = $_GET['kd'];
$page = "page=".$_GET['page']."&j=$j&m=$m&t=$t";
$btnfback = "media.php?page=inv";

$dt = getData("*,COUNT(bId) AS bJlh","barang","btipe='$t' GROUP BY bId");
?>
<div class="page-header">
	<div class="alert alert-info">
	<?php
	 	  $kat = getValue("kNama","ms_kategori","kId='$j'");
	      $merek = getValue("merek","ms_merek","rMerek='$m'");
	      $tipe = getValue("tipe","ms_tipe","rTipe='$t'");
	      $spek = getValue("spek","ms_tipe","rTipe='$t'");
	      $img = getValue("image","barang","btipe='$t'");
	      $asal = getValue("jNama","_jpengadaan","jId='$d[basal]'");	      
	?>
		<b>Jenis Barang : </b><?php echo $kat;?> - 	
		<b>Merek : </b><?php echo $merek;?> - 
		<b>Tipe : </b><?php echo $tipe;?><br><br> 
		
	</div>
</div>
<div class="row-fluid">
<div class="span12">
	<a href='<?php echo $btnfback?>' class='btn pull-right'>
		<i class='icon-reply bigger-100'></i>Kembali
	</a>
	
	<?php
		if ($_GET['mode']=="hapus"){
			mysql_query("DELETE FROM barang WHERE bId='$_GET[did]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?$page\"', 1000)
				   </script>";
		}
	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$d'"));
	echo "
	<div class='table-header'>
	   INVENTARIS BPS $nmkab; ";?>
	</div>
	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="30px">No</th>
	    <th class="center" width="60px">No.Inventaris</th>
	    <th class="center">Lokasi</th>
	    <th class="center">No Seri</th>
	    <th class="center">Pemegang</th>
	    <th class="center">Kondisi</th>
	    <th class="center sorting_disabled" width="50px">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	 	if (!empty($d)) {
        $qrt = "SELECT a.*,b.pRuang FROM barang a
	 			  LEFT JOIN penempatan b ON a.bkode=b.pInv
	 			  WHERE a.bjenis='$j'and a.bmerek='$m' and a.btipe='$t' and a.kdkab='$d'";
	 	} else {
	 	$qrt = "SELECT a.*,b.pRuang FROM barang a
	 			  LEFT JOIN penempatan b ON a.bkode=b.pInv
	 			  WHERE a.bjenis='$j'and a.bmerek='$m' and a.btipe='$t'";	
	 	}

	    $qry = mysql_query($qrt);
		while ($d = mysql_fetch_array($qry)){
		  $nruang = getValue("rNama","ms_ruangan","idruang='$d[pRuang]'");
		  $lantai = getValue("rJenis","ms_ruangan","rKode='$d[pRuang]'");
		  $kat = getValue("kNama","ms_kategori","kId='$d[bjenis]'");
	      $merek = getValue("merek","ms_merek","rMerek='$d[bmerek]'");
	      $tipe = getValue("tipe","ms_tipe","rTipe='$d[btipe]'");
	      $pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");

	      $no++;
	      $lokasi = ($d['pRuang']=="" ? "<span class='badge badge-success'>Tersedia</span>" : "$d[pRuang]" );

	     // $status = ($d['bkondisi']=="1" ? "<span class='badge badge-success'>Baik</span>" : "<span class='badge badge-important'>Rusak</span>");

	      

	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='center'>$d[bkode]</td>
	      <td class='left'>$nruang</td>
	      <td class='left'>$d[bserial]</td>
	      <td class='left'>$pemegang</td>
	      <td class='center'>";
	      if ($d['bkondisi'] =='1') {
			echo "<span class='badge badge-success'>Baik</span>";	
	    	} else if ($d['bkondisi'] =='2') {
			echo "<span class='badge badge-warning'>Rusak Ringan</span>";
			} else {
			echo "<span class='badge badge-important'>Rusak Berat</span>";
			}
			echo "
			</td>
	       <td class='center'>";
	       if ($kd!=$d['kdkab']) {
                  	echo "
                    ---";
                } else {
                echo "
         	<a href='?$page&mode=hapus&did=$d[btipe]' class='tooltip-primary' onclick='return qh();' data-rel='tooltip' data-original-title='Hapus Inventaris'>
            <span class='red'><i class='icon-trash bigger-120'></i></span>
            </a>
		   </td>
		   </tr>";
	   }
	}
	   ?>
	</tbody>
	</table>
	</div>
</div>
</div>