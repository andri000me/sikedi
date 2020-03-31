<div class="row-fluid">
<div class="span12">
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

$t = mysql_fetch_array(mysql_query("SELECT sum(biaya) as total FROM rep_kendi WHERE bkode='$e[bId]'"));

$biaya = $t['total'];
$bi    = ($e[pagu]-$biaya);
$bi_for  = number_format ($bi, 0, ',', '.');
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Kenderaan Dinas <?php echo $jenis;?> <b><?php echo $e['no_plat'];?> SISA PAGU : Rp <?php echo $bi_for ?>,-</b></h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="pPJ">Penanggung Jawab</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xlarge" type="text" id="pPJ" name="pPJ" value="<?php echo "$uname";?>"  readonly required>
				<span class="add-on"><i class="icon-eye-open"></i></span>
			</div></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="pPJ">Merek/Tipe</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-large" type="text" id="pPJ" name="pPJ" value="<?php echo "$merek";?> - <?php echo "$tipe";?>"  readonly required>
				<span class="add-on"><i class="icon-random"></i></span>
			</div></div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="tglrep">Tanggal</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="tglrep" name="tglrep" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['tglrep'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>		
		
		<div class="control-group">
			<label class="control-label" for="rekrep">Rekanan</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xlarge" type="text" id="rekrep" name="rekrep" value="<?php echo $e['rekrep'];?>" required>	
				<span class="add-on"><i class="icon-asterisk"></i></span>			
			</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="jbbm">Jenis BBM</label>
			<div class="controls">
				<select class="span3" name="jbbm" id="jbbm" placeholder="Pilih Jenis BBM">
				<option>-- Pilih Jenis BBM--</option>
					<?php
						$qsp = mysql_query("SELECT * FROM _jbbm");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['jbbm']==$s['id']){
								echo "<option value='$s[id]' selected>$s[nbbm]</option>";
							}else{
								echo "<option value='$s[id]'>$s[nbbm]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bbm">Jumlah Liter</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="bbm" name="bbm" value="<?php echo $e['bbm'];?>">	
				<span class="add-on"><i class="icon-chevron-up"></i></span>			
			</div>
		</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="km">Jumlah Kilometer</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="km" name="km" value="<?php echo $e['km'];?>">		
				<span class="add-on"><i class="icon-magnet"></i></span>		
			</div></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="biaya">Total Biaya</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="biaya" name="biaya" value="<?php echo $e['biaya'];?>" required>	
				<span class="add-on"><i class="icon-screenshot"></i></span>			
			</div></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="detrep">Rincian Perawatan</label>
			<div class="controls">
				<textarea class="ckeditor" name="detrep" id="detrep" rows="4"><?php echo $e['detrep'];?></textarea>
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
		
			$q1 = mysql_query("INSERT INTO rep_kendi (kdkab,bkode,tglrep,rekrep,jbbm,bbm,km,biaya,detrep,onCreate)
	      											VALUES('$kd','$e[bId]','$_POST[tglrep]','$_POST[rekrep]','$_POST[jbbm]','$_POST[bbm]','$_POST[km]','$_POST[biaya]','$_POST[detrep]',NOW())");	

		   
			if ($q1){
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
$e = mysql_fetch_array(mysql_query("SELECT * FROM rep_kendi WHERE id='$_GET[id]'"));
$d = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));
$jenis = getValue("jenis","kendi_jen","id='$d[bjenis]'");
$merek = getValue("merek","kendi_merk","id='$d[bmerek]'");
$tipe  = getValue("tipe","kendi_tipe","id='$d[btipe]'");

?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Edit</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="pPJ">Penanggung Jawab</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xlarge" type="text" id="pPJ" name="pPJ" value="<?php echo "$uname";?>"  readonly required>
				<span class="add-on"><i class="icon-eye-open"></i></span>
			</div></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="merek">Merek/Tipe</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-large" type="text" id="merek" name="merek" value="<?php echo "$merek";?> - <?php echo "$tipe";?>"  readonly required>
				<span class="add-on"><i class="icon-random"></i></span>
			</div></div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="tglrep">Tanggal</label>
			<div class="controls">
				<div class="row-fluid input-append">
					<input class="span2 date-picker" id="tglrep" name="tglrep" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $e['tglrep'];?>" required/>
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</div>
		</div>		
		
		<div class="control-group">
			<label class="control-label" for="rekrep">Rekanan</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xlarge" type="text" id="rekrep" name="rekrep" value="<?php echo $e['rekrep'];?>" required>	
				<span class="add-on"><i class="icon-asterisk"></i></span>			
			</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="jbbm">Jenis BBM</label>
			<div class="controls">
				<select class="span3" name="jbbm" id="jbbm" placeholder="Pilih Jenis BBM">
				<option>-- Pilih Jenis BBM--</option>
					<?php
						$qsp = mysql_query("SELECT * FROM _jbbm");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['jbbm']==$s['id']){
								echo "<option value='$s[id]' selected>$s[nbbm]</option>";
							}else{
								echo "<option value='$s[id]'>$s[nbbm]</option>";
							}
						}
					?>
				</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="bbm">Jumlah Liter</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="bbm" name="bbm" value="<?php echo $e['bbm'];?>">	
				<span class="add-on"><i class="icon-chevron-up"></i></span>			
			</div>
		</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="km">Jumlah Kilometer</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="km" name="km" value="<?php echo $e['km'];?>">		
				<span class="add-on"><i class="icon-magnet"></i></span>		
			</div></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="biaya">Total Biaya</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="biaya" name="biaya" value="<?php echo $e['biaya'];?>" required>	
				<span class="add-on"><i class="icon-screenshot"></i></span>			
			</div></div>
		</div>

		<div class="control-group">
			<label class="control-label" for="detrep">Rincian Perawatan</label>
			<div class="controls">
				<textarea class="ckeditor" name="detrep" id="detrep" rows="4"><?php echo $e['detrep'];?></textarea>
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
					
			$q2 = mysql_query("UPDATE rep_kendi SET tglrep ='$_POST[tglrep]',
												    rekrep ='$_POST[rekrep]',
												      jbbm ='$_POST[jbbm]',
													   bbm ='$_POST[bbm]',
													    km ='$_POST[km]',
												   	 biaya ='$_POST[biaya]',
												    detrep ='$_POST[detrep]',						
	      										  onUpdate =NOW()
	      										   WHERE id='$_GET[id]'");	
	      
			if ($q2){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal $uname','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!!');
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
			
			mysql_query("DELETE FROM rep_kendi WHERE id='$_GET[id]'");
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
	$t = mysql_fetch_array(mysql_query("SELECT sum(biaya) as total FROM rep_kendi WHERE bkode='$e[bId]'"));
	$biaya = $t['total'];
	$bi    = ($e[pagu]-$biaya);
	$bi_for  = number_format ($bi, 0, ',', '.');
	?>

	<div class="table-header">
	   <?php echo $merek;?> - <?php echo $tipe;?> <b><?php echo $e['no_plat'];?>&nbsp;&nbsp;&nbsp;&nbsp; &raquo [SISA PAGU : Rp <?php echo $bi_for ?>,-]</b>&nbsp;&nbsp;a.n : <?php echo $uname ?>
	   <form action="cetak/laprkendi.php?" method="GET" target="_blank">	
	   		<select class="span1 chosen-select" name="bln1" id="bln1"  placeholder="Pilih Bulan">
					<?php
					$qpr = mysql_query("SELECT DISTINCT MONTH(tglrep) as mnth FROM rep_kendi WHERE bkode='$e[bId]'");

					while($m=mysql_fetch_array($qpr)){
						$nmbln = getBulan($m[mnth]);
						if ($m['mnth']==$mnth){
							echo "<option value='$m[mnth]' selected>$nmbln</option>";
						}else{
							echo "<option value='$m[mnth]'>$nmbln</option>";
						}
					}
					?>
			</select> s/d
			<select class="span1 chosen-select" name="bln2" id="bln2"  placeholder="Pilih Bulan">
					<?php
					$qpr = mysql_query("SELECT DISTINCT MONTH(tglrep) as mnth FROM rep_kendi WHERE bkode='$e[bId]'");

					while($m=mysql_fetch_array($qpr)){
						$nmbln = getBulan($m[mnth]);
						if ($m['mnth']==$mnth){
							echo "<option value='$m[mnth]' selected>$nmbln</option>";
						}else{
							echo "<option value='$m[mnth]'>$nmbln</option>";
						}
					}
					?>
			</select>
			<select class="span1 chosen-select" id="thn" name="thn" data-placeholder="Pilih Tahun">
					<?php
					$qpr = mysql_query("SELECT DISTINCT YEAR(tglrep) as thn FROM rep_kendi WHERE bkode='$e[bId]'");
					while($m=mysql_fetch_array($qpr)){
						if ($m['thn']==$thn){
							echo "<option value='$m[thn]' selected>$m[thn]</option>";
						}else{
							echo "<option value='$m[thn]'>$m[thn]</option>";
						}
					}
					?>
			</select>			
		   	<button class='btn btn-primary btn-small' type="submit">
					<i class='icon-print bigger-100'></i> Cetak
			</button>
		</form>
	</div>

	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="20px">No</th>
	    <th class="center" width="80px">Tanggal</th>
	    <th class="center" width="100px">Rekanan</th>
	    <th class="center" width="140px">Uraian</th>
	    <th class="center" width="60px">Jenis BBM</th>
	    <th class="center" width="60px">BBM (liter)</th>
	    <th class="center" width="60px">Kilometer</th>
	    <th class="center" width="60px">Jumlah</th>
	    <th class="center" width="50px">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	<?php
		$idk = getValue("bId","kendi","bpemegang='$uid'");
	    $qry = mysql_query("SELECT * FROM rep_kendi WHERE bkode='$idk' ORDER BY tglrep DESC");
		while ($d = mysql_fetch_array($qry)){
	    $no++;
	    $jbbm = getValue("nbbm","_jbbm","id='$d[jbbm]'");
	 	$format  = number_format ($d[biaya], 0, ',', '.');
	 	$form_km = number_format ($d[km], 0, ',', '.');
	    $tglrep  = getTglIndo($d['tglrep']);
     	$rekrep  = $d['rekrep'];
          echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='center'>$tglrep</td>
	      
	      <td class='center'>$rekrep</td>";
	      if ($d['detrep']==NULL) {
	    			$d['detrep'] ='-';	
				} else {
					$d['detrep'] = $d['detrep'] ;
				}	  
		  echo "
	      <td class='center'>$d[detrep]</td>";
	      if ($jbbm==NULL) {
	    			$jbbm ='-';	
				} else {
					$jbbm = $jbbm;
				}	  
		  echo "
	      <td class='center'>$jbbm</td>";
	      if ($d['bbm']=='0') {
	    			$d['bbm'] ='-';	
				} else {
					$d['bbm'] = $d['bbm'];
				}	  
		  echo "
	      <td class='center'>$d[bbm]</td>";
	      if ($form_km=='0') {
	    			$form_km ='-';	
				} else {
					$form_km = $form_km;
				}	  
		  echo "
	      <td class='center'>$form_km</td>
	      <td class='center'>$format</td>";
      	 
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