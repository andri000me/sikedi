<?php
$kd=$_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
?>
<div class="row-fluid">
<div class="span12">	
	<div class="table-header">
	   LAPORAN
	</div>
	<div class="row-fluid">
	<table id="xmyTable" class="table table-striped table-bordered table-hover">
	<thead>
	   <tr>
	   <th class="center" width="10px">No</th>
	   <th class="center" width="300px">Jenis Laporan</th>
		<th class="center">Filter</th>
	   <th class="center" width="100px">Aksi</th>
	   </tr>
	</thead>
	<tbody>		
	    <tr>
		   <td class="center">1</td>
		   <td class="left">Daftar Kenderaan Dinas Menurut Kab/Kota</td>
		   <form action="cetak/lapkedin.php" method="GET" target="_blank">
		   <td class="center">
		   	<?php
		   	if ($kd =='1200') {			
		   	$qsp = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
		    } else {
		    	$qsp = mysql_query("SELECT * FROM kdkab WHERE id_kabkot=$kd");
		    }
		   	echo "<select class='span3 chosen-select' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";
				while ($s=mysql_fetch_array($qsp)) {
					echo "
					<option value='$s[id_kabkot]'>$s[nama_kabkot]</option>";
					} echo "
					<select>";				
		   ?>
		   </td>
		   <td class="center">
		   	<button class='btn btn-primary btn-small' type="submit">
					<i class='icon-print bigger-100'></i> Cetak
				</button>
			</td>
			</form>
	    </tr>  	  

	    <tr>
		   <td class="center">2</td>
		   <td class="left">Rekapitulasi Kenderaan Dinas Menurut Kondisi</td>		   
		    <form action="cetak/rkpkedin.php" method="GET" target="_blank">
		   <td class="center">
		   	<?php			
		   	if ($kd =='1200') {			
		   	$qsp = mysql_query("SELECT * FROM kdkab ORDER BY id_kabkot ASC");
		    } else {
		    	$qsp = mysql_query("SELECT * FROM kdkab WHERE id_kabkot=$kd");
		    }
		   	echo "<select class='span3 chosen-select' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";
				while ($s=mysql_fetch_array($qsp)) {
					echo "
					<option value='$s[id_kabkot]'>$s[nama_kabkot]</option>";
					} echo "
					<select>";				
		   ?>
		   </td>
		   <td class="center">
		   	<button class='btn btn-primary btn-small' type="submit">
					<i class='icon-print bigger-100'></i> Cetak
				</button>
			</td>
			</form>
	    </tr>  	  
		<tr>
		   <td class="center">3</td>
		   <td class="left">Daftar Perawatan Kenderaan Dinas</td>
		   <form action="cetak/laprkendi2.php" method="GET" target="_blank">
		   <td class="center">
				<select class="span3 chosen-select" id="bId" name="bId" data-placeholder="Pilih Kenderaan Dinas">
					<?php
					$qpr = mysql_query("SELECT DISTINCT(bkode) as kendi FROM rep_kendi WHERE kdkab='$kd'");
					while($m=mysql_fetch_array($qpr)){
					$id_jen    = getValue("bjenis","kendi","bId='$m[kendi]'");
					$id_merk   = getValue("bmerek","kendi","bId='$m[kendi]'");
					$id_tipe   = getValue("btipe","kendi","bId='$m[kendi]'");
					$jenis     = getValue("jenis","kendi_jen","id='$id_jen'");
					$merek     = getValue("merek","kendi_merk","id='$id_merk'");
					$tipe      = getValue("tipe","kendi_tipe","id='$id_tipe'");
					$plat      = getValue("no_plat","kendi","bId='$m[kendi]'");
						echo "<option value='$m[kendi]'>$merek $tipe [$plat]</option>";
					}
					?>
				</select>
				<select class="span1 chosen-select" id="bln1" name="bln1" data-placeholder="Pilih Bulan">
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
				</select> s/d 
				<select class="span1 chosen-select" id="bln2" name="bln2" data-placeholder="Pilih Bulan">
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
				<select class="span1 chosen-select" id="thn" name="thn" data-placeholder="Pilih Tahun">
					<?php
					$qpr = mysql_query("SELECT DISTINCT YEAR(tglrep) as thn FROM rep_kendi WHERE kdkab='$kd'");
					while($m=mysql_fetch_array($qpr)){
						if ($m['thn']==$thn){
							echo "<option value='$m[thn]' selected>$m[thn]</option>";
						}else{
							echo "<option value='$m[thn]'>$m[thn]</option>";
						}
					}
					?>
			</td>	</select>
		    <td class="center">
		   	<button class='btn btn-primary btn-small' type="submit">
					<i class='icon-print bigger-100'></i> Cetak
				</button>
			</td>
			</form>
				
		<tr>
		   <td class="center">4</td>
		   <td class="left">Rekap Penggunaan BBM Menurut Jenis</td>
		   <form action="cetak/rbbm.php" method="GET" target="_blank">
		   <td class="center">
				<select class="span1 chosen-select" id="thn" name="thn" data-placeholder="Pilih Tahun">
					<?php
					$qpr = mysql_query("SELECT DISTINCT YEAR(tglrep) as thn FROM rep_kendi WHERE kdkab='$kd'");
					while($m=mysql_fetch_array($qpr)){

						if ($m['thn']==$thn){
							echo "<option value='$m[thn]' selected>$m[thn]</option>";
						}else{
							echo "<option value='$m[thn]'>$m[thn]</option>";
						}
					}
					?>
				</select>
		   </td>

		   <td class="center">
		   	<button class='btn btn-primary btn-small' type="submit">
					<i class='icon-print bigger-100'></i> Cetak
				</button>
			</td>
			</form>
	    </tr>

	    <tr>
		   <td class="center">5</td>
		   <td class="left">Rekap Penggunaan BBM Menurut Kenderaan Dinas</td>
		   <form action="cetak/rbbmjk.php?" method="GET" target="_blank">
		    <td class="center">
		   	<select class="span2 chosen-select" id="bln" name="bln" data-placeholder="Pilih Bulan">
					<?php
					$qpr = mysql_query("SELECT DISTINCT MONTH(tglrep) as bln FROM rep_kendi WHERE kdkab='$kd'");
					while($m=mysql_fetch_array($qpr)){
						$nmbln = getBulan($m[bln]);
						if ($m['bln']==$bln){
							echo "<option value='$m[bln]' selected>$nmbln</option>";
						}else{
							echo "<option value='$m[bln]'>$nmbln</option>";
						}
					}					
					?>
				</select>
				<select class="span1 chosen-select" id="thn" name="thn" data-placeholder="Pilih Tahun">
					<?php
					$qpr = mysql_query("SELECT DISTINCT YEAR(tglrep) as thn FROM rep_kendi WHERE kdkab='$kd'");
					while($m=mysql_fetch_array($qpr)){
						if ($m['thn']==$thn){
							echo "<option value='$m[thn]' selected>$m[thn]</option>";
						}else{
							echo "<option value='$m[thn]'>$m[thn]</option>";
						}
					}
					?>
				</select>
		    </td>
		    <td class="center">
		   	<button class='btn btn-primary btn-small' type="submit">
					<i class='icon-print bigger-100'></i> Cetak
				</button>
			</td>
			</form>
	    </tr>


	</tbody>
	</table>
	</div>
</div>
</div>