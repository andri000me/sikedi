<div class="row-fluid">
<div class="span12">
<?php
$kd=$_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$page = $_GET['page'];
if($_GET['act']=="tambah"){
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Tambah</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="niplama">Nip Lama</label>
			<div class="controls">
				<input class="input-medium" type="text" id="niplama" name="niplama" value="<?php echo $e['niplama'];?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pNip">Nip</label>
			<div class="controls">
				<input class="input-medium" type="text" id="pNip" name="pNip" value="<?php echo $e['pNip'];?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="nama">Nama</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="nama" name="nama" value="<?php echo $e['nama'];?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="kdkab">Kab/Kota</label>
			<div class="controls">
				<select class="span2" name="kdkab" id="kdkab">
					<?php
						$qsp = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['nama_kabkot']==$s['id_kabkot']){
								echo "<option value='$s[id_kabkot]' selected>$s[nama_kabkot]</option>";	
							}else{
								echo "<option value='$s[id_kabkot]'>$s[nama_kabkot]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="email">Email</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="email" name="email" value="<?php echo $e['email'];?>" required>
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
			echo nama;
			echo pKode;
			echo email;
		  	$q = mysql_query("INSERT INTO ms_pegawai (pNip,kdkab,nama,email,niplama,onCreate)
		  											VALUES('$_POST[pNip]','$_POST[kdkab]','$_POST[nama]','$_POST[email]','$_POST[niplama]',NOW())
		                    ");
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
}elseif($_GET['act']=="edit"){
$e = mysql_fetch_array(mysql_query("SELECT * FROM ms_pegawai WHERE pNip='$_GET[id]'"));
$idx = $e['pNip'];
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="niplama">Nip Lama</label>
			<div class="controls">
				<input class="input-medium" type="text" id="niplama" name="niplama" value="<?php echo $e['niplama'];?>" readonly required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="pNip">Nip</label>
			<div class="controls">
				<input class="input-medium" type="text" id="pNip" name="pNip" value="<?php echo $e['pNip'];?>" readonly required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="kdkab">Kab/Kota</label>
			<div class="controls">
				<select class="span2" name="kdkab" id="kdkab">
					<?php
						$qsp = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['kdkab']==$s['id_kabkot']){
								echo "<option value='$s[id_kabkot]' selected>$s[nama_kabkot]</option>";	
							}else{
								echo "<option value='$s[id_kabkot]'>$s[nama_kabkot]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="nama">Nama</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="nama" name="nama" value="<?php echo $e['nama'];?>" required>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="email">Email</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="email" name="email" value="<?php echo $e['email'];?>" required>
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
			
			$q = mysql_query("UPDATE ms_pegawai SET     pNip ='$_POST[pNip]',
				                                       kdkab ='$_POST[kdkab]',
													    nama ='$_POST[nama]',
													   email ='$_POST[email]',
													 niplama ='$_POST[niplama]',
											     	onUpdate =NOW()
									     		  WHERE pNip ='$_POST[pNip]'");
			
		  	
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
}else{
?>
	<a href="?page=<?php echo $page;?>&act=tambah" class="btn btn-primary">
		<i class="icon-download-alt bigger-100"></i>Tambah
	</a><br><br>
	<?php
		if ($_GET['mode']=="hapus"){
			mysql_query("DELETE FROM ms_pegawai WHERE pNip='$_GET[id]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
				   </script>";
		}
	?>
	
	<div class="table-header">
	   DATA MASTER PEGAWAI MENURUT BPS KABUPATEN/KOTA
	</div><br>
		<form class="form-search" method="GET">
			<input type="hidden" name="page" value="mpegawai">
			
			<select class="span2" id="kkb" name="kkb" data-placeholder="Pilih Satker">
					<?php
					if ($kd =='1200') {
						$qsp = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
					} else {
						$qsp = mysql_query("SELECT * FROM kdkab WHERE id_kabkot ='$kd' ORDER BY id_kabkot ASC");

					}
						while ($s=mysql_fetch_array($qsp)) {
							echo "<option value='$s[id_kabkot]'>$s[nama_kabkot]</option>";
						}
						
					?>
			</select>

			<button type="submit" class="btn btn-primary btn-small">
				Filter
				<i class="icon-search icon-on-right bigger-110"></i>
			</button>
			<a href="?page=mpegawai" type="button" class="btn btn-primary btn-small">
				Reset
				<i class="icon-refresh icon-on-right bigger-110"></i>
			</a>
		</form>

	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center">No</th>
	    <th class="center">Nip Lama</th>
	    <th class="center">Nip</th>
	    <th class="center">KdKab</th>
	    <th class="center">Nama</th>
	    <th class="center">Email</th>
	    <th class="center">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	 if ($kd =='1200') {
	 	$qry = mysql_query("SELECT * FROM ms_pegawai WHERE kdkab = '$_GET[kkb]' ORDER BY nama ASC");
	 } else {
	    $qry = mysql_query("SELECT * FROM ms_pegawai WHERE kdkab = '$kd' ORDER BY nama ASC");
	 }
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      //$jr = getValue("rNama","ms_ruangan","rKode='$d[rJenis]'");
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='center'>$d[niplama]</td>
	      <td class='center'>$d[pNip]</td>
	      <td class='left'>$d[kdkab]</td>
	      <td class='left'>$d[nama]</td>
	      <td class='left'>$d[email]@bps.go.id</td>
	      <td class='left'>
            <div class='inline position-relative'>
               	<a href='?page=$page&act=edit&id=$d[pNip]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
                </a>&nbsp;
                <a href='?page=$page&mode=hapus&id=$d[pNip]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                </a>
               
            </div>
	      </td>
	      </tr>";
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