<div class="row-fluid">
<div class="span12">
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$kd = $_SESSION['dpkode'];
$page = $_GET['page'];
if($_GET['act']=="tambah"){
?>
<div class="widget-box">
<div class="widget-header widget-header-flat">
<?php
if ($kdlvl =='1200') {
echo "
<h2 class='smaller'>Tambah</h2></div>";
} else {
echo "<h2 class='smaller'></h2></div>";
}
?>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="nama">Nama</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="nama" name="nama" required>
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
		  	$q = mysql_query("INSERT INTO ms_kategori (kNama)
		  											VALUES('$_POST[nama]')
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
$e = mysql_fetch_array(mysql_query("SELECT * FROM ms_kategori WHERE kId='$_GET[id]'"));
$idx = $e['kId'];
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<input type="hidden" name="id" value="<?php echo $idx;?>">
		<div class="control-group">
			<label class="control-label" for="nama">Nama</label>
			<div class="controls">
				<input class="input-xxlarge" type="text" id="nama" name="nama" value="<?php echo $e['kNama'];?>" required>
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
			
			$q = mysql_query("UPDATE ms_kategori SET kNama ='$_POST[nama]',
												  onUpdate =NOW()
			                      				 WHERE kId = '$_POST[id]'");
			
		  	
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
			mysql_query("DELETE FROM ms_kategori WHERE kId='$_GET[id]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
				   </script>";
		}
	?>
	<div class="table-header">
	   DATA KATEGORI ALAT
	</div>
	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="40px">No</th>
	    <th class="center">Nama Kategori</th>
	    <th class="center" width="60px">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	    $qry = mysql_query("SELECT * FROM ms_kategori ORDER BY kNama ASC");
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$d[kNama]</td>
	      <td class='center'>
            <div class='inline position-relative'>";
            if ($kd == '1200') {
            echo "
               	<a href='?page=$page&act=edit&id=$d[kId]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
                     </a>&nbsp;
            
                  	<a href='?page=$page&mode=hapus&id=$d[kId]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
                     	<span class='red'><i class='icon-trash bigger-120'></i></span>
                     </a>";
       		} else {
       			echo "---";
       		}
       		echo "
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