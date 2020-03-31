<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>MASTER INVENTARIS</h1>
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
	$bid = "DP.300317.".getANum("bkode","barang","1",10);
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
				<select class="span5 chosen-select" name="bjenis" id="bjenis" placeholder="Pilih Kategori">
				<option>-- Pilih Jenis --</option>
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
				<select class="span5 chosen-select" name="bmerek" id="bmerek" placeholder="Pilih Jenis">
				<option>-- Pilih Merek --</option>
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
				<select class="span5 chosen-select" name="btipe" id="btipe" placeholder="Pilih Jenis">
				<option>-- Pilih Tipe --</option>
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
			<label class="control-label" for="stok">Stok</label>
			<div class="controls">
				<select class="span3" name="stok" id="stok" placeholder="Pilih Status Stok">
					<?php
						$qsp = mysql_query("SELECT * FROM _stok ORDER BY id");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['stok']==$s['id']){
								echo "<option value='$s[id]' selected>$s[status]</option>";
							}else{
								echo "<option value='$s[id]'>$s[status]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ip">IP Address</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="ip" name="ip" value="<?php echo $e['ip'];?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ket">Keterangan</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="ket" name="ket" value="<?php echo $e['ket'];?>">
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
			$q = mysql_query("INSERT INTO barang (kdkab,bkode,bjenis,bmerek,btipe,stok,bserial,bkondisi,bpemegang,btgl,ip,ket,onCreate)
	      											VALUES('$kd','$bid','$_POST[bjenis]','$_POST[bmerek]',
	      													 '$_POST[btipe]','$_POST[stok]','$_POST[bserial]','$_POST[bkondisi]','$_POST[bpemegang]','$tgls','$_POST[ip]','$_POST[ket]',NOW())");
	      
			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!! ');
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
			
				<input class="input-xlarge" type="text" id="bkode" name="bkode" readonly = "readonly" value="<?php echo $e[bkode]; ?>" required>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="bjenis">Jenis</label>
			<div class="controls">
				<select class="span3" name="bjenis" id="bjenis" placeholder="Pilih Kategori">
					<?php
						$qsp = mysql_query("SELECT * FROM ms_kategori ORDER BY kNama ASC");
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
			<label class="control-label" for="bkondisi">Kondisi</label>
			<div class="controls">
				<select class="span3" name="bkondisi" id="bkondisi" placeholder="Pilih Jenis">
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
			<label class="control-label" for="bpemegang">Pemegang</label>
			<div class="controls">
				<select class="span3" name="bpemegang" id="bpemegang" placeholder="Pilih Nama">
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
			<label class="control-label" for="stok">Stok</label>
			<div class="controls">
				<select class="span3" name="stok" id="stok" placeholder="Pilih Status Stok">
					<?php
						$qsp = mysql_query("SELECT * FROM _stok ORDER BY id");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['stok']==$s['id']){
								echo "<option value='$s[id]' selected>$s[status]</option>";
							}else{
								echo "<option value='$s[id]'>$s[status]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ip">IP Address</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="ip" name="ip" value="<?php echo $e['ip'];?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="ket">Keterangan</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="ket" name="ket" value="<?php echo $e['ket'];?>">
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
			
			$q = mysql_query("UPDATE barang SET    bjenis='$_POST[bjenis]',
												   bmerek='$_POST[bmerek]',
												    btipe='$_POST[btipe]',
												     stok='$_POST[stok]',
	      										  bserial='$_POST[bserial]',
	      										bpemegang='$_POST[bpemegang]',
	      										 bkondisi='$_POST[bkondisi]',
	      										       ip='$_POST[ip]',
	      										      ket='$_POST[ket]',
	      										 onUpdate=NOW()
										        WHERE bId='$idx'");		
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
		mysql_query("DELETE FROM barang WHERE bId='$_GET[id]'");
		echo "<script>
			notifsukses('Sukses','Data Telah Dihapus..!!');
			setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			</script>";
		}
	
	if ($kd=='1200' or $kd=='1000') {
		echo "
		<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='minv'>
			
			<select class='span2' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";
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
	    <th class='center' width='40px'>ID</th>
	    <th class='center'>Kode</th>
	    <th class='center'>Jenis</th>
	    <th class='center'>Merek</th>
	    <th class='center'>Tipe</th>
	    <th class='center'>Serial</th>
	    <th class='center'>Kondisi</th>
	    <th class='center'>Pemegang</th>
	    <th class='center'>Lokasi</th>
	    <th class='center'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";

	$kd=$_SESSION['dpkode'];
	$no=0;
	if (!empty($_GET[kkb])) {
	    $qry = mysql_query("SELECT * FROM barang WHERE kdkab='$_GET[kkb]' ORDER BY onCreate DESC");
	    } else {
	   	$qry = mysql_query("SELECT * FROM barang WHERE kdkab='1200' ORDER BY onCreate DESC");
	    }
		  
		while ($d = mysql_fetch_array($qry)){
	    $no++;
	    $kat = getValue("kNama","ms_kategori","kId='$d[bjenis]'");
	    $merek = getValue("merek","ms_merek","rMerek='$d[bmerek]'");
	    $tipe = getValue("tipe","ms_tipe","rTipe='$d[btipe]'");
	    $tahun = getValue("thnper","ms_tipe","rTipe='$d[btipe]'");
	    $nilai = getValue("nperolehan","ms_tipe","rTipe='$d[btipe]'");
	    $garansi = getValue("garansi","ms_tipe","rTipe='$d[btipe]'");
	    $kon = getValue("kondisi","_kondisi","id='$d[bkondisi]'");
	    $asal = getValue("jNama","_jpengadaan","jId='$d[basal]'");
	    $format = number_format ($d[nilai], 0, ',', '.');
	    $pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	  	$lokasi = getValue("pRuang","penempatan","pInv='$d[bkode]'");
	  	$nlokasi = getValue("rNama","ms_ruangan","idruang='$lokasi'");

	    echo "
	    <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$d[bkode]</td>
	      <td class='left'>$kat</td>
	      <td class='left'>$merek</td>
	      <td class='left'>$tipe</td>
	      <td class='left'>$d[bserial]</td>
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
          <td class='left'>$pemegang</td>
          <td class='left'>$nlokasi</td>
	      <td class='center'>
		    <div class='inline position-relative'>";
		    if ($kd!=$d['kdkab']) {
                  	echo "
                    ---";
                } else {
                echo "
                <a href='?page=$page&act=edit&id=$d[bId]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                <span class='green'><i class='icon-edit bigger-120'></i></span>
                </a>
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
	<div class='table-header'>DATA INVENTARIS BPS $nmkab</div>
	<div class='row-fluid'>

	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    <th class='center' width='40px'>ID</th>
	    <th class='center'>Kode</th>
	    <th class='center'>Jenis</th>
	    <th class='center'>Merek</th>
	    <th class='center'>Tipe</th>
	    <th class='center'>Serial</th>
	    <th class='center'>Kondisi</th>
	    <th class='center'>Pemegang</th>
	    <th class='center'>Lokasi</th>
	    <th class='center'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";
	$no=0;
	    $qry = mysql_query("SELECT * FROM barang WHERE kdkab='$kd' ORDER BY onCreate DESC");
	
		while ($d = mysql_fetch_array($qry)){
	    $no++;
	    $kat = getValue("kNama","ms_kategori","kId='$d[bjenis]'");
	    $merek = getValue("merek","ms_merek","rMerek='$d[bmerek]'");
	    $tipe = getValue("tipe","ms_tipe","rTipe='$d[btipe]'");
	    $tahun = getValue("thnper","ms_tipe","rTipe='$d[btipe]'");
	    $nilai = getValue("nperolehan","ms_tipe","rTipe='$d[btipe]'");
	    $garansi = getValue("garansi","ms_tipe","rTipe='$d[btipe]'");
	    $kon = getValue("kondisi","_kondisi","id='$d[bkondisi]'");
	    $asal = getValue("jNama","_jpengadaan","jId='$d[basal]'");
	    $format = number_format ($d[nilai], 0, ',', '.');
	    $pemegang = getValue("nama","ms_pegawai","pNip='$d[bpemegang]'");
	  	$lokasi = getValue("pRuang","penempatan","pInv='$d[bkode]'");
	  	$nlokasi = getValue("rNama","ms_ruangan","idruang='$lokasi'");

	    echo "
	    <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$d[bkode]</td>
	      <td class='left'>$kat</td>
	      <td class='left'>$merek</td>
	      <td class='left'>$tipe</td>
	      <td class='left'>$d[bserial]</td>
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
          <td class='left'>$pemegang</td>
          <td class='left'>$nlokasi</td>
	      <td class='center'>
		    <div class='inline position-relative'>
                <a href='?page=$page&act=edit&id=$d[bId]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                <span class='green'><i class='icon-edit bigger-120'></i></span>
                </a>
                <a href='?page=$page&mode=hapus&id=$d[bId]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
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

