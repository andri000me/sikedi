<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$thn = (empty($_GET['thn']) ? "" : $_GET['thn']);
$tterm = (empty($_GET['thn']) ? "1" : "YEAR(bTgl)='$thn'");
$bln = (empty($_GET['bln']) ? "" : $_GET['bln']);
$nbln = (empty($_GET['bln']) ? "" : getBulan($_GET['bln']));
$mterm = (empty($_GET['bln']) ? "1" : "MONTH(bTgl)='$bln'");
?>
<div class="row-fluid">
	<div class="span12">
	<div class="page-header">
		<h1>REKAPITULASI</h1>
	</div>
	<?php
	if ($_GET)
	?>
		<h5 class="blue">Filter Bulan & Tahun Masuk Inventaris</h5>
		<hr>
		<form class="form-search" method="GET">
			<input type="hidden" name="page" value="rekap">
			<select class="span2" id="bln" name="bln" data-placeholder="Pilih Bulan">
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
			<select class="span1" id="thn" name="thn" data-placeholder="Pilih Tahun">
				<?php
				$qpr = mysql_query("SELECT DISTINCT YEAR(onCreate) as thn FROM barang");
				while($m=mysql_fetch_array($qpr)){
					if ($m['thn']==$thn){
						echo "<option value='$m[thn]' selected>$m[thn]</option>";
					}else{
						echo "<option value='$m[thn]'>$m[thn]</option>";
					}
				}
				?>
			</select>
			<button type="submit" class="btn btn-primary btn-small">
				Filter
				<i class="icon-search icon-on-right bigger-110"></i>
			</button>
			<a href="?page=rekap" type="button" class="btn btn-primary btn-small">
				Reset
				<i class="icon-refresh icon-on-right bigger-110"></i>
			</a>
		</form>
		<div class="table-header">
		   REKAPITULASI <?php echo strtoupper("$nbln $thn");?>
		</div>
		<div class="row-fluid">
		<table id="myTable" class="table table-striped table-bordered table-hover">
		<thead>
		    <tr>
		    <th class="center" width="40px">No</th>
		    <th class="center" width="200">Kategori</th>
		    <th class="center" width="100">Total</th>
		    <th class="center" width="100">Baik</th>
		    <th class="center" width="100">Rusak Ringan</th>
		    <th class="center" width="100">Rusak Berat</th>
		    <th class="center" width="100">Terpakai</th>
		    <th class="center" width="100">Dipinjam</th>
		    <th class="center" width="100">Tersedia</th>
		    </tr>
		</thead>
		<tbody>
		 <?php
		   $qry = mysql_query("SELECT a.kId,a.kNama FROM ms_kategori a");
			while ($d = mysql_fetch_array($qry)){
		      $no++;
		      $jtotal = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND $tterm AND $mterm");
		      $jbaik = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bkondisi='1' AND $tterm AND $mterm");
		      $jrusakr = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bkondisi='2' AND $tterm AND $mterm");
		      $jrusakb = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bkondisi='3' AND $tterm AND $mterm");
		      $jterpakai = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bkode IN (SELECT pInv FROM penempatan) AND $tterm AND $mterm");
		      $jtersedia = getJumlah("SELECT bId FROM barang WHERE bjenis='$d[kId]' AND bkode NOT IN (SELECT pInv FROM penempatan) AND $tterm AND $mterm");
		      echo "
		      <tr>
		      <td class='center'>$no</td>
		      <td class='left'>$d[kNama]</td>
		      <td class='center'>$jtotal</td>
		      <td class='center'>$jbaik</td>
		      <td class='center'>$jrusakr</td>
		      <td class='center'>$jrusakb</td>
		      <td class='center'>$jterpakai</td>
		      <td class='center'>$dipinjam</td>
		      <td class='center'>$jtersedia</td>
			   </tr>";
		   }
		   ?>
		</tbody>
		</table>
		</div>
	</div>
</div>