<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>DATA PERBAIKAN</h1>
</div>
<?php
$uname = $_SESSION['dpNama'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$ntgls = date("dmy");
$tgls = date("d-m-Y");
$page = $_GET['page'];
if($_GET['act']=="tambah"){
	$gn = getANum("pTiket","perbaikan","1",9);
	$tid = "P.".$ntgls.".".getANum("pTiket","perbaikan","1",9);
	//echo $tid."<br>".$gn;
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Buka Tiket</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="pTiket">ID Tiket</label>
			<div class="controls">
				<input type="text" class="input-medium" id="pTiket" name="pTiket" value="<?php echo $tid;?>" readonly required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pTgl">Tanggal</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="pTgl" name="pTgl" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['pTgl'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pInv">Inventaris</label>
			<div class="controls">
				<select class="span5 chosen-select" name="pInv" id="pInv" placeholder="Pilih Inventaris">
				<?php
						$qsp = mysql_query("SELECT * FROM barang WHERE bpemegang='$uname'");
						while ($s=mysql_fetch_array($qsp)) {
							$kat = getValue("kNama","ms_kategori","kId='$s[bjenis]'");
	      					$merek = getValue("merek","ms_merek","rMerek='$s[bmerek]'");
	      					$tipe = getValue("tipe","ms_tipe","rTipe='$s[btipe]'");
	      					$kon = getValue("nama","_kondisi","id='$s[bkondisi]'");
	      					$asal = getValue("jNama","_jpengadaan","jId='$s[basal]'");

							if ($e['pInv']==$s['bkode']){
								echo "<option value='$s[bkode]' selected>$s[bkode] - $kat - $merek - $tipe - sn: $s[bserial]</option>";
							}else{
								echo "<option value='$s[bkode]'>$s[bkode] - $kat - $merek - $tipe - sn: $s[bserial]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pPJ">Penanggung Jawab</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="pPJ" name="pPJ" value="<?php echo "$uname";?>"  disabled required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pKerusakan">Kerusakan</label>
			<div class="controls">
				<textarea class="ckeditor" name="pKerusakan" id="pKerusakan" rows="8"><?php echo $e['pKerusakan'];?></textarea>
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
		$uname = $_SESSION['dpNama'];	
			$q1 = mysql_query("INSERT INTO perbaikan (pTiket,pInv,pTgl,pKerusakan,user,pPJ)
	      											VALUES('$_POST[pTiket]','$_POST[pInv]','$_POST[pTgl]',
	      													 '$_POST[pKerusakan]','$uname','$_POST[pPJ]')");	

			if ($q1){
				$q2 = mysql_query("UPDATE barang SET bkondisi='1' WHERE bkode='$_POST[pInv]'");
			}

	      
			if ($q2){
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
}elseif($_GET['act']=="edit"){
$e = mysql_fetch_array(mysql_query("SELECT * FROM perbaikan WHERE pTiket='$_GET[id]'"));
$tid = $e['pTiket'];
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="pTiket">ID Tiket</label>
			<div class="controls">
				<input type="text" class="input-medium" id="pTiket" name="pTiket" value="<?php echo $tid;?>" readonly required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pTgl">Tanggal</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="pTgl" name="pTgl" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['pTgl'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pInv">Inventaris</label>
			<div class="controls">
				<select class="span4 chosen-select" name="pInv" id="pInv" placeholder="Pilih Inventaris">
					<?php
						$qsp = mysql_query("SELECT * FROM barang WHERE bkondisi='1'");
						while ($s=mysql_fetch_array($qsp)) {
							$jenis = getValue("kNama","ms_kategori","kId='$s[bjenis]'");
	   						$nmerek = getValue("merek","ms_merek","rMerek='$s[bmerek]'");
	   						$ntipe = getValue("tipe","ms_tipe","rTipe='$s[btipe]'");
	   						$serial = getValue("bserial","barang","bkode='$d[pInv]'");

							if ($e['pInv']==$s['bInv']){
								echo "<option value='$s[bkode]' selected>$s[bkode] - $jenis - $nmerek - $ntipe - sn: $s[bserial]</option>";
							}else{
								echo "<option value='$s[bkode]'>$s[bkode] - $jenis - $nmerek - $ntipe - sn: $s[bserial]</option>";
	   							

							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pPJ">Penanggung Jawab</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="pPJ" name="pPJ" value="<?php echo $e['user'];?>" readonly>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pKerusakan">Keluhan</label>
			<div class="controls">
				<textarea class="ckeditor" name="pKerusakan" id="pKerusakan" rows="8"><?php echo $e['pKerusakan'];?></textarea>
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
			
			$q = mysql_query("UPDATE perbaikan SET pTgl='$_POST[pTgl]',
	      												pKerusakan='$_POST[pKerusakan]',
	      												pPJ='$_POST[pPJ]',
	      												onUpdate=NOW()
	      											WHERE pTiket='$_POST[pTiket]'");	
	      
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
}elseif($_GET['act']=="selesai"){
$e = mysql_fetch_array(mysql_query("SELECT a.*,b.pTglS,b.pKondisi,b.pKet FROM perbaikan a LEFT JOIN sperbaikan b ON a.pTiket=b.pTiket WHERE a.pTiket='$_GET[id]'"));
$tid = $e['pTiket'];
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Selesai</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="pTiket">ID Tiket</label>
			<div class="controls">
				<input type="text" class="input-medium" id="pTiket" name="pTiket" value="<?php echo $tid;?>" readonly required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pTgl">Tanggal Perbaikan</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="pTgl" name="pTgl" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['pTgl'];?>" disabled required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pInv">Inventaris</label>
			<div class="controls">
				<select class="span4 chosen-select" name="pInv" id="pInv" placeholder="Pilih Inventaris" disabled>
					<?php
						$qsp = mysql_query("SELECT * FROM barang");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['pInv']==$s['bkode']){
								$jenis = getValue("kNama","ms_kategori","kId='$s[bjenis]'");
	   							$nmerek = getValue("merek","ms_merek","rMerek='$s[bmerek]'");
	   							$ntipe = getValue("tipe","ms_tipe","rTipe='$s[btipe]'");
	   							$serial = getValue("bserial","barang","bkode='$d[pInv]'");

								echo "<option value='$s[bkode]' selected>$s[bkode] - $jenis - $nmerek - $ntipe sn: $serial</option>";
							}else{
								echo "<option value='$s[bkode]'>$s[bkode] - $jenis - $nmerek - $ntipe sn: $serial</option>";
							}
						}
					?>
				</select>
				<input type="hidden" id="pInv" name="pInv" value="<?php echo $e[pInv];?>" >
			</div>
		</div>
		<hr>
		<h5 class="blue">Kondisi Setelah Perbaikan</h5>
		<hr>
		<div class="control-group">
			<label class="control-label" for="pTglS">Tanggal Selesai</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="pTglS" name="pTglS" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['pTglS'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pKondisi">Kondisi</label>
			<div class="controls"> 
				<?php
				$arKon = array('1'=>'Baik','2'=>'Rusak Ringan','3'=>'Rusak Berat');
				foreach ($arKon as $k => $v) {
					if ($k==$e['pKondisi']){
						echo "<input name='pKondisi' type='radio' class='ace' value='$k' checked/><span class='lbl'> $v </span><br>";
					}else{
						echo "<input name='pKondisi' type='radio' class='ace' value='$k' /><span class='lbl'> $v </span><br>";
					}
				}
				?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pKet">Ket</label>
			<div class="controls">
				<textarea class="ckeditor" name="pKet" id="pKet" rows="8"><?php echo $e['pKet'];?></textarea>
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
			
			$qta = "INSERT INTO sperbaikan (pTiket,pTglS,pKondisi,pKet)
										   VALUES ('$_POST[pTiket]','$_POST[pTglS]',
													  '$_POST[pKondisi]','$_POST[pKet]')
						ON DUPLICATE KEY UPDATE pTglS='$_POST[pTglS]',
													  pKondisi='$_POST[pKondisi]',pKet='$_POST[pKet]'";
			$q1 = mysql_query($qta);

			if ($q1){
				$q3 = mysql_query("UPDATE perbaikan SET pProses='0' WHERE pTiket='$_POST[pTiket]'");
				$q4 = mysql_query("UPDATE perbaikan SET pPJ='$uname' WHERE pTiket='$_POST[pTiket]'");
				$q2 = mysql_query("UPDATE barang SET bKondisi='$_POST[pKondisi]' WHERE bInv='$_POST[pInv]'");
			}

	      
			if ($q2&&$q3){
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
?>
	<a href="?page=<?php echo $page;?>&act=tambah" class="btn btn-primary">
		<i class="icon-download-alt bigger-100"></i>Buka Tiket Baru
	</a><br><br>
	<?php
		if ($_GET['mode']=="hapus"){
			$invx = getValue("pInv","perbaikan","pTiket='$_GET[id]'");
			mysql_query("UPDATE barang SET bKondisi='1' WHERE bInv='$invx'");
			mysql_query("DELETE FROM perbaikan WHERE pTiket='$_GET[id]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
				   </script>";
		}
	?>
	<div class="table-header">
	   DATA PERBAIKAN
	</div>
	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="20px">No</th>
	    <th class="center" width="40px">ID Tiket</th>
	    <th class="center" width="180px">Inventaris</th>
	    <th class="center" width="60px">Status</th>
	    <th class="center" width="200px">Keluhan</th>
	    <th class="center" width="200px">Pasca Perbaikan</th>
	    <th class="center"width="60px">Report</th>
	    <th class="center" width="40px">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php

	    $qry = mysql_query("SELECT a.*,b.pTglS,b.pKondisi,b.pKet FROM perbaikan a LEFT JOIN sperbaikan b ON a.pTiket=b.pTiket WHERE a.user='$uname' ORDER BY a.pTiket DESC");
		while ($d = mysql_fetch_array($qry)){
        $no++;
	     

	    $tglp = getTglIndo($d['pTgl']);
      	$tgls = getTglIndo($d['pTglS']);
      	$status = ($d['pProses']=="1" ? "<span class='badge badge-warning'>Proses</span>" : "<span class='badge badge-success'>Selesai</span>");
      	$kondisi = ($d['pKondisi']=="1" ? "<span class='badge badge-success'>Baik</span>" : "<span class='badge badge-important'>Rusak</span>");
      	$pasca = "";
      	if (!empty($d['pTglS'])){
      		$pasca = "<b>Tanggal : </b> $tgls<br>
					  <b>Kondisi : </b> $kondisi<br>
				   	  <b>Teknisi : </b> $d[pPJ]<br>
				   	  <b>Aksi : </b>$d[pKet]<br>";
			$report = "<a href='cetak/form.php'>Cetak Form</a>";
      	}
      	
        $tiket=$d[pInv];
        $kat = getValue("bjenis","barang","bkode='$d[pInv]'");
	    $jenis = getValue("kNama","ms_kategori","kId='$kat'");
	    $merek = getValue("bmerek","barang","bkode='$d[pInv]'");
	    $nmerek = getValue("merek","ms_merek","rMerek='$merek'");
	    $tipe = getValue("btipe","barang","bkode='$d[pInv]'");
	    $ntipe = getValue("tipe","ms_tipe","rTipe='$tipe'");
	    $serial = getValue("bserial","barang","bkode='$d[pInv]'");
		$nama = getValue("uNama","user","uId='$d[user]'");
		$ruang = getValue("pRuang","penempatan","pInv='$d[pInv]'");
	    $nruang = getValue("rNama","ms_ruangan","rKode='$ruang'");

	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='center'>$d[pTiket]</td>
	      <td class='left'>
	      	$d[pInv] <br>Ruang : [$ruang] $nruang<br>$jenis - $nmerek - $ntipe <br> Serial : $serial
	      </td>
	      <td class='center'>$status</td>
	      <td class='left'>
	      	<b>Tanggal : </b> $tglp<br>
	      	<b>Pelapor : </b> $d[user]<br>
      		<b>Keluhan : </b> $d[pKerusakan]
      	</td>
      	<td class='left'>
	      	$pasca
      	</td>
      	<td class='center'>";
      	  if (!empty($d['pTglS'])) {
      				$print =
      				"<form action='cetak/reportp.php?r=$d[pTiket]' method='POST' target='_blank'>
		   	<button class='btn btn-primary btn-small' type='submit'>
			<i class='icon-print bigger-100'></i> Cetak
			</button>
			</form>";
      		}
      		echo "
      	    $print

	      <td class='center'>
		      <div class='inline position-relative'>
        
                  	<a href='?page=$page&act=edit&id=$d[pTiket]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
                     </a>
                  
                  	<a href='?page=$page&mode=hapus&id=$d[pTiket]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                     </a>
            
            </div>
		   </td>";
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