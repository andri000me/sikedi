<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>REKAP LAPORAN DAYA DAN JASA BPS PROVINSI SUMATERA UTARA</h1>
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

$e = mysql_fetch_array(mysql_query("SELECT * FROM kendi WHERE bpemegang='$uid'"));

$namakab    = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
$kk    = getValue("kk","kdkab","id_kabkot='$kd'");
	if ($kk==0) {
		$nkk = 'Provinsi';
	} else if ($kk==1) {
		$nkk = 'Kabupaten';
	} else {
		$nkk = 'Kota';
	}
?>
<div class="widget-box">
<div class="widget-header widget-header-flat"><h2 class="smaller">Pelaporan Daya dan Jasa</div>
<div class="widget-body">
<div class="widget-main">
	<!-- FORM -->
	<form method="POST" enctype="multipart/form-data" class="form-horizontal">
		<div class="control-group">
			<label class="control-label" for="keg">Nama Satker</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="span4" type="text" id="keg" name="keg" value="BPS <?php echo $nkk;?> <?php echo $namakab;?>" disabled>	
				<span class="add-on"><i class="icon-home"></i></span>			
			</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="thn">Tahun</label>
			<div class="controls">
				<select class="span2 chosen-select" name="thn" id="thn" placeholder="Pilih Tahun"><option>-- Pilih Tahun --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM _tahun ORDER BY tahun DESC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($e['thn']==$s['tahun']){
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
			<a class="btn" href="media.php?page=<?php echo $page;?>">
				<i class="icon-undo bigger-110"></i>Batal
			</a>
		</div>
	</form>
	<!-- FORM -->
	<?php
		if (isset($_POST['simpan'])){
			
			$q = mysql_query("INSERT INTO dayajasa (kdkab,bln,thn,lis_kva,lis_kwh,lis_rp,tel_rp,tel_sat,air_m3,air_rp,int_nama,int_rp,tgl)
	      											VALUES('$kd','$_POST[bln]','$_POST[thn]','$_POST[lis_kva]','$_POST[lis_kwh]','$_POST[lis_rp]',
	      													 '$_POST[tel_rp]','$_POST[tel_sat]','$_POST[air_m3]','$_POST[air_rp]','$_POST[int_nama]','$_POST[int_rp]',NOW())");	

		     							
			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout('window.location.href=\"media.php?page=dayajasa\"', 1000)
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
$nama    = getValue("nama_kabkot","kdkab","id_kabkot='$kd'");
$qry = mysql_query("SELECT * FROM dayajasa WHERE id='$_GET[id]'");
while ($d = mysql_fetch_array($qry)){
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
				<input class="span4" type="text" id="keg" name="keg" value="BPS <?php echo $nkk;?> <?php echo $namakab;?>" disabled>	
				<span class="add-on"><i class="icon-home"></i></span>			
			</div>
			</div>
		</div>	

		<div class="control-group">
			<label class="control-label" for="thn">Tahun</label>
			<div class="controls">
				<select class="span2 chosen-select" name="thn" id="thn" placeholder="Pilih Tahun"><option>-- Pilih Tahun --</option>
					<?php
						$qsp = mysql_query("SELECT * FROM _tahun ORDER BY tahun DESC");
						while ($s=mysql_fetch_array($qsp)) {
							if ($d['thn']==$s['tahun']){
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
			<label class="control-label" for="bln">Bulan</label>
			<div class="controls">
				<select class="span2 chosen-select" name="bln" id="bln" placeholder="Pilih Bulan">
				<option>-- Pilih Bulan --</option>
					<?php
						for ($b=1;$b<=12;$b++){
						$nmbln = getBulan($b);
						if ($b==$d[bln]){
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
				<input class="input-small" type="text" id="lis_kva" name="lis_kva" value="<?php echo $d[lis_kva];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>	
		<div class="control-group">
			<label class="control-label" for="lis_kwh">Listrik Kwh</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="lis_kwh" name="lis_kwh" value="<?php echo $d[lis_kwh];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="lis_rp">Listrik (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="lis_rp" name="lis_rp" value="<?php echo $d[lis_rp];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="tel_rp">Telepon (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="tel_rp" name="tel_rp" value="<?php echo $d[tel_rp];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="tel_sat">Jumlah Sambungan/Fax</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="tel_sat" name="tel_sat" value="<?php echo $d[tel_sat];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="air_m3">Air (m3)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="air_m3" name="air_m3" value="<?php echo $d[air_m3];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="air_rp">Air (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="air_rp" name="air_rp" value="<?php echo $d[air_rp];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="int_nama">Internet (Nama Layanan)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-xxlarge" type="text" id="int_nama" name="int_nama" value="<?php echo $d[int_nama];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="int_rp">Internet (Rp.)</label>
			<div class="controls">
			<div class="row-fluid input-append">
				<input class="input-small" type="text" id="int_rp" name="int_rp" value="<?php echo $d[int_rp];?>">
				<span class="add-on"><i class="icon-chevron-down"></i></span></div>
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
			
			$q = mysql_query("UPDATE dayajasa SET     thn ='$_POST[thn]', 
													  bln ='$_POST[bln]', 
												  lis_kva ='$_POST[lis_kva]',
												  lis_kwh ='$_POST[lis_kwh]',
												   lis_rp ='$_POST[lis_rp]',
											       tel_rp ='$_POST[tel_rp]',
	      									      tel_sat ='$_POST[tel_sat]',
	      									       air_m3 ='$_POST[air_m3]',
	      										   air_rp ='$_POST[air_rp]',
	      									     int_nama ='$_POST[int_nama]',
	      									       int_rp ='$_POST[int_rp]'      								        
										         WHERE id ='$_GET[id]'");	

		     							
			if ($q){
			echo "<script>
			 		notifsukses('Sukses','Data Telah Tersimpan..!!');
			  		setTimeout(function() { history.go(-2); }, 1000);
			      </script>";
			}else{
			echo "<script>
			      notiferror('Gagal','Data Gagal Tersimpan, pastikan data yang diinput telah benar ..!!');
			  		setTimeout(function() { history.go(-1); }, 1000);
			      </script>";
			}
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
			
			mysql_query("DELETE FROM dayajasa WHERE id='$_GET[id]'");
			echo "<script>
				 		notifsukses('Sukses','Data Telah Dihapus..!!');
				  		setTimeout('window.location.href=\"media.php?page=$page\"', 1000)
				   </script>";
		}

	
	?>

	<div class="table-header">
	    <?php	
	   	echo "
		<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='dayajasa'>			
			<select class='span2 chosen-select' id='bln' name='bln' data-placeholder='Pilih Bulan'>";
				$qpr = mysql_query("SELECT DISTINCT bln as mnth FROM dayajasa WHERE kdkab='$kd' ORDER BY bln ASC");

					while($m=mysql_fetch_array($qpr)){
						$nmbln = getBulan($m[mnth]);
						echo "<option value='$m[mnth]'>$nmbln</option>";
						}
			echo "
			</select>

			<select class='span1 chosen-select' id='thn' name='thn' data-placeholder='Pilih Tahun'>";
				$qpr = mysql_query("SELECT DISTINCT thn as year FROM dayajasa WHERE kdkab='$kd' ORDER BY year DESC");

					while($m=mysql_fetch_array($qpr)){						
						echo "<option value='$m[year]'>$m[year]</option>";
						}
			echo "
			</select>


			<button type='submit' class='btn btn-primary btn-small'>
				Filter
				<i class='icon-search icon-on-right bigger-110'></i>
			</button>
		</form>";
		?>
	</div>

	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
		<th class="center" width="20px" rowspan='3'>No</th>
	    <th class="center" width="200px" rowspan='3'>Provinsi/Kabupaten/Kota</th>
	    <th class="center" width="100px" colspan='7'>Daya dan Jasa</th>
	    <th class="center" width="100px" rowspan='3'>Total (Rp)</th>
	    <th class="center" width="200px" rowspan='2' colspan='2'>Internet</th>
	    <th class="center" width="100px" rowspan='2' colspan='2'>Premium</th>
	    <th class="center" width="100px" rowspan='2' colspan='2'>Pertalite</th>
	    <th class="center" width="100px" rowspan='2' colspan='2'>Pertamax</th>
	    <th class="center" width="100px" rowspan='2' colspan='2'>Solar</th>
	    <th class="center" width="100px" rowspan='2' colspan='2'>Total (Rp)</th>
	    <th class="center" width="50px" rowspan='3'>Keterangan</th>
	    <th class="center" width="50px" rowspan='3'>Aksi</th>
	    </tr>
	    <tr>
	    <th class="center" colspan='3'>Listrik</th>
	    <th class="center" colspan='2'>Telepon</th>
	    <th class="center" colspan='2'>Air</th>	   
	    </tr>
	    <tr>
	    <th class="center">Kva</th>
	    <th class="center">Kwh</th>
	    <th class="center">Rp</th>
	    <th class="center">Rp</th>
	    <th class="center">Sambungan</th>
	    <th class="center">m3</th>
	    <th class="center">Rp</th>
	    <th class="center">Nama Layanan</th>
	    <th class="center">Rp</th>
	    <th class="center">Liter</th>
	    <th class="center">Rp</th>
	    <th class="center">Liter</th>
	    <th class="center">Rp</th>
	    <th class="center">Liter</th>
	    <th class="center">Rp</th>
	    <th class="center">Liter</th>
	    <th class="center">Rp</th>
	    <th class="center">Liter</th>
	    <th class="center">Rp</th>	    
	    </tr>
	</thead>
	<tbody>
	<?php
		$no=0;
		if ($kd==1200) {
		$qry = mysql_query("SELECT * FROM dayajasa WHERE thn='$_GET[thn]' AND bln='$_GET[bln]' ORDER BY kdkab ASC");
	} else {
		$qry = mysql_query("SELECT * FROM dayajasa WHERE kdkab='$kd' AND thn='$_GET[thn]' AND bln='$_GET[bln]'");
	}
		while ($d = mysql_fetch_array($qry)){
		$no++;
		
		$t1 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as bensin FROM rep_kendi WHERE bkode=$r[bk] AND jbbm=1 AND YEAR(tglrep)='$thn' AND MONTH(tglrep)='$bln'"));
	$bensin  = $t1['bensin'];
	$nbensin = number_format ($bensin, 0, ',', ',');
	$tbensin  ==0;
	$tbensin  +=$bensin;
	$ntbensin = number_format ($tbensin, 0, ',', ',');


		$l1 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jbensin FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='1' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$jbensin  = $l1['jbensin'];
		$njbensin = number_format ($jbensin, 0, ',', ',');

		$l2 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jpertalite FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='2' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$jpertalite  = $l2['jpertalite'];
		$njpertalite = number_format ($jpertalite, 0, ',', ',');

		$l3 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jpertamax FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='3' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$jpertamax  = $l3['jpertamax'];
		$njpertamax = number_format ($jpertamax, 0, ',', ',');

		$l4 = mysql_fetch_array(mysql_query("SELECT sum(bbm) as jsolar FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='4' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$jsolar  = $l4['jsolar'];
		$njsolar = number_format ($jsolar, 0, ',', ',');



		$t1 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as bensin FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='1' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$bensin  = $t1['bensin'];
		$nbensin = number_format ($bensin, 0, ',', ',');

		$t2 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertalite FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='2' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$pertalite  = $t2['pertalite'];
		$npertalite = number_format ($pertalite, 0, ',', ',');

		$t3 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as pertamax FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='3' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$pertamax  = $t3['pertamax'];
		$npertamax = number_format ($pertamax, 0, ',', ',');

		$t4 = mysql_fetch_array(mysql_query("SELECT sum(biaya) as solar FROM rep_kendi WHERE kdkab='$d[kdkab]' AND jbbm='4' AND YEAR(tglrep)='$d[thn]' AND MONTH(tglrep)='$d[bln]'"));
		$solar  = $t4['solar'];
		$nsolar = number_format ($solar, 0, ',', ',');

		$tot_l  = $jbensin+$jpertalite+$jpertamax+$jsolar;
		$ntot_l = number_format ($tot_l, 0, ',', ',');

		$tot_rp  = $bensin+$pertalite+$pertamax+$solar;
		$ntot_rp = number_format ($tot_rp, 0, ',', ',');

	   	$nmkab    = getValue("nama_kabkot","kdkab","id_kabkot='$d[kdkab]'");
	   	$lis_kva  = $d[lis_kva];
	   	$lis_kwh  = $d[lis_kwh];
	   	$lis_rp   = $d[lis_rp];
	   	$tel_rp   = $d[tel_rp];
	   	$tel_sat  = $d[tel_sat];
	   	$air_m3   = $d[air_m3];
	   	$air_rp   = $d[air_rp];
	   	$int_nama = $d[int_nama];
	   	$int_rp   = $d[int_rp];	   

	   	$nlis_kva  = number_format ($lis_kva, 0, ',', ',');
	   	$nlis_kwh  = number_format ($lis_kwh, 0, ',', ',');
	   	$nlis_rp   = number_format ($lis_rp, 0, ',', ',');
	   	$ntel_rp   = number_format ($tel_rp, 0, ',', ',');
	   	$ntel_sat  = number_format ($tel_sat, 0, ',', ',');
	   	$nair_m3   = number_format ($air_m3, 0, ',', ',');
	   	$nair_rp   = number_format ($air_rp, 0, ',', ',');	   	
	   	$nint_rp   = number_format ($int_rp, 0, ',', ',');
	    
	   	


	    $jbbm = getValue("nbbm","_jbbm","id='$d[jbbm]'");
	 	$format  = number_format ($d[biaya], 0, ',', '.');
	 	$form_km = number_format ($d[km], 0, ',', '.');
	    $tglrep  = getTglIndo($d['tglrep']);
     	$rekrep  = $d['rekrep'];
     	$tot_dayajasa   = $lis_rp + $air_rp + $tel_rp;
     	$ntot_dayajasa  = number_format ($tot_dayajasa, 0, ',', ',');
          echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$nmkab</td>	      
	      <td class='center'>$nlis_kva</td>
	      <td class='center'>$nlis_kwh</td>	     
	      <td class='center'>$nlis_rp</td>     
	      <td class='center'>$ntel_rp</td>
	      <td class='center'>$ntel_sat</td>
	      <td class='center'>$nair_m3</td>	      
	      <td class='center'>$nair_rp</td>
	      <td class='center'>$ntot_dayajasa</td>
	      <td class='left'>$int_nama</td>
	      <td class='center'>$nint_rp</td>

	      <td class='center'>$njbensin</td>
	      <td class='center'>$nbensin</td>
	      <td class='center'>$njpertalite</td>
	      <td class='center'>$npertalite</td>
	      <td class='center'>$njpertamax</td>
	      <td class='center'>$npertamax</td>
	      <td class='center'>$nsolar</td>
	      <td class='center'>$njsolar</td>
	      <td class='center'>$ntot_l</td>
	      <td class='center'>$ntot_rp</td>
	      <td class='center'></td>";
      	 
      		echo "
      	    $print
		    <td class='center'>
		    <div class='inline position-relative'>";
		      	if ($ulevel!='0') {
		      		echo "       		
                    <a href='?page=$page&act=edit&id=$d[id]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
                    </a>";
                } else {
                    echo "                   
                   	<a href='?page=$page&act=edit&id=$d[id]' class='tooltip-success' data-rel='tooltip' data-original-title='Edit'>
                     	<span class='green'><i class='icon-edit bigger-120'></i></span>
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