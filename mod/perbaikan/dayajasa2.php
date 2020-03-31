<?php	
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
			<a href='?page=dayajasa' type='button' class='btn btn-primary btn-small'>
				Reset
				<i class='icon-refresh icon-on-right bigger-110'></i>
			</a>
		</form>";
		?>


		

<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>ENTRI KEGIATAN SPD</h1>
</div>
<?php
$uid    = $_SESSION['dpId'];
$kd     = $_SESSION['dpkode'];
$ulevel = $_SESSION['dpLevel'];
$r      = $_GET['id'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$ntgls = date("dmy");
$tgls = date("d-m-Y");
$page = $_GET['page'];
	
$nama    = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
	

?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Laporan Daya & Jasa</h2></div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="keg">Nama Satker</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="span5" type="text" id="keg" name="keg" value="BPS <?php echo $nama;?>" disabled>	
				<span class="add-on"><i class="icon-home"></i></span>			
			</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="bln">Bulan</label>
			<div class="controls">
				<select class="span2 chosen-select" name="bln" id="bln" placeholder="Pilih Bulan">
				<option>-- Pilih Bulan --</option>
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
			<label class="control-label" for="lis_kva">Listrik Jumlah Kva</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="lis_kva" name="lis_kva" value="<?php echo $lis_kva;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>	
		<div class="control-group">
			<label class="control-label" for="lis_kwh">Listrik Kwh</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="lis_kwh" name="lis_kwh" value="<?php echo $lis_kwh;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="lis_rp">Listrik (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="lis_rp" name="lis_rp" value="<?php echo $lis_rp;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="tel_rp">Telepon (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="tel_rp" name="tel_rp" value="<?php echo $tel_rp;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="tel_sat">Jumlah Sambungan/Fax</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="tel_sat" name="tel_sat" value="<?php echo $tel_sat;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="air_m3">Air (m3)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="air_m3" name="air_m3" value="<?php echo $air_m3;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="air_rp">Air (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="air_rp" name="air_rp" value="<?php echo $trair_rpanstuj;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="int_nama">Internet (Nama Layanan)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xxlarge" type="text" id="int_nama" name="int_nama" value="<?php echo $int_nama;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="int_rp">Internet (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="int_rp" name="int_rp" value="<?php echo $int_rp;?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
				
		<div class="form-actions">
			<button class="btn btn-info" type="submit" name="simpan">
				<i class="icon-save bigger-110"></i>Simpan
			</button>
			<a class="btn" href="javascript:history.back()">
				<i class="icon-undo bigger-110"></i>Kembali
			</a>
		</div>
	</form>
	<!-- FORM -->
	<?php
		if (isset($_POST['simpan'])){
			
			$q = mysql_query("INSERT INTO dayajasa (kdkab,bln,thn,lis_kva,lis_kwh,lis_rp,tel_rp,tel_sat,air_m3,air_rp,int_nama,int_rp,tgl)
	      											VALUES('$kd','$bln','$thn','$_POST[lis_kva]','$_POST[lis_kwh]','$_POST[lis_rp]',
	      													 '$_POST[tel_rp]','$_POST[tel_sat]','$_POST[air_m3]','$_POST[air_rp]','$_POST[int_nama]','$_POST[int_rp]',NOW())");	

		     							
			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout(function() { history.go(-1); }, 1000);
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

</tbody>
</table>
</div>