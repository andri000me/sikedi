<div class="row-fluid">
<div class="span7">
<?php

$kd    = $_SESSION['dpkode'];
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
			<label class="control-label" for="jenis">Jenis</label>
			<div class="controls">
				<select class="span3" name="jenis" id="jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_jen ORDER BY id ASC");
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
			<label class="control-label" for="merek">Merek</label>
			<div class="controls">
				<select class="span3" name="merek" id="merek">
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
			<label class="control-label" for="tipe">Tipe</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="tipe" name="tipe" value="<?php echo $e['tipe'];?>" required>
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
			
		  	$q = mysql_query("INSERT INTO kendi_tipe (merek,tipe)
		  					  VALUES('$_POST[merek]','$_POST[tipe]')
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
$e = mysql_fetch_array(mysql_query("SELECT * FROM kendi_tipe WHERE id='$_GET[id]'"));

?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="jenis">Jenis</label>
			<div class="controls">
				<select class="span3" name="jenis" id="jenis">
					<?php
						$qsp = mysql_query("SELECT * FROM kendi_jen ORDER BY id ASC");
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
			<label class="control-label" for="merek">Merek</label>
			<div class="controls">
				<select class="span3" name="merek" id="merek">
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
			<label class="control-label" for="tipe">Tipe</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="tipe" name="tipe" value="<?php echo $e['tipe'];?>" required>
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
			
			$q = mysql_query("UPDATE kendi_tipe SET    jen ='$_POST[jenis]',
													 merek ='$_POST[merek]',
											          tipe ='$_POST[tipe]'
											      WHERE id ='$_GET[id]'");
			
		  	
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
	if ($kd=='1200') {
	echo "
	<a href='?page=$page&act=tambah' class='btn btn-primary'>
		<i class='icon-download-alt bigger-100'></i>Tambah
	</a><br><br>";
	} else {
		echo " ";
	}
		if ($_GET['mode']=="hapus"){
			mysql_query("DELETE FROM kendi_tipe WHERE id='$_GET[id]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
				   </script>";
		}
	?>
	<div class="table-header">
	   DATA TIPE KENDERAAN DINAS BPS PROVINSI SUMATERA UTARA
	</div>
	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="40px">No</th>
	    <th class="center" width="100px">Jenis</th>
	    <th class="center">Merek</th>
	    <th class="center">Tipe</th>	   
	    <th class="center" width="60px">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	    $qry = mysql_query("SELECT * FROM kendi_tipe ORDER BY jen ASC");
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      $jj = getValue("jenis","kendi_jen","id='$d[jen]'");
	      $jm = getValue("merek","kendi_merk","id='$d[merek]'");	      
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$jj</td>
	      <td class='left'>$jm</td>
	      <td class='left'>$d[tipe]</td>	      
	      <td class='center'>
            <div class='inline position-relative'>";
            if ($kd == '1200') {
            echo "
                  	<a href='?page=$page&act=edit&id=$d[id]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
                     </a>&nbsp;
              
                  	<a href='?page=$page&mode=hapus&id=$d[id]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                     </a>";
             } else {
       			echo "---";
       		}
       		echo "  
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