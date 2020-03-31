<div class="row-fluid">
<div class="span12">
<?php
$kd=$_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$page = $_GET['page'];
if($_GET['act']=="tambah"){
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Tambah Master Wilayah</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="kode">Kode</label>
			<div class="controls">
				<input class="input-small" type="text" id="kode" name="kode" value="<?php echo $e['kode'];?>" required>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="nama">Nama Wilayah</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="nama" name="nama" value="<?php echo $e['nama'];?>" required>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="ibukota">Nama Ibu Kota</label>
			<div class="controls">
				<input class="input-large" type="text" id="ibukota" name="ibukota" value="<?php echo $e['ibukota'];?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="gbr">Foto</label>
			<div class="controls">
				<div id="gbr">
					<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="Ukuran File Gambar Tidak Boleh Lebih 1MB">
						<input type="file" name="fupload"> 
					</div>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="kor">Koordinat Kantor</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="kor" name="kor" value="<?php echo $e['kor'];?>" >
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
	  		$foto 		    = $acak.$nama_file;

			if (!empty($lokasi_file)){
				UploadKantor($foto);
				$ft = getValue("gbr","kdkab","id_prov='$_POST[id]'");
				if (!$ft==""){
					unlink("foto_kantor/$ft");
				}

		  		$q = mysql_query("INSERT INTO kdkab (id_kabkot,nama_kabkot,ibukota,gbr,kor)
		  				      VALUES('$_POST[kode]','$_POST[nama]','$_POST[ibukota]','$foto','$_POST[kor]')");
				} else {

				$q = mysql_query("INSERT INTO kdkab (id_kabkot,nama_kabkot,ibukota,kor)
		  				      VALUES('$_POST[kode]','$_POST[nama]','$_POST[ibukota]','$_POST[kor]')");

			}

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
$e = mysql_fetch_array(mysql_query("SELECT * FROM kdkab WHERE id_prov='$_GET[id]'"));

?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit Master Wilayah</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="kode">Kode</label>
			<div class="controls">
				<input class="input-small" type="text" id="kode" name="kode" value="<?php echo $e['id_kabkot'];?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="nama">Nama Wilayah</label>
			<div class="controls">
				<input class="input-xlarge" type="text" id="nama" name="nama" value="<?php echo $e['nama_kabkot'];?>" required>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="ibukota">Nama Ibu Kota</label>
			<div class="controls">
				<input class="input-large" type="text" id="ibukota" name="ibukota" value="<?php echo $e['ibukota'];?>" required>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="gbr">Foto</label>
			<div class="controls">
				<?php
					$ptol = "Anda belum menginput gambar, ukuran file gambar tidak boleh lebih 1MB";
					if (!empty($e['gbr'])){
						$gbrx ="<div class='span2'>
								<img class='pull-left' src='foto_kantor/$e[gbr]' width='80%' margin='5px' data-rel='tooltip' data-placement='right' data-original-title='Foto Sekarang'>
								</div>";
						$ptol = "Abaikan jika gambar tidak diganti, ukuran file gambar tidak boleh lebih 1MB";
					}						
				?>
				<?php echo $gbrx;?>
				<div id="gbr">
					<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="<?php echo $ptol;?>">
						<input type="file" name="fupload"> 
					</div>
				</div>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="kor">Koordinat Kantor</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="kor" name="kor" value="<?php echo $e['kor'];?>" required>
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
	  		$foto 		    = $acak.$nama_file;

			if (!empty($lokasi_file)){
				UploadKantor($foto);
				$ft = getValue("gbr","kdkab","id_prov='$_GET[id]'");
				if (!$ft==""){
					unlink("foto_kantor/$ft");
				}

			$q = mysql_query("UPDATE kdkab SET      id_kabkot = '$_POST[kode]',
				                                  nama_kabkot = '$_POST[nama]',
												      ibukota = '$_POST[ibukota]',
										                  gbr = '$foto',
									                      kor = '$_POST[kor]'
			                      		        WHERE id_prov = '$_GET[id]'");
			
		  	} else {

		  	$q = mysql_query("UPDATE kdkab SET      id_kabkot = '$_POST[kode]',
				                                  nama_kabkot = '$_POST[nama]',
												      ibukota = '$_POST[ibukota]',		                
									                      kor = '$_POST[kor]'
			                      		        WHERE id_prov = '$_GET[id]'");

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
$kd=$_SESSION['dpkode'];
if ($kd=='1200') {
echo "
	<a href='?page=$page&act=tambah' class='btn btn-primary'>
		<i class='icon-download-alt bigger-100'></i>Tambah
	</a><br><br>";

echo "
	<div class='table-header'>
	DATA MASTER WILAYAH BPS PROVINSI SUMATERA UTARA
	</div><br>
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    <th class='center'>No</th>
	    <th class='center'>Kode</th>
	    <th class='center'>Nama Wilayah</th>
	    <th class='center'>Ibu Kota</th>
	    <th class='center'>Gambar</th>
	    <th class='center'>Koordinat</th>
	    <th class='center' width='40px'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";
	 	
	    $qry = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      $jr = getValue("jNama","_jruangan","jId='$d[rJenis]'");
	      echo "
	      <tr>
	       <td class='center'>$no</td>
	      <td class='center'>$d[id_kabkot]</td>
	      <td class='left'>$d[nama_kabkot]</td>
	      <td class='left'>$d[ibukota]</td>";
	      if (empty($d[gbr])) {
	      	echo "<td class='left'>$d[gbr]</td>";
	      } else {
	      echo "
	      <td class='center'>
			<a href='foto_kantor/$d[gbr]'><img src='foto_kantor/$d[gbr]' width='80' margin='5px' data-rel='tooltip' data-placement='right' data-original-title='BPS $d[nama_kabkot]'></a></td>";
		  }
	      if (empty($d[kor])) { 
	      echo "     	    
	      <td class='center'>-</td>";
	  	  } else {
	  	  echo "
	  	  <td class='center'><a href='$d[kor]'>open in maps</a></td>";
	  	  }
	      echo "
	        <td class='center'>
            <div class='inline position-relative'>
           		
                    <a href='?page=$page&act=edit&id=$d[id_prov]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
                    </a>&nbsp;
              
                  	<a href='?page=$page&mode=hapus&id=$d[id_prov]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                    </a>";
                
               echo "
            </div>
	      </td>
	      </tr>";
	      }
	  	} else {

	

	echo "
	<div class='table-header'>
	DATA MASTER WILAYAH BPS PROVINSI SUMATERA UTARA
	</div><br>
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    <th class='center'>No</th>
	    <th class='center'>Kode</th>
	    <th class='center'>Nama Wilayah</th>
	    <th class='center'>Ibu Kota</th>
	    <th class='center'>Gambar</th>
	    <th class='center'>Koordinat</th>
	    <th class='center' width='40px'>Aksi</th>
	    </tr>
	</thead>
	<tbody>";
	 	
	    $qry = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      $jr = getValue("jNama","_jruangan","jId='$d[rJenis]'");
	      echo "
	      <tr>
	       <td class='center'>$no</td>
	      <td class='center'>$d[id_kabkot]</td>
	      <td class='left'>$d[nama_kabkot]</td>
	      <td class='left'>$d[ibukota]</td>";
	      if (empty($d[gbr])) {
	      	echo "<td class='left'>$d[gbr]</td>";
	      } else {
	      echo "
	      <td class='center'>
			<a href='foto_kantor/$d[gbr]'><img src='foto_kantor/$d[gbr]' width='80' margin='5px' data-rel='tooltip' data-placement='right' data-original-title='BPS $d[nama_kabkot]'></a></td>";
		  }
	         
	      if (empty($d[kor])) { 
	      echo "     	    
	      <td class='center'>-</td>";
	  	  } else {
	  	  echo "
	  	  <td class='center'><a href='$d[kor]'>open in maps</a></td>";
	  	  }
	      echo "
	      <td class='center'>
            <div class='inline position-relative'>";
           		if ($kd!=$d[id_kabkot]) {
                  	echo "
                    ---";
                } else {
                	echo "	
                    <a href='?page=$page&act=edit&id=$d[id_prov]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
                    </a>&nbsp;
              
                  	<a href='?page=$page&mode=hapus&id=$d[id_prov]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                    </a>";
                }
               echo "
            </div>
	      </td>
	      </tr>";
	      }
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