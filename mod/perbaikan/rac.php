<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>DAFTAR PERAWATAN AC</h1>
</div>
<?php
$kd     = $_SESSION['dpkode'];
$ulevel = $_SESSION['dpLevel'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$ntgls = date("dmy");
$tgls = date("d-m-Y");
$page = $_GET['page'];
if($_GET['act']=="tambah"){
	//$gn = getANum("bKode","barang","1",10);
	//$bid = "DP.".$ntgls.".".getANum("bkode","barang","1",10);
	//$bid = "DP.300317.".getANum("bkode","barang","1",10);
	$bid = "RAC.1200.".getANum("pTiket","rep_ac","1",9);
	//echo $bid."<br>".$gn;
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Tambah</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">		
		<div class="control-group">
			<label class="control-label" for="bkode">Tiket</label>
			<div class="controls">
			
				<input class="input-large" type="text" id="bkode" name="bkode" readonly = "readonly" value="<?php echo $bid; ?>" required>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="bkode">Pilih AC</label>
			<div class="controls">
				<select class="span6 chosen-select" name="bkode" id="bkode" placeholder="Pilih AC">
				<option>-- Pilih AC --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM barang WHERE bjenis='44' AND kdkab='$kd'");
						while ($s=mysql_fetch_array($qsp)) {
							$merek  = getValue("merek","ms_merek","rMerek='$s[bmerek]'");
	      					$tipe   = getValue("tipe","ms_tipe","rTipe='$s[btipe]'");
	      					$pinv   = getValue("pRuang","penempatan","pInv='$s[bkode]'");
	      					$nruang = getValue("rNama","ms_ruangan","idruang='$pinv'");
							echo "<option value='$s[bkode]'>$nruang - $merek - $tipe - $s[bserial]</option>";
						}
					?>
				</select>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="tglrep">Tanggal</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="tglrep" name="tglrep" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['tglrep'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="rekrep">Rekanan</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="rekrep" name="rekrep" value="<?php echo $e['rekrep'];?>" required>				
			</div>
		</div>			
		
		<div class="control-group">
			<label class="control-label" for="detrep">Detil Perawatan</label>
			<div class="controls">
				<textarea class="ckeditor" name="detrep" id="detrep" rows="8"><?php echo $e['detrep'];?></textarea>
			</div>
		</div>		

		<div class="form-actions">
			<button class="btn btn-info" type="submit" name="simpan">
				<i class="icon-save bigger-110"></i>Simpan
			</button>
			<a class="btn" href="media.php?page=<?php echo $page;?>">
				<i class="icon-undo bigger-110"></i>Batal
			</a>
		</div>
	</form>
	<!-- FORM -->
	<?php
		if (isset($_POST['simpan'])){		

			$q = mysql_query("INSERT INTO rep_ac (pTiket,bkode,kdkab,tglrep,rekrep,detrep,onCreate)
	      											VALUES('$bid','$_POST[bkode]','$kd','$_POST[tglrep]',
	      													 '$_POST[rekrep]','$_POST[detrep]',NOW())");
	        
	    	if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!!');
			  		setTimeout(function() { history.go(-1); }, 10000);
			      </script>";
			}
		}
	
	?>
		
</div>
</div>
</div>
<?php
}elseif($_GET['act']=="edit"){

$e = mysql_fetch_array(mysql_query("SELECT * FROM rep_ac WHERE id='$_GET[id]'"));
	    $idmerek  = getValue("bmerek","barang","bkode='$e[bkode]'");
	    $merek    = getValue("merek","ms_merek","rMerek='$idmerek'");
	    $idtipe   = getValue("btipe","barang","bkode='$e[bkode]'");
	    $tipe     = getValue("tipe","ms_tipe","rTipe='$idtipe'");
	    $serial   = getValue("bserial","barang","bkode='$e[bkode]'");
	    $pinv     = getValue("pRuang","penempatan","pInv='$e[bkode]'");
	    $nruang   = getValue("rNama","ms_ruangan","idruang='$pinv'");
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		
		<div class="control-group">
			<label class="control-label" for="bkode">Tiket</label>
			<div class="controls">
			
				<input class="input-large" type="text" id="bkode" name="bkode" readonly = "readonly" value="<?php echo $e['pTiket']; ?>" required>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="bkode">Merek/Tipe/SN</label>
			<div class="controls">			
				<input class="input-xxlarge" type="text" id="bkode" name="bkode" readonly = "readonly" value="<?php echo $nruang; ?> - <?php echo $tipe; ?> - <?php echo $merek; ?> - <?php echo $e['bkode']; ?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="tglrep">Tanggal</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="tglrep" name="tglrep" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['tglrep'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="rekrep">Rekanan</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="rekrep" name="rekrep" value="<?php echo $e['rekrep'];?>" required>				
			</div>
		</div>		
				
		<div class="control-group">
			<label class="control-label" for="detrep">Detil Perawatan</label>
			<div class="controls">
				<textarea class="ckeditor" name="detrep" id="detrep" rows="8"><?php echo $e['detrep'];?></textarea>
			</div>
		</div>			

		<div class="form-actions">
			<button class="btn btn-info" type="submit" name="simpan">
				<i class="icon-save bigger-110"></i>Simpan
			</button>
			<a class="btn" href="media.php?page=<?php echo $page;?>">
				<i class="icon-undo bigger-110"></i>Batal
			</a>
		</div>
	</form>
	<!-- FORM -->
	<?php
		if (isset($_POST['simpan'])){
			
			$q = mysql_query("UPDATE rep_ac SET    tglrep='$_POST[tglrep]',
												  rekrep='$_POST[rekrep]',
												  detrep='$_POST[detrep]',							  
	      										onUpdate=NOW()
										       WHERE id='$_GET[id]'");	
			
			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!!');
			  		setTimeout(function() { history.go(-1); }, 1000);
			      </script>";
			}
		}
	?>
</div>
</div>
</div>	
<?php
}else{

if ($ulevel=='0') {
	echo "	
	<a href='?page=$page&act=tambah' class='btn btn-primary'>
		<i class='icon-download-alt bigger-100'></i>Tambah
	</a><br><br>";
} else {
	echo " ";
}
	if ($_GET['mode']=="hapus"){
		mysql_query("DELETE FROM rep_ac WHERE id='$_GET[id]'");
		echo "<script>
			notifsukses('Sukses','Data Telah Dihapus..!!');
			setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			</script>";
		}
	
	if ($kd=='1200') {
		echo "
		<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='mkendi'>
			
			<select class='span3 chosen-select' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";
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
			<a href='?page=rac' type='button' class='btn btn-primary btn-small'>
				Reset
				<i class='icon-refresh icon-on-right bigger-110'></i>
			</a>
		</form>";

	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$_GET[kkb]'"));
		echo "
	<div class='table-header'>";
	if (!empty($_GET[kkb])) {
		echo "
		REKAP MAINTENANCE AC BPS $nmkab</div>";
	} else {
		echo"
		REKAP MAINTENANCE AC BPS PROVINSI SUMATERA UTARA</div>";
	}
	echo "
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    	<th class='center'>No</th>
	    	<th class='center'>Ruang</th>
	    	<th class='center'>Merek/Tipe/AC</th>
	    	<th class='center'>Tgl Maintenance</th>
	    	<th class='center'>Rekanan</th>	        
	    	<th class='center'>Perawatan</th>
	    	<th class='center'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";

	$kd=$_SESSION['dpkode'];
	$no=0;
	if (!empty($_GET[kkb])) {
	    $qry = mysql_query("SELECT * FROM rep_ac WHERE kdkab='$_GET[kkb]' ORDER BY onCreate DESC");
	    } else {
	   	$qry = mysql_query("SELECT * FROM rep_ac WHERE kdkab='1200' ORDER BY onCreate DESC");
	    }
		  
		while ($d = mysql_fetch_array($qry)){
	    $no++;
	    
	    $idmerek  = getValue("bmerek","barang","bkode='$d[bkode]'");
	    $merek    = getValue("merek","ms_merek","rMerek='$idmerek'");
	    $idtipe   = getValue("btipe","barang","bkode='$d[bkode]'");
	    $tipe     = getValue("tipe","ms_tipe","rTipe='$idtipe'");
	    $serial   = getValue("bserial","barang","bkode='$d[bkode]'");
	    $pinv     = getValue("pRuang","penempatan","pInv='$d[bkode]'");
	    $nruang   = getValue("rNama","ms_ruangan","idruang='$pinv'");
	    $kon      = getValue("kondisi","_kondisi","id='$d[bkondisi]'");
	    $tglp     = getTglIndo($d['tglrep']);
	    $format = number_format ($d[harga_per], 0, ',', '.');
	   	  
	    echo "
	    <tr>  
	   	  <td class='center'>$no</td>      
	      <td class='left'>$nruang</td>
	      <td class='left'>$merek - $tipe <br> sn : <b>$serial</b></td>	        
	      <td class='left'>$tglp</td>        
	      <td class='left'>$d[rekrep]</td>
	      <td class='left'>$d[detrep]</td>     
	      <td class='center'>
		    <div class='inline position-relative'>";
		    if ($kd!=$d['kdkab']) {
                  	echo "
                    ---";
                } else {
                echo "
                <a href='?page=drepac&id=$d[id]&kd=$kd' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
                    <span class='orange'><i class='icon-search bigger-120'></i></span>
                </a>
                <a href='?page=$page&act=edit&id=$d[id]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                <span class='green'><i class='icon-edit bigger-120'></i></span>
                </a>
                <a href='?page=$page&mode=hapus&id=$d[id]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                </a>";
            }
            echo "
            </div>
		  </td>";
		}
	      ?>
	     </tr>
	    <?php
	       } else {
	

	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$kd'"));
	echo "
	<div class='table-header'>REKAP MAINTENANCE AC BPS $nmkab</div>
	<div class='row-fluid'>

	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    	<th class='center'>No</th>
	    	<th class='center'>Ruang</th>
	    	<th class='center'>Merek/Tipe/AC</th>
	    	<th class='center'>Tgl Maintenance</th>
	    	<th class='center'>Rekanan</th>	        
	    	<th class='center'>Perawatan</th>
	    	<th class='center'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";
	    $no=0;
	    $qry = mysql_query("SELECT * FROM rep_ac WHERE kdkab='$kd' ORDER BY onCreate DESC");
	
		while ($d = mysql_fetch_array($qry)){
	    $no++;	
	    $idmerek  = getValue("bmerek","barang","bkode='$d[bkode]'");
	    $merek    = getValue("merek","ms_merek","rMerek='$idmerek'");
	    $tipe     = getValue("tipe","ms_tipe","rTipe='$s[btipe]'");
	    $serial   = getValue("bserial","barang","bkode='$d[bkode]'");
	    $pinv     = getValue("pRuang","penempatan","pInv='$d[bkode]'");
	    $nruang   = getValue("rNama","ms_ruangan","idruang='$pinv'");
	    $kon      = getValue("kondisi","_kondisi","id='$d[bkondisi]'");
	    $tglp     = getTglIndo($d['tglrep']);
	    $format   = number_format ($d[harga_per], 0, ',', '.');
	   
	    echo "
	    <tr>
	      <td class='center'>$no</td>      
	      <td class='left'>$nruang</td>
	      <td class='left'>$merek <br> $tipe <br> sn : <b>$serial</b></td>	        
	      <td class='left'>$tglp</td>        
	      <td class='left'>$d[rekrep]</td>
	      <td class='center'>
		    <div class='inline position-relative'>
		    	<a href='?page=drepac&id=$d[id]&kd=$kd' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
                    <span class='orange'><i class='icon-search bigger-120'></i></span>
                </a>
                <a href='?page=$page&act=edit&id=$d[id]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                <span class='green'><i class='icon-edit bigger-120'></i></span>
                </a>
                <a href='?page=$page&mode=hapus&id=$d[id]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                </a>
            </div>
		  </td>";
		}
	      ?>
	     </tr>
	    <?php
	       }
	    ?>
	</tbody>
	</table>
	</div>
<?php
}
?>
</div>
</div>

