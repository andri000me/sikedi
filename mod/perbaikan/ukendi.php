<div class="row-fluid">
	<div class="span7">
		<div class="page-header">
			<h1>DATA PERAWATAN KENDERAAN DINAS</h1>
		</div>
		<?php
		$kd    = $_SESSION['dpkode'];
		$uname = $_SESSION['dpNama'];
		$uid   = $_SESSION['dpId'];
		$ulevel= $_SESSION['dpLevel'];
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$ntgls = date("dmy");
		$tgls = date("d-m-Y");
		$page = $_GET['page'];
		if($_GET['act']=="tambah"){
			$nama = getValue("kNama","ms_pegawai","kId='$s[bjenis]'");
			$e = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));

			$jenis = getValue("jenis","kendi_jen","id='$e[bjenis]'");
			$merek = getValue("merek","kendi_merk","id='$e[bmerek]'");
			$tipe  = getValue("tipe","kendi_tipe","id='$e[btipe]'");

			?>
			<div class="widget-box">
				<div class="widget-header widget-header-flat"><h2 class="smaller">Kenderaan Dinas <?php echo $jenis;?> <b><?php echo $e['no_plat'];?></h2></div>
					<div class="widget-body">
						<div class="widget-main">
							<!-- FORM -->
							<form method="POST" enctype="multipart/form-data" class="form-horizontal">
								<div class="control-group">
									<label class="control-label" for="thn">Tahun</label>
									<div class="controls">
										<select class="span1 chosen-select" id="thn" name="thn" data-placeholder="Tahun">
											<option value='2017'>2017</option>
											<option value='2018' selected>2018</option>
											<option value='2019'>2019</option>

										</td>	</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="bln">Bulan</label>
									<div class="controls">
										<select class="span2 chosen-select" id="bln" name="bln" data-placeholder="Bulan">
											<?php
											for ($b=1;$b<=12;$b++){
												$nmbln = getBulan($b);
												if ($b==$bln){
													echo "<option value='$b' selected>$nmbln</option>";
												}else{
													echo "<option value='$b'>$nmbln</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="bukti">File Bukti Pemeliharaan (.pdf)</label>
									<div class="controls">
										<div id="gbr">
											<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="Ukuran File Tidak Boleh Lebih 2 MB">
												<input type="file" name="bukti"> 
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
								$lokasi             = $_FILES['bukti']['tmp_name'];
								$tipe               = $_FILES['bukti']['type'];	
								$nama               = $_FILES['bukti']['name'];  		
								$size               = $_FILES['bukti']['size'];
								$target_dir         = "upl_bukti/";
								$acak               = rand(1,9999);
								$namafilepdf        = "kd_".$e[bId]."_".$acak.".pdf";
								$target_file        = $target_dir . $namafilepdf;


								if (!empty($lokasi)){	
									if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
	  			/*$ft = getValue("tatib","ptogoan","id='$_GET[id]'");
					if (!$ft==""){
						unlink("uploadlp/tatib/$ft");
					}*/

					$q = mysql_query("INSERT INTO kendi_uplbukti (idken,thn,bln,bukti)
						VALUES('$e[bId]','$_POST[thn]','$_POST[bln]','$namafilepdf')");

					/* move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)*/

					if ($q){
						echo "<script>
						notifsukses('Sukses','Data Telah Tersimpan..!!');
						setTimeout('window.location.href=\"media.php?page=ukendi\"', 1000)
						</script>";
					}else{
						echo "<script>
						notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!!');
						setTimeout(function() { history.go(-1); }, 1000);
						</script>";
					}
				}	
			}}

			?>
		</div>
	</div>
</div>
<?php
}elseif($_GET['act']=="edit"){

	$d = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));
	$thn = getValue("thn","kendi_uplbukti","id='$_GET[id]'");
	$bln = getValue("bln","kendi_uplbukti","id='$_GET[id]'");
	$nnmbln = getBulan($bln);

	?>
	<div class="widget-box">
		<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
		<div class="widget-body">
			<div class="widget-main">
				<!-- FORM -->
				<form method="POST" enctype="multipart/form-data" class="form-horizontal">		
					<div class="control-group">
						<label class="control-label" for="thn">Tahun</label>
						<div class="controls">
							<input class="input-small" type="text" id="thn" name="thn" value="<?php echo $thn;?>" readonly required>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="bln">Bulan</label>
						<div class="controls">
							<input class="input-large" type="text" id="bln" name="bln" value="<?php echo $nnmbln;?>" readonly required>
						</div>
					</div>		
					<div class="control-group">
						<label class="control-label" for="bukti">File Bukti Pemeliharaan (.pdf)</label>
						<div class="controls">
							<div id="gbr">
								<div class="span2" data-rel="tooltip" data-placement="right" data-original-title="Ukuran File Tidak Boleh Lebih 2 MB">
									<input type="file" name="bukti" required> 
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
					$lokasi             = $_FILES['bukti']['tmp_name'];
					$tipe               = $_FILES['bukti']['type'];	
					$nama               = $_FILES['bukti']['name'];  		
					$size               = $_FILES['bukti']['size'];
					$target_dir         = "upl_bukti/";
					$acak               = rand(1,99);
					$namafilepdf        = "kd_".$acak.".".$tipe."";
					$target_file        = $target_dir . $namafilepdf;


					if (!empty($lokasi)){	
						if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
							$ft = getValue("bukti","kendi_uplbukti","id='$_GET[id]'");
							if (!$ft==""){
								unlink("upl_bukti/$ft");
							}

							$q = mysql_query("UPDATE kendi_uplbukti   SET   bukti ='$namafilepdf',
								onUpdate = NOW() 							 
								WHERE id ='$_GET[id]'");	
						}
					} else {
						$q = mysql_query("UPDATE kendi_uplbukti   SET   bukti ='$namafilepdf',
							onUpdate = NOW() 							 
							WHERE id ='$_GET[id]'");	
					}

					if ($q){
						echo "<script>
						notifsukses('Sukses','Data Telah Tersimpan..!!');
						setTimeout('window.location.href=\"media.php?page=ukendi\"', 1000)
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
	?>
	<a href="?page=<?php echo $page;?>&act=tambah" class="btn btn-primary">
		<i class="icon-download-alt bigger-100"></i>Tambah
	</a><br><br>
	<?php
	if ($_GET['mode']=="hapus"){
		$ft = getValue("bukti","kendi_uplbukti","id='$_GET[id]'");
		if (!$ft==""){
			unlink("upl_bukti/$ft");			
			
			mysql_query("DELETE FROM kendi_uplbukti WHERE id='$_GET[id]'"); 
		}

		echo "<script>
		notifsukses('Sukses','Data Telah Dihapus..!!');
		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
		</script>";
	}		

	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$kd'"));
	$nama = getValue("kNama","ms_pegawai","kId='$s[bjenis]'");
	$e = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));
	
	$jenis = getValue("jenis","kendi_jen","id='$e[bjenis]'");
	$merek = getValue("merek","kendi_merk","id='$e[bmerek]'");
	$tipe  = getValue("tipe","kendi_tipe","id='$e[btipe]'");
	$idk   = getValue("bId","kendi","bpemegang='$uId'");
	$tanggal = getdate();
	?>

	<div class="table-header">
		<?php echo $merek;?> - <?php echo $tipe;?> <b><?php echo $e['no_plat'];?>&nbsp;&nbsp;&nbsp;&nbsp; </b>&nbsp;&nbsp;a.n : <?php echo $uname ?> <?php echo $thn ?>

		<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='ukendi'>	   		
			<select class="span2" id="thn" name="thn" data-placeholder="Tahun">
				<?php
				$qpr = mysql_query("SELECT DISTINCT thn as thn FROM kendi_uplbukti WHERE idken='$e[bId]'");
				while($m=mysql_fetch_array($qpr)){
					$year = date('Y');
					if ($m['thn']==$year){
						echo "<option value='$m[thn]' selected>$m[thn]</option>";
					}else{
						echo "<option value='$m[thn]'>$m[thn]</option>";
					}
				}
				?>
			</select>			
			<button class='btn btn-primary btn-small' type="submit">
				<i class='icon-print bigger-100'></i> Filter
			</button>
		</form>
	</div>

	<div class="row-fluid">
		<table id="myTable" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="center" width="20px">No</th>
					<th class="center" width="80px">Tahun</th>
					<th class="center" width="100px">Bulan</th>
					<th class="center" width="140px">Uraian</th>	  
					<th class="center" width="50px">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$idk = getValue("bId","kendi","bpemegang='$uid'");			
				if (!empty($_GET[thn])) {
	    		$qry = mysql_query("SELECT * FROM kendi_uplbukti WHERE idken='$idk' AND thn='$_GET[thn]' ORDER BY bln DESC");
	    			} else {
	    		$tahun = date('Y');
	   			$qry = mysql_query("SELECT * FROM kendi_uplbukti WHERE idken='$idk' AND thn='$tahun' ORDER BY bln DESC");
	    			}

					
				while ($d = mysql_fetch_array($qry)){
					$no++;

					$rekrep  = $d['rekrep'];
					$nmbln = getBulan($d['bln']);
					echo "
					<tr>
					<td class='center'>$no</td>
					<td class='left'>$d[thn]</td>	      
					<td class='left'>$nmbln</td>";
					if ($d['bukti']==NULL) {
						$d['bukti'] ='-';	
					} else {
						$d['bukti'] = $d['bukti'] ;
					}	  
					echo "
					<td class='left'><a href='upl_bukti/$d[bukti]'>$d[bukti]</a></td>";

					echo "
					$print
					<td class='center'>
					<div class='inline position-relative'>";
					if ($ulevel!='0') {
						echo "       		
						<a href='?page=$page&act=edit&id=$d[id]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
						<span class='green'><i class='icon-edit bigger-120'></i></span>
						</a>
						<a href='?page=$page&mode=hapus&id=$d[id]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
						<span class='red'><i class='icon-trash bigger-120'></i></span>
						</a>";
					} else {
						echo "                   
						<a href='?page=$page&act=edit&id=$d[id]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
						<span class='green'><i class='icon-edit bigger-120'></i></span>
						</a>
						<a href='?page=$page&mode=hapus&id=$d[id]' onclick='return qh();' class='tooltip-error' data-rel='tooltip' data-original-title='Delete'>
						<span class='red'><i class='icon-trash bigger-120'></i></span>
						</a>";
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