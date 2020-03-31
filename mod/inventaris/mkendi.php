<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>MASTER KENDERAAN DINAS</h1>
</div>
<?php
$kd     = $_SESSION['dpkode'];
$ulevel = $_SESSION['dpLevel'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$ntgls = date("dmy");
$tgls = date("d-m-Y");
$page = $_GET['page'];
if($_GET['act']=="tambah"){
$bid = "KD.1200.".getANum("bkode","kendi","1",8);
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Tambah</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		
		<div class="control-group">
			<label class="control-label" for="bkode">Kode</label>
			<div class="controls">
			
				<input class="input-large" type="text" id="bkode" name="bkode" readonly = "readonly" value="<?php echo $bid; ?>" required>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="bjenis">Jenis</label>
			<div class="controls">
				<select class="span2 chosen-select" name="bjenis" id="bjenis" placeholder="Pilih Jenis">
				<option>-- Pilih Jenis --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_jen");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bKat']==$s['id']){
								echo "<option value='$s[id]' selected>$s[jenis]</option>";
							}else{
								echo "<option value='$s[id]'>$s[jenis]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="bmerek">Merek</label>
			<div class="controls">
				<select class="span2 chosen-select" name="bmerek" id="bmerek" placeholder="Pilih Merek">
				<option>-- Pilih Merek --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_merk ORDER BY merek ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bmerek']==$s['id']){
								echo "<option value='$s[id]' selected>$s[merek]</option>";
							}else{
								echo "<option value='$s[id]'>$s[merek]</option>";
							}
						}
					?>
				</select>


			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="btipe">Tipe</label>
			<div class="controls">
				<select class="span3 chosen-select" name="btipe" id="btipe" placeholder="Pilih Tipe">
				<option>-- Pilih Tipe --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_tipe ORDER BY tipe");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['btipe']==$s['id']){
								echo "<option value='$s[id]' selected>$s[tipe]</option>";
							}else{
								echo "<option value='$s[id]'>$s[tipe]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="no_mesin">No Mesin</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="no_mesin" name="no_mesin" value="<?php echo $e['no_mesin'];?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="no_rangka">No Rangka</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="no_rangka" name="no_rangka" value="<?php echo $e['no_rangka'];?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="no_plat">No Plat</label>
			<div class="controls">
				<input class="input-small" type="text" id="no_plat" name="no_plat" value="<?php echo $e['no_plat'];?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="no_bpkb">No BPKB</label>
			<div class="controls">
				<input class="input-small" type="text" id="no_bpkb" name="no_bpkb" value="<?php echo $e['no_bpkb'];?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bpemegang">Pemegang</label>
			<div class="controls">
				<select class="span5 chosen-select" name="bpemegang" id="bpemegang" placeholder="Pilih Nama">
				<option>-- Pilih Pegawai --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM ms_pegawai WHERE kdkab='$kd' ORDER BY nama");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bpemegang']==$s['pNip']){
								echo "<option value='$s[pNip]' selected>$s[nama]</option>";
							}else{
								echo "<option value='$s[pNip]'>$s[nama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bkondisi">Kondisi</label>
			<div class="controls">
				<select class="span3 chosen-select" name="bkondisi" id="bkondisi" placeholder="Pilih Jenis">
				<option>-- Pilih Kondisi --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM _kondisi ORDER BY kondisi ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['basal']==$s['id']){
								echo "<option value='$s[id]' selected>$s[nama]</option>";
							}else{
								echo "<option value='$s[id]'>$s[nama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="thn_per">Tahun Perolehan</label>
			<div class="controls">
				<select class="span2 chosen-select" name="thn_per" id="thn_per" placeholder="Pilih Tahun"><option>-- Pilih Tahun --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM _tahun ORDER BY tahun DESC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['thn_per']==$s['tahun']){
								echo "<option value='$s[tahun]' selected>$s[tahun]</option>";
							}else{
								echo "<option value='$s[tahun]'>$s[tahun]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="harga_per">Harga Perolehan</label>
			<div class="controls">
				<input class="input-small" type="text" id="harga_per" name="harga_per" value="<?php echo $e['harga_per'];?>" >
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="pagu">Pagu Perawatan</label>
			<div class="controls">
				<input class="input-small" type="text" id="pagu" name="pagu" value="<?php echo $e['pagu'];?>" >
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ket">Keterangan</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="ket" name="ket" value="<?php echo $e['ket'];?>" >
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="foto">Foto</label>
			<div class="controls">
				<div id="foto">
					<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="Ukuran File Gambar Tidak Boleh Lebih 1MB">
						<input type="file" name="fupload"> 
					</div>
				</div>
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

			$lokasi_file    = $_FILES['fupload']['tmp_name'];
	  		$tipe_file      = $_FILES['fupload']['type'];
	  		$nama_file      = $_FILES['fupload']['name'];
	  		$acak           = rand(1,99);
	  		$foto = $acak.$nama_file;

			if (!empty($lokasi_file)){
				UploadKendi($foto);
				$ft = getValue("foto","kendi","bId='$_POST[bid]'");
				if (!$ft==""){
					unlink("foto_kendi/$ft");
				}

			$q = mysql_query("INSERT INTO kendi (kdkab,bkode,bjenis,bmerek,btipe,no_mesin,no_rangka,no_plat,no_bpkb,bpemegang,bkondisi,thn_per,harga_per,ket,foto,pagu,onCreate)
	      											VALUES('$kd','$bid','$_POST[bjenis]','$_POST[bmerek]',
	      													 '$_POST[btipe]','$_POST[no_mesin]','$_POST[no_rangka]','$_POST[no_plat]','$_POST[no_bpkb]','$_POST[bpemegang]','$_POST[bkondisi]','$_POST[thn_per]','$_POST[harga_per]','$_POST[ket]','$foto','$_POST[pagu]',NOW())");
	        }else{
	        $q = mysql_query("INSERT INTO kendi (kdkab,bkode,bjenis,bmerek,btipe,no_mesin,no_rangka,no_plat,no_bpkb,bpemegang,bkondisi,thn_per,harga_per,ket,onCreate)
	      											VALUES('$kd','$bid','$_POST[bjenis]','$_POST[bmerek]',
	      													 '$_POST[btipe]','$_POST[no_mesin]','$_POST[no_rangka]','$_POST[no_plat]','$_POST[no_bpkb]','$_POST[bpemegang]','$_POST[bkondisi]','$_POST[thn_per]','$_POST[harga_per]','$_POST[ket]','$_POST[pagu]',NOW())");
	    	}

			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!! $_POST[stok] ');
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
$e = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bId='$_GET[id]' GROUP BY bId"));
$idx = $e['bId'];

?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
		<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		
		<div class="control-group">
			<label class="control-label" for="bkode">Kode</label>
			<div class="controls">
			
				<input class="input-small" type="text" id="bkode" name="bkode" readonly = "readonly" value="<?php echo $e[bkode]; ?>" required>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="bjenis">Jenis</label>
			<div class="controls">
				<select class="span2" name="bjenis" id="bjenis" placeholder="Pilih Jenis">
				<option>-- Pilih Jenis --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_jen ORDER BY jenis ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bjenis']==$s['id']){
								echo "<option value='$s[id]' selected>$s[jenis]</option>";
							}else{
								echo "<option value='$s[id]'>$s[jenis]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bmerek">Merek</label>
			<div class="controls">
				<select class="span2 chosen-select" name="bmerek" id="bmerek" placeholder="Pilih Merek">
				<option>-- Pilih Merek --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_merk ORDER BY merek ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bmerek']==$s['id']){
								echo "<option value='$s[id]' selected>$s[merek]</option>";
							}else{
								echo "<option value='$s[id]'>$s[merek]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="btipe">Tipe</label>
			<div class="controls">
				<select class="span3" name="btipe" id="btipe" placeholder="Pilih Tipe">
				<option>-- Pilih Tipe --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_tipe ORDER BY tipe");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['btipe']==$s['id']){
								echo "<option value='$s[id]' selected>$s[tipe]</option>";
							}else{
								echo "<option value='$s[id]'>$s[tipe]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="no_mesin">No Mesin</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="no_mesin" name="no_mesin" value="<?php echo $e['no_mesin'];?>" required>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="no_rangka">No Rangka</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="no_rangka" name="no_rangka" value="<?php echo $e['no_rangka'];?>" required>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="no_plat">No Plat</label>
			<div class="controls">
				<input class="input-small" type="text" id="no_plat" name="no_plat" value="<?php echo $e['no_plat'];?>" required>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="no_bpkb">No BPKB</label>
			<div class="controls">
				<input class="input-small" type="text" id="no_bpkb" name="no_bpkb" value="<?php echo $e['no_bpkb'];?>" required>
			</div>
		</div>		

		<div class="control-group">
			<label class="control-label" for="bpemegang">Pemegang</label>
			<div class="controls">
				<select class="span3 chosen-select" name="bpemegang" id="bpemegang" placeholder="Pilih Nama">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_pegawai WHERE kdkab='$kd' ORDER BY nama");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bpemegang']==$s['pNip']){
								echo "<option value='$s[pNip]' selected>$s[nama]</option>";
							}else{
								echo "<option value='$s[pNip]'>$s[nama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bkondisi">Kondisi</label>
			<div class="controls">
				<select class="span2 chosen-select" name="bkondisi" id="bkondisi" placeholder="Pilih Jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM _kondisi ORDER BY kondisi ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bkondisi']==$s['kondisi']){
								echo "<option value='$s[kondisi]' selected>$s[nama]</option>";
							}else{
								echo "<option value='$s[kondisi]'>$s[nama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="thn_per">Tahun Perolehan</label>
			<div class="controls">
				<select class="span2 chosen-select" name="thn_per" id="thn_per" placeholder="Pilih Tahun"><option>-- Pilih Tahun --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM _tahun ORDER BY tahun DESC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['thn_per']==$s['tahun']){
								echo "<option value='$s[tahun]' selected>$s[tahun]</option>";
							}else{
								echo "<option value='$s[tahun]'>$s[tahun]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="harga_per">Harga Perolehan</label>
			<div class="controls">
				<input class="input-small" type="text" id="harga_per" name="harga_per" value="<?php echo $e['harga_per'];?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="pagu">Pagu Perawatan</label>
			<div class="controls">
				<input class="input-small" type="text" id="pagu" name="pagu" value="<?php echo $e['pagu'];?>" >
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ket">Keterangan</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="ket" name="ket" value="<?php echo $e['ket'];?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="foto">Foto</label>
			<div class="controls">
				<?php
					$ptol = "Anda belum menginput gambar, ukuran file gambar tidak boleh lebih 1MB";
					if (!empty($e['foto'])){
						$gbrx ="<div class='span2'>
								<img class='pull-left' src='foto_kendi/$e[foto]' width='80%' margin='5px' data-rel='tooltip' data-placement='right' data-original-title='Foto Sekarang'>
								</div>";
						$ptol = "Abaikan jika gambar tidak diganti, ukuran file gambar tidak boleh lebih 1MB";
					}						
				?>
				<?php echo $gbrx;?>
				<div id="foto">
					<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="<?php echo $ptol;?>">
						<input type="file" name="fupload"> 
					</div>
				</div>
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
		
		$lokasi_file    = $_FILES['fupload']['tmp_name'];
	  		$tipe_file  = $_FILES['fupload']['type'];
	  		$nama_file  = $_FILES['fupload']['name'];
	  		$acak       = rand(1,99);
	  		$foto       = $acak.$nama_file;

			if (!empty($lokasi_file)){
				UploadKendi($foto);
				$ft = getValue("foto","kendi","bId='$_POST[bid]'");
				if (!$ft==""){
					unlink("foto_kendi/$ft");
				}

	
			$q = mysql_query("UPDATE kendi SET    bjenis='$_POST[bjenis]',
												  bmerek='$_POST[bmerek]',
												   btipe='$_POST[btipe]',
											    no_mesin='$_POST[no_mesin]',
	      									   no_rangka='$_POST[no_rangka]',
	      									     no_plat='$_POST[no_plat]',
	      										 no_bpkb='$_POST[no_bpkb]',
	      									    bkondisi='$_POST[bkondisi]',
	      									   bpemegang='$_POST[bpemegang]',							 
	      								         thn_per='$_POST[thn_per]',
	      									   harga_per='$_POST[harga_per]',
	      									         ket='$_POST[ket]',
	      									        foto='$foto',  
	      									        pagu='$_POST[pagu]',
	      										onUpdate=NOW()
										       WHERE bId='$idx'");	
			} else {

			$q = mysql_query("UPDATE kendi SET    bjenis='$_POST[bjenis]',
												  bmerek='$_POST[bmerek]',
												   btipe='$_POST[btipe]',
											    no_mesin='$_POST[no_mesin]',
	      									   no_rangka='$_POST[no_rangka]',
	      									     no_plat='$_POST[no_plat]',
	      										 no_bpkb='$_POST[no_bpkb]',
	      									    bkondisi='$_POST[bkondisi]',
	      									   bpemegang='$_POST[bpemegang]',							 
	      								         thn_per='$_POST[thn_per]',
	      									   harga_per='$_POST[harga_per]',
	      									         ket='$_POST[ket]',	
	      									        pagu='$_POST[pagu]',							       
	      										onUpdate=NOW()
										       WHERE bId='$idx'");	
										       	
			}	
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
		mysql_query("DELETE FROM kendi WHERE bId='$_GET[id]'");
		echo "<script>
			notifsukses('Sukses','Data Telah Dihapus..!!');
			setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			</script>";
		}
	
	if ($kd=='1200') {
		echo "
		<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='mkendi'>
			
			<select class='span2 chosen-select' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";
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
	<div class='table-header'>";
	if (!empty($_GET[kkb])) {
		echo "
		DATA INVENTARIS BPS $nmkab</div>";
	} else {
		echo"
		DATA INVENTARIS BPS PROVINSI SUMATERA UTARA</div>";
	}
	echo "
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    	<th class='center'>No</th>
	    	<th class='center'>Jenis</th>
	    	<th class='center'>Merek</th>
	    	<th class='center'>Tipe</th>
	    	<th class='center'>No Plat</th>	        
	    	<th class='center'>Pemegang</th>
	    	<th class='center'>Kondisi</th>
	    	<th class='center'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";

	$kd      = $_SESSION['dpkode'];
	$no=0;
	if (!empty($_GET[kkb])) {
	    $qry = mysql_query("SELECT * FROM kendi WHERE kdkab='$_GET[kkb]' ORDER BY onCreate DESC");
	    } else {
	   	$qry = mysql_query("SELECT * FROM kendi WHERE kdkab='1200' ORDER BY onCreate DESC");
	    }
		  
		while ($d = mysql_fetch_array($qry)){
	    $no++;
	    $kat = getValue("jenis","kendi_jen","id='$d[bjenis]'");
	    $merek = getValue("merek","kendi_merk","id='$d[bmerek]'");
	    $tipe = getValue("tipe","kendi_tipe","id='$d[btipe]'");
	    $kon = getValue("kondisi","_kondisi","id='$d[bkondisi]'");
	    $format = number_format ($d[harga_per], 0, ',', '.');
	    $pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	  
	    echo "
	    <tr>  
	   	  <td class='center'>$no</td>	        
	      <td class='left'>$kat</td>
	      <td class='left'>$merek</td>
	      <td class='left'>$tipe</td>	        
	      <td class='left'>$d[no_plat]</td>        
	      <td class='left'>$pemegang</td>
	      <td class='center'>";
	        
		    if ($kon =='1') {
			echo "<span class='badge badge-success'>Baik</span>";	
	    	} else if ($kon =='2') {
			echo "<span class='badge badge-warning'>Rusak Ringan</span>";
			} else {
			echo "<span class='badge badge-important'>Rusak Berat</span>";
			}

		  echo "
	      </td>         
	      <td class='center'>
		    <div class='inline position-relative'>		    
                <a href='?page=dkendi&id=$d[bId]&kd=$kd' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
                    <span class='orange'><i class='icon-search bigger-120'></i></span>
                </a>
                
                <a href='?page=$page&act=edit&id=$d[bId]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                <span class='green'><i class='icon-edit bigger-120'></i></span>
                </a>";
                if (($kd!=$d['kdkab']) OR ($ulevel!='0')) {
                  	echo "
                    --";
                } else {
                echo "
                <a href='?page=$page&mode=hapus&id=$d[bId]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
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
	<div class='table-header'>DATA KENDERAAN DINAS BPS $nmkab</div>
	<div class='row-fluid'>

	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    	<th class='center'>No</th>
	    	<th class='center'>Jenis</th>
	    	<th class='center'>Merek</th>
	    	<th class='center'>Tipe</th>
	    	<th class='center'>No Plat</th>	        
	    	<th class='center'>Pemegang</th>
	    	<th class='center'>Kondisi</th>
	    	<th class='center'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";
	    $no=0;
	    $qry = mysql_query("SELECT * FROM kendi WHERE kdkab='$kd' AND status=1 ORDER BY onCreate DESC");
	
		while ($d = mysql_fetch_array($qry)){
	    $no++;
	    $kat = getValue("jenis","kendi_jen","id='$d[bjenis]'");
	    $merek = getValue("merek","kendi_merk","id='$d[bmerek]'");
	    $tipe = getValue("tipe","kendi_tipe","id='$d[btipe]'");
	    $kon = getValue("kondisi","_kondisi","id='$d[bkondisi]'");
	    $format = number_format ($d[harga_per], 0, ',', '.');
	    $pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	  
	    echo "
	    <tr>
	        <td class='center'>$no</td>	        
	        <td class='left'>$kat</td>
	        <td class='left'>$merek</td>
	        <td class='left'>$tipe</td>	        
	        <td class='left'>$d[no_plat]</td>        
	        <td class='left'>$pemegang</td>
	        <td class='center'>";	      
		  
		    if ($kon =='1') {
			echo "<span class='badge badge-success'>Baik</span>";	
	    	} else if ($kon =='2') {
			echo "<span class='badge badge-warning'>Rusak Ringan</span>";
			} else {
			echo "<span class='badge badge-important'>Rusak Berat</span>";
			}

		  echo "
	      </td>          
	      <td class='center'>
		    <div class='inline position-relative'>
		    	<a href='?page=dkendi&id=$d[bId]&kd=$kd' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
                    <span class='orange'><i class='icon-search bigger-120'></i></span>
                </a>                
                <a href='?page=$page&act=edit&id=$d[bId]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                <span class='green'><i class='icon-edit bigger-120'></i></span>
                </a>";
                if ($ulevel!='0') {
                  	echo "
                    -";
                } else {
                echo "
                <a href='?page=$page&mode=hapus&id=$d[bId]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                </a>";
            }
                echo"
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

