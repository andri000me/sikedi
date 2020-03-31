<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$id   = $_GET['id'];
$kd   = $_GET['kd'];
$page = "page=".$_GET['page']."&id=$id";
$btnfback = "media.php?page=mkendi";

?>
<?php
	$page  = "mkendi";
	$e     = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bId='$id'"));
	$kat   = getValue("jenis","kendi_jen","id='$e[bjenis]'");
	$merek = getValue("merek","kendi_merk","id='$e[bmerek]'");
	$tipe  = getValue("tipe","kendi_tipe","id='$e[btipe]'");
	$format = number_format ($e[harga_per], 0, ',', '.');
	$pemegang = getValue("nama","ms_pegawai","pNip='$e[bpemegang]'");
	$kon   = getValue("nama","_kondisi","id='$e[bkondisi]'");
	$nkab  = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$kd'"));
	$plat  = $e['no_plat'];
	$uid   = $e['uId'];
?>
<div class="row-fluid">
<div class="span12">
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">DETAIL KENDERAAN DINAS BPS <?php echo $nkab;?> [<b><?php echo $e['no_plat'];?></b>]</h2></div><br>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
	
		<div class="control-group">
			<label class="control-label" for="telp">Kode</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="telp" name="telp" value="<?php echo $e['bkode'];?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="telp">Jenis</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="telp" name="telp" value="<?php echo $kat;?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="telp">Merek</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="telp" name="telp" value="<?php echo $merek;?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Tipe</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-large" type="text" id="email" name="email" value="<?php echo $tipe;?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">No Mesin</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-xlarge" type="text" id="email" name="email" value="<?php echo $e['no_mesin'];?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">No Rangka</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-xlarge" type="text" id="email" name="email" value="<?php echo $e['no_rangka'];?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">No Plat</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="email" name="email" value="<?php echo $e['no_plat'];?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">No BPKB</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="email" name="email" value="<?php echo $e['no_bpkb'];?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Pemegang</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-xlarge" type="text" id="email" name="email" value="<?php echo $pemegang;?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Kondisi</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="email" name="email" value="<?php echo $kon;?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Tahun Perolehan</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="email" name="email" value="<?php echo $e['thn_per'];?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Harga Perolehan</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-small" type="text" id="email" name="email" value="<?php echo $format;?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="email">Keterangan</label>
			<div class="controls">
				<div class="input-append">
					<input class="input-xxlarge" type="text" id="email" name="email" value="<?php echo $e['ket'];?>" readonly>
					<span class="add-on"></span>
				</div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="foto">Foto</label>
			<div class="controls">
				<?php
					/*$ptol = "Anda belum menginput gambar, ukuran file gambar tidak boleh lebih 1MB";
					if (!empty($e['uFoto'])){*/
						$gbrx ="<div class='span2'>
								<img class='pull-left' src='foto_kendi/$e[foto]' width='100%' margin='5px' data-rel='tooltip' data-placement='right' data-original-title='$e[no_plat]'>
								</div>";
						/*$ptol = "Abaikan jika gambar tidak diganti, ukuran file gambar tidak boleh lebih 1MB";
					}				*/		
				?>
				<?php echo $gbrx;?>
				<!-- <div id="foto">
					<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="<?php echo $ptol;?>">
						<input type="file" name="fupload"> 
					</div>
				</div> -->
			</div>
		</div>
			<a class="btn" href="media.php?page=<?php echo $page;?>">
				<i class="icon-undo bigger-110"></i>Kembali
			</a>
		</div>
	</form>
	<!-- FORM -->
	<?php
		if (isset($_POST['simpan'])){
			
		  	$lokasi_file    = $_FILES['fupload']['tmp_name'];
	  		$tipe_file      = $_FILES['fupload']['type'];
	  		$nama_file      = $_FILES['fupload']['name'];
	  		$acak           = rand(1,99);
	  		$foto = $acak.$nama_file;

			if (!empty($lokasi_file)){
				UploadUser($foto);
				$ft = getValue("uFoto","user","uId='$_POST[uid]'");
				if (!$ft==""){
					unlink("foto_user/$ft");
				}

				$q = mysql_query("UPDATE user SET uNama='$_POST[nama]',uTelp='$_POST[telp]',
			                                     uEmail='$_POST[email]',uFoto='$foto',
			                                     onUpdate=NOW()
			                                 WHERE uId='$_POST[uid]'
			                    ");

				if ($_SESSION['dpId']==$_POST['uid']){
					$_SESSION['dpFoto']="foto_user/$foto";
					$_SESSION['dpNama'] = $_POST['nama'];
					$_SESSION['dpLevel'] = $_POST['lvl'];
				}
			}else{
				$q = mysql_query("UPDATE user SET uNama='$_POST[nama]',uTelp='$_POST[telp]',
			                                     uEmail='$_POST[email]',
			                                     onUpdate=NOW()
			                                 WHERE uId='$_POST[uid]'
			                    ");
			}
		  	
			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout(function() { history.go(-1); }, 1000);
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
</div>
</div>