<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>DATA PEMINJAMAN</h1>
</div>
<?php
$uname = $_SESSION['dpNama'];
$uid   = $_SESSION['dpId'];
$kd    = $_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$ntgls = date("dmy");
$tgls = date("d-m-Y");
$page = $_GET['page'];
if($_GET['act']=="tambah"){
	$gn = getANum("kode","pinjam","1",9);
	$tik = "PJ.".getANum("kode","pinjam","1",3);
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
				<input type="text" class="input-medium" id="pTiket" name="pTiket" value="<?php echo $tik;?>" readonly required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="tglp">Tanggal Pinjam</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="tglp" name="tglp" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['tglp'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="rtglk">Rencana Tanggal Kembali</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="rtglk" name="rtglk" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['rtglk'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="pInv">Inventaris</label>
			<div class="controls">
				<select class="span5 chosen-select" name="pInv" id="pInv" placeholder="Pilih Inventaris">
					<?php
						$qpr = mysql_query("SELECT a.bkode,a.bjenis,a.bmerek,a.bserial,a.btipe
															FROM barang a WHERE a.bkondisi='1' AND a.stok='1'");
							while($s=mysql_fetch_array($qpr)){
							$kat = getValue("kNama","ms_kategori","kId='$s[bjenis]'");
                                                $kdkab= getValue("kdkab","barang","bkode='$s[bkode]'");
	      					$merek = getValue("merek","ms_merek","rMerek='$s[bmerek]'");
	      					$tipe = getValue("tipe","ms_tipe","rTipe='$s[btipe]'");
	      					$kon = getValue("nama","_kondisi","id='$s[bkondisi]'");
	      					$asal = getValue("jNama","_jpengadaan","jId='$s[basal]'");

							if ($e['pInv']==$s['bkode']){
								echo "<option value='$s[bkode]' selected>$s[bkode] - $kdkab - $kat - $merek - $tipe - sn: $s[bserial]</option>";
							}else{
								echo "<option value='$s[bkode]'>$s[bkode] - $kdkab - $kat - $merek - $tipe - sn: $s[bserial]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="peminjam">Peminjam</label>
			<div class="controls">
				<select class="span5 chosen-select" name="peminjam" id="peminjam" placeholder="Pilih Nama">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_pegawai ORDER BY kdkab, nama");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bpemegang']==$s['nama']){
								echo "<option value='$s[pNip]' selected>$s[kdkab] - $s[nama]</option>";
							}else{
								echo "<option value='$s[pNip]'>$s[kdkab] - $s[nama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ket">Keperluan</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="ket" name="ket" value="" required>
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
			$q1 = mysql_query("INSERT INTO pinjam (kdkab,kode,peminjam,tglp,rtglk,id_inv,status,pPJ,keterangan)
	      											VALUES('$kd','$_POST[pTiket]','$_POST[peminjam]','$_POST[tglp]','$_POST[rtglk]','$_POST[pInv]','1','$uname','$_POST[ket]')");	

			if ($q1){
				$q2 = mysql_query("UPDATE barang SET stok='0' WHERE bkode='$_POST[pInv]'");
			}

	      
			if ($q2){
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
}elseif($_GET['act']=="kembali"){
//$e = mysql_fetch_array(mysql_query("SELECT * FROM pinjam WHERE kode='$_GET[id]'"));
$e = mysql_fetch_array(mysql_query("SELECT a.*,b.tglk,b.pKondisi,b.catatan FROM pinjam a LEFT JOIN spinjam b ON a.kode=b.pTiket WHERE a.kode='$_GET[id]'"));
//$tid = $e['pTiket'];
$tid = $e['kode'];
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Kembali</h2></div>
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
			<label class="control-label" for="tglp">Tanggal Pinjam</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input type="text" class="input-medium" id="tglp" name="tglp" value="<?php echo $e[tglp];?>" readonly required>
				</div>	
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="rtglk">Rencana Tanggal Kembali</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input type="text" class="input-medium" id="tglk" name="tglk" value="<?php echo $e[rtglk];?>" readonly required>
				</div>
		</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="pInv">Inventaris</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input type="text" class="input-long" id="pInv" name="pInv" value="<?php echo $e[id_inv];?>" readonly required>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="peminjam">Peminjam</label>
			<?php
			$nama = getValue("nama","ms_pegawai","pNip='$e[peminjam]'");
			?>
			<div class="controls">
				<div class="row-fluid input-append">
					<input type="text" class="input-long" id="peminjam" name="peminjam" value="<?php echo $nama;?>" readonly required>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ket">Keperluan</label>
			<div class="controls">
				<input type="text" class="input-long" id="ket" name="ket" value="<?php echo $e[keterangan];?>" readonly required>
			</div>
		</div>

		<h5 class="blue">Kondisi Setelah Pengembalian</h5>
		<hr>
		<div class="control-group">
			<label class="control-label" for="tglk">Tanggal Kembali</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="tglk" name="tglk" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['tglk'];?>" required/>
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
			<label class="control-label" for="catatan">Catatan</label>
			<div class="controls">
				<textarea class="ckeditor" name="catatan" id="catatan" rows="8"><?php echo $e['catatan'];?></textarea>
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
			$qta = "INSERT INTO spinjam (pTiket,tglk,pKondisi,catatan)
										   VALUES ('$_POST[pTiket]','$_POST[tglk]',
													  '$_POST[pKondisi]','$_POST[catatan]')
						ON DUPLICATE KEY UPDATE tglk='$_POST[tglk]',
													  pKondisi='$_POST[pKondisi]',catatan='$_POST[catatan]'";
			$q1 = mysql_query($qta);

			if ($q1){
				$q3 = mysql_query("UPDATE pinjam SET status='0', pPJk='$uname' WHERE kode='$_POST[pTiket]'");
				$q2 = mysql_query("UPDATE barang SET stok='1' WHERE bkode='$_POST[pInv]'");
			}

	      
			if ($q2&&$q3){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!!');
			  		setTimeout(function() { history.go(-1); }, 100000);
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
		<i class="icon-download-alt bigger-100"></i>Buka Tiket
	</a><br><br>
	<?php
		if ($_GET['mode']=="hapus"){
			$invx = getValue("id_inv","pinjam","kode='$_GET[id]'");
			mysql_query("UPDATE barang SET stok='1' WHERE bkode='$invx'");
			mysql_query("DELETE FROM pinjam WHERE kode='$_GET[id]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
				   </script>";
		}
	?>
	<div class="table-header">
	   DATA PEMINJAMAN
	</div>
	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="40px">No</th>
	    <th class="center">ID Tiket</th>
	    <th class="center">Peminjam</th>
	    <th class="center">Inventaris</th>
	    <th class="center">Tgl Pinjam</th>
	    <th class="center">Rencana Kembali</th>
	    <th class="center">Keperluan</th>
	    <th class="center">Status</th>
	    <th class="center">Tgl Kembali</th>
	    <th class="center"width="60px">Report</th>
	    <th class="center">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	 	$no=0;
	 	$qry = mysql_query("SELECT a.*,b.tglk,b.pKondisi,b.catatan FROM pinjam a LEFT JOIN spinjam b ON a.kode=b.pTiket WHERE a.kdkab='$kd' ORDER BY a.kode DESC");
		while ($d = mysql_fetch_array($qry)){
	    $no++;

        $tglp = getTglIndo($d['tglp']);
      	$rtglk = getTglIndo($d['rtglk']);
      	$tglk = getTglIndo($d['tglk']);
      	$status = ($d['status']=="1" ? "<span class='badge badge-warning'>Dipinjam</span>" : "<span class='badge badge-success'>Kembali</span>");
      	      	
       	$kat  = getValue("bjenis","barang","bkode='$d[id_inv]'");
	    $katr = getValue("kNama","ms_kategori","kId='$kat'");

		$merek  = getValue("bmerek","barang","bkode='$d[id_inv]'");	    
	    $merekr = getValue("merek","ms_merek","rMerek='$merek'");

	    $tipe  = getValue("btipe","barang","bkode='$d[id_inv]'");
	    $tiper = getValue("tipe","ms_tipe","rTipe='$tipe'");

	    $serial = getValue("bserial","barang","bkode='$d[id_inv]'");
	   
		$nama = getValue("nama","ms_pegawai","pNip='$d[peminjam]'");
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='center'>$d[kode]</td>
	      <td class='left'>$nama</td>
	      <td class='left'>$d[id_inv]<br>$katr - $merekr - $tiper<br> SN : $serial</td>
	      <td class='left'>$d[tglp]</td>
	      <td class='left'>$d[rtglk]</td>
	      <td class='left'>$d[keterangan]</td>
	      <td class='center'>$status</td>
	      <td class='left'>$d[tglk]</td>
	      <td class='center'>";
      		if (!empty($d['tglp'])) {
      				$print =
      				"<form action='cetak/reportpj.php?r=$d[kode]' method='POST' target='_blank'>
		   	<button class='btn btn-primary btn-small' type='submit'>
			<i class='icon-print bigger-100'></i> Cetak
			</button>
			</form>";
      		}
      		echo "
      	    $print
      	  </td>
      	 	  <td class='center'>
		      <div class='inline position-relative'>
            
                  	<a href='?page=$page&act=kembali&id=$d[kode]' class='tooltip-success' data-rel='tooltip' data-original-title='Kembali'>
                     	<span class='orange'><i class='icon-check bigger-120'></i></span>
                    </a>
               
                   	<a href='?page=$page&mode=hapus&id=$d[kode]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
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