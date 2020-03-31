<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>DATA INVENTARIS</h1>
</div>
<?php
$ulevel = $_SESSION['dpLevel'];
$kd     = $_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$ntgls = date("dmy");
$tgls = date("d-m-Y");
$page = $_GET['page'];
if($_GET['act']=="tambah"){
	$gn = getANum("bkode","barang","1",10);
	$bid = "IT.".$ntgls.".".getANum("bkode","barang","1",10);
	//echo $bid."<br>".$gn;
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
			
				<input class="input-xlarge" type="text" id="bkode" name="bkode" readonly = "readonly" value="<?php echo $bid; ?>" required>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="bjenis">Jenis</label>
			<div class="controls">
				<select class="span3" name="bjenis" id="bjenis" placeholder="Pilih Kategori">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_kategori ORDER BY kNama ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bKat']==$s['kId']){
								echo "<option value='$s[kId]' selected>$s[kNama]</option>";
							}else{
								echo "<option value='$s[kId]'>$s[kNama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="bmerek">Merek</label>
			<div class="controls">
				<select class="span3" name="bmerek" id="bmerek" placeholder="Pilih Jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_merek ORDER BY merek ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bmerek']==$s['rMerek']){
								echo "<option value='$s[rMerek]' selected>$s[merek]</option>";
							}else{
								echo "<option value='$s[rMerek]'>$s[merek]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="btipe">Tipe</label>
			<div class="controls">
				<select class="span3" name="btipe" id="btipe" placeholder="Pilih Jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_tipe ORDER BY tipe");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['btipe']==$s['rTipe']){
								echo "<option value='$s[rTipe]' selected>$s[tipe]</option>";
							}else{
								echo "<option value='$s[rTipe]'>$s[tipe]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bserial">Serial</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="bserial" name="bserial" value="<?php echo $e['bserial'];?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="asal">Asal Perolehan</label>
			<div class="controls">
				<select class="span3" name="asal" id="asal" placeholder="Pilih Asal Pengadaan">
					<?php
						$qsp = mysql_query("SELECT * FROM _pengadaan ORDER BY id ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['basal']==$s['id']){
								echo "<option value='$s[id]' selected>$s[sumber]</option>";
							}else{
								echo "<option value='$s[id]'>$s[sumber]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>


		<div class="control-group">
			<label class="control-label" for="bkondisi">Kondisi</label>
			<div class="controls">
				<select class="span3" name="bkondisi" id="bkondisi" placeholder="Pilih Jenis">
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
			<label class="control-label" for="bpemegang">Pemegang</label>
			<div class="controls">
				<select class="span3" name="bpemegang" id="bpemegang" placeholder="Pilih Nama">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_pegawai ORDER BY nama");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bpemegang']==$s['nama']){
								echo "<option value='$s[nama]' selected>$s[nama]</option>";
							}else{
								echo "<option value='$s[nama]'>$s[nama]</option>";
							}
						}
					?>
				</select>
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
		$jenis = $_POST[bjenis];
		$merek = $_POST[bmerek];
		$tipe  = $_POST[btipe];
		$gn    = getANum("bkode","barang","1",10);
	    $bid   = "IT.".$ntgls.".".getANum("bkode","barang","1",10);

				$q = mysql_query("INSERT INTO barang (bkode,bjenis,bmerek,btipe,bserial,bpemegang,bkondisi,basal,btgl)
	      											VALUES('$bid','$_POST[bjenis]','$_POST[bmerek]',
	      													 '$_POST[btipe]','$_POST[bserial]','$_POST[bpemegang]','$_POST[bkondisi]','$_POST[asal]',NOW())");
	      
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
$e = mysql_fetch_array(mysql_query("SELECT * FROM barang WHERE bId='$_GET[id]' GROUP BY bId"));
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
				<input class="input-xlarge" type="text" id="bkode" name="bkode" value="<?php echo $e['bkode'];?>"  disabled required>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="bjenis">Jenis</label>
			<div class="controls">
				<select class="span3" name="bjenis" id="bjenis" placeholder="Pilih Kategori">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_kategori");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bjenis']==$s['kId']){
								echo "<option value='$s[kId]' selected>$s[kNama]</option>";
							}else{
								echo "<option value='$s[kId]'>$s[kNama]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="bmerek">Merek</label>
			<div class="controls">
				<select class="span3" name="bmerek" id="bmerek" placeholder="Pilih Jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_merek");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bmerek']==$s['rMerek']){
								echo "<option value='$s[rMerek]' selected>$s[merek]</option>";
							}else{
								echo "<option value='$s[rMerek]'>$s[merek]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="btipe">Tipe</label>
			<div class="controls">
				<select class="span3" name="btipe" id="btipe" placeholder="Pilih Jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_tipe");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['btipe']==$s['rTipe']){
								echo "<option value='$s[rTipe]' selected>$s[tipe]</option>";
							}else{
								echo "<option value='$s[rTipe]'>$s[tipe]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bserial">Serial</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="bserial" name="bserial" value="<?php echo $e['bserial'];?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="basal">Asal Perolehan</label>
			<div class="controls">
				<select class="span3" name="basal" id="basal" placeholder="Pilih Asal Pengadaan">
					<?php
						$qsp = mysql_query("SELECT * FROM _pengadaan ORDER BY id ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['basal']==$s['id']){
								echo "<option value='$s[id]' selected>$s[sumber]</option>";
							}else{
								echo "<option value='$s[id]'>$s[sumber]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bkondisi">Kondisi</label>
			<div class="controls">
				<select class="span3" name="bkondisi" id="bkondisi" placeholder="Pilih Jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM _kondisi ORDER BY kondisi ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bkondisi']==$s['id']){
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
			<label class="control-label" for="bpemegang">Pemegang</label>
			<div class="controls">
				<select class="span3" name="bpemegang" id="bpemegang" placeholder="Pilih Jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_pegawai ORDER BY nama");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['bpemegang']==$s['nama']){
								echo "<option value='$s[nama]' selected>$s[nama]</option>";
							}else{
								echo "<option value='$s[nama]'>$s[nama]</option>";
							}
						}
					?>
				</select>
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
			
			$q = mysql_query("UPDATE barang SET bjenis='$_POST[bjenis]',
												bmerek='$_POST[bmerek]',
												btipe='$_POST[btipe]',
	      										bserial='$_POST[bserial]',
	      										bpemegang='$_POST[bpemegang]',
	      										bkondisi='$_POST[bkondisi]',
	      										basal='$_POST[basal]',
												onUpdate=NOW()
										  WHERE bId='$_POST[bId]'");		
			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!! $_POST[bjenis]');
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
	if ($_GET['mode']=="hapus"){
			mysql_query("DELETE FROM barang WHERE bId='$_GET[id]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
				   </script>";
}
?>

<?php
	if ($kd=='1200' or $kd=='1000') {
		echo "
		<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='inv'>			
			<select class='span2' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";					
				$qsp = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
				while ($s=mysql_fetch_array($qsp)) 
				{
				echo "<option value='$s[id_kabkot]'>$s[nama_kabkot]</option>";
				}						
			echo "
			</select>
			<button type='submit' class='btn btn-primary btn-small'>
				Filter
				<i class='icon-search icon-on-right bigger-110'></i>
			</button>
			<a href='?page=inv' type='button' class='btn btn-primary btn-small'>
				Reset
				<i class='icon-refresh icon-on-right bigger-110'></i>
			</a>
		</form>";
	
	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$_GET[kkb]'"));
	if (!empty($_GET[kkb])) {
		$kkb = $_GET[kkb];
	} else {
		$kkb = "1200";
	}
	echo "
	<div class='table-header'>";
	if (!empty($_GET[kkb])) {
		echo "
		REKAP INVENTARIS BPS $nmkab</div>";
	} else {
		echo"
		REKAP INVENTARIS BPS PROVINSI SUMATERA UTARA</div>";
	}
	echo "
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    <th class='center' width='40px'>No</th>
	    <th class='center' width='100px'>Jenis</th>
	    <th class='center' width='120px'>Merek</th>
	    <th class='center' width='160px'>Tipe</th>
	    <th class='center' width='120px'>Tahun Perolehan</th>
	    <th class='center' width='140px'>Nilai Perolehan</th>
	    <th class='center' width='160px'>Asal Pengadaan</th>
	    <th class='center' width='40px'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";	 
	$no=0;
	    $qry = mysql_query("SELECT * FROM ms_tipe ORDER BY rTipe ASC");
		while ($d = mysql_fetch_array($qry))
		{
	      	$no++;
	      	$kat = getValue("kNama","ms_kategori","kId='$d[idjen]'");
	      	$merek = getValue("merek","ms_merek","rMerek='$d[idmerek]'");
	      	$asal = getValue("sumber","_pengadaan","id='$d[asal]'");
	      	$format = number_format ($d[nperolehan], 0, ',', '.');

	      	echo "
	      	<tr>
	      		<td class='center'>$no</td>
	      		<td class='left'>$kat</td>
	      		<td class='left'>$merek</td>
	      		<td class='left'>$d[tipe]</td>
	      		<td class='center'>$d[thnper]</td>
	      		<td class='right'>Rp. $format</td>
	      		<td class='left'>$asal</td>
	      		<td class='center'>
		    	<div class='inline position-relative'>";
		    	
		    	echo "
                <a href='?page=dinv&j=$d[idjen]&m=$d[idmerek]&t=$d[rTipe]&kd=$kkb' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
                    <span class='orange'><i class='icon-search bigger-120'></i></span>
                </a>
                </div>
		    </td>";
		}
		?> 
	        </tr>
	<?php
	} else {
	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$kd'"));
	echo "
	<div class='table-header'>REKAP INVENTARIS $nmkab</div>
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    <th class='center' width='40px'>No</th>
	    <th class='center' width='100px'>Jenis</th>
	    <th class='center' width='120px'>Merek</th>
	    <th class='center' width='160px'>Tipe</th>
	    <th class='center' width='120px'>Tahun Perolehan</th>
	    <th class='center' width='140px'>Nilai Perolehan</th>
	    <th class='center' width='160px'>Asal Pengadaan</th>
	    <th class='center' width='40px'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";	 
	$no=0;
	    $qry = mysql_query("SELECT * FROM ms_tipe ORDER BY rTipe ASC");
		while ($d = mysql_fetch_array($qry))
		{
	      	$no++;
	      	$kat = getValue("kNama","ms_kategori","kId='$d[idjen]'");
	      	$merek = getValue("merek","ms_merek","rMerek='$d[idmerek]'");
	      	$asal = getValue("sumber","_pengadaan","id='$d[asal]'");
	      	$format = number_format ($d[nperolehan], 0, ',', '.');

	      	echo "
	      	<tr>
	      		<td class='center'>$no</td>
	      		<td class='left'>$kat</td>
	      		<td class='left'>$merek</td>
	      		<td class='left'>$d[tipe]</td>
	      		<td class='center'>$d[thnper]</td>
	      		<td class='right'>Rp. $format</td>
	      		<td class='left'>$asal</td>
	      		<td class='center'>
		    	<div class='inline position-relative'>
                <a href='?page=dinv&j=$d[idjen]&m=$d[idmerek]&t=$d[rTipe]&kd=$kd' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
                    <span class='orange'><i class='icon-search bigger-120'></i></span>
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