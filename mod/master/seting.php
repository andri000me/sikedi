<div class="row-fluid">
<div class="span12">
<?php
$kd    = $_SESSION['dpkode'];
$kdopr = $_SESSION['dpId'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$page = keg;

	$nama    = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	$alamat  = getValue("alamat","kdkab","id_kabkot='$kd'");
	$ppk     = getValue("ppk","kdkab","id_kabkot='$kd'");   
	$kk      = getValue("kk","kdkab","id_kabkot='$kd'");
	if ($kk==0) {
		$nkk='Provinsi';
	} else if ($kk==1) {
		$nkk='Kabupaten';
	} else {
		$nkk='Kota';
	}
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Input Data Pendukung</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		
		<div class="control-group">
			<label class="control-label" for="satker">Nama Satker</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xxlarge" type="text" id="satker" name="satker" value="Kantor <?php echo $nkk;?> <?php echo $nama;?>" disabled>	
				<span class="add-on"><i class="icon-asterisk"></i></span>			
			</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="alamat">Alamat</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xxlarge" type="text" id="alamat" name="alamat" value="<?php echo $alamat;?>">	
				<span class="add-on"><i class="icon-home"></i></span>			
			</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ppk">PPK</label>
			<div class="controls">
				<select class="span3 chosen-select" name="ppk" id="ppk" placeholder="Pilih PPK">
				<option>-- Pilih PPK --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM ms_pegawai WHERE kdkab='$kd' ORDER BY nama ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($ppk==$s['pNip']){
								echo "<option value='$s[pNip]' selected>$s[nama]</option>";	
							}else{
								echo "<option value='$s[pNip]'>$s[nama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>	

		<div class="form-actions">
			<button class="btn btn-info" type="submit" name="update">
				<i class="icon-save bigger-110"></i>Update
			</button>
			<a class="btn" href="media.php?page=keg">
				<i class="icon-undo bigger-110"></i>Batal
			</a>
		</div>
	</form>
	<!-- FORM -->
	<?php
		if (isset($_POST['update'])){
			$q = mysql_query("UPDATE kdkab SET    ppk ='$_POST[ppk]', 
				                               alamat ='$_POST[alamat]'
			                          WHERE id_kabkot = '$kd'");

			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout(function() { history.go(-2); }, 1000);
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