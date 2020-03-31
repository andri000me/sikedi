<?php
$kd=$_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$rid = $_GET['id'];
$page = "page=".$_GET['page']."&id=$rid";
$btnfback = "media.php?page=pinv";

$ru = getData("*","ms_ruangan","rKode='$rid'");
$rj = getValue("jNama","_jruangan","jId='$ru[rJenis]'");
?>

<a href='<?php echo $btnfback?>' class='btn pull-right'>
	<i class='icon-reply bigger-100'></i>Kembali
</a>
<br><br><br>
<div class="row-fluid">
<div class="span7">
	<?php
		if ($_GET['mode']=="hapus"){
			mysql_query("DELETE FROM penempatan WHERE pInv='$_GET[did]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?$page\"', 500)
				   </script>";
		}
	?>
	<div class="table-header">
	   INVENTARIS RUANGAN <?php echo $rid;?> - <?php echo $ru['rNama'];?>  [<?php echo $rj;?>]
	</div>
	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="20px">No</th>
	    <th class="center">Inventaris</th>
	    <th class="center" width="100px">Kondisi</th>
	    <th class="center sorting_disabled" width="40px"></th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	 	$qrt = "SELECT a.*,b.bjenis,b.bmerek,b.bkondisi,b.bserial,b.btipe FROM penempatan a 
	 			  LEFT JOIN barang b ON a.pInv=b.bkode 
	 			  WHERE a.pRuang='$rid'";
	   $qry = mysql_query($qrt);
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      
	     

	      $jenis = getValue("kNama","ms_kategori","kId='$d[bjenis]'");
	      $merek = getValue("merek","ms_merek","rMerek='$d[bmerek]'");
	      $tipe = getValue("tipe","ms_tipe","rTipe='$d[btipe]'");
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='left'>
	        $jenis - $merek - $tipe - sn: <font color='red'>$d[bserial]</font>
	      </td>
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
	      <td class='center'>
         	<a href='?$page&mode=hapus&did=$d[pInv]' class='tooltip-primary' onclick='return qh();' data-rel='tooltip' data-original-title='Hapus Inventaris'>
            	<span class='red'><i class='icon-trash bigger-120'></i></span>
            </a>
		   </td>
		   </tr>";
	   }
	   ?>
	</tbody>
	</table>
	</div>
</div>
<div class="span5">
	<div class="widget-box">
		<div class="widget-header">
			<h4>Tambahkan Inventaris</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main no-padding center">
				<form method="POST" enctype="multipart/form-data">
					<input type="hidden" name="rKode" value="<?php echo $rid;?>">
					<fieldset data-rel="tooltip" data-original-title="Hanya Inventaris Yang Tersedia Yang Dapat Ditambahkan">
						<div class="controls">
							<select multiple class="span3 chosen-select" id="inv" name="inv[]" data-placeholder="Pilih Inventaris">
							<?php
							
							$r = getValue("kNama","ms_kategori","kId='$ru[rJenis]'");
							$qpr = mysql_query("SELECT a.kdkab,a.bkode,a.bjenis,a.bmerek,a.bserial
															FROM barang a WHERE a.kdkab = '$kd' AND stok='0' AND a.bkode NOT IN (SELECT pInv FROM penempatan)");
							while($j=mysql_fetch_array($qpr)){
								$jenis = getValue("kNama","ms_kategori","kId='$j[bjenis]'");
	      						$merek = getValue("merek","ms_merek","rMerek='$j[bmerek]'");
								echo "<option value='$j[bkode]'>$j[bkode] : $jenis - $merek - $j[bserial]</option>";
							}
							?>
							</select>
						</div>
					</fieldset>
					<div class="form-actions center">
						<button type="submit" name="simpan" class="btn btn-small btn-primary">
							Simpan	<i class="icon-save bigger-110"></i>
						</button>
					</div>
				</form>
				<?php
					if (isset($_POST['simpan'])){

						$rkode = $_POST['rKode'];
						$inv = $_POST['inv'];
						$sukses = 0;
						foreach ($inv as $x => $y) {
							$q = mysql_query("INSERT INTO penempatan (pInv,pRuang)
											  				VALUES ('$y','$rkode')");
							if ($q){
								$sukses++;
							}
						}
				  		
					

						if (count($inv)==$sukses){
							echo "<script>
							 		notifsukses('Success','Pesan anda Terkirim..!!');
							  		setTimeout('window.location.href=\"media.php?$page\"', 1000)
							      </script>";
						}else{
							echo "<script>
							      notiferror('Failed','Pesan Gagal Terkirim..!!');
							  		setTimeout('window.location.href=\"media.php?$page\"', 1000)
							      </script>";
						}
					}
					?>
			</div>
		</div>
	</div>
</div>
</div>