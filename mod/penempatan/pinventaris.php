<div class="row-fluid">
<div class="span12">
<div class="page-header">
	<h1>PENEMPATAN INVENTARIS</h1>
</div>
<?php
$kd=$_SESSION['dpkode'];
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$ntgls = date("dmy");
$tgls = date("d-m-Y");
$page = $_GET['page'];

if ($kd=='1200' or $kd=='1000') {
	echo "
	<form class='form-search' method='GET'>
			<input type='hidden' name='page' value='pinv'>			
			<select class='span2' id='kkb' name='kkb' data-placeholder='Pilih Satker'>";					
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
			<a href='?page=pinv' type='button' class='btn btn-primary btn-small'>
				Reset
				<i class='icon-refresh icon-on-right bigger-110'></i>
			</a>
		</form>";
	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$_GET[kkb]'"));
	if (!empty($_GET[kkb])) {
		$kkb = $_GET[kkb];
	} else {
		$kkb = "1200";
	}

	$nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$_GET[kkb]'"));
	if (!empty($_GET[kkb])) {
		echo "<div class='table-header'>
		DATA INVENTARIS PER RUANGAN MENURUT BPS $nmkab</div>";
	} else {
		echo"<div class='table-header'>
		DATA INVENTARIS PER RUANGAN MENURUT BPS PROVINSI SUMATERA UTARA</div>";
	}
	?>
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    <th class='center' width='40px'>No</th>
	    <th class='center'>Lantai</th>
	    <th class='center'>Kode Ruangan</th>
	    <th class='center'>Nama Ruangan</th>
	    <th class='center'>Penanggungjawab Ruangan</th>
	    <th class='center'>Jumlah Inventaris</th>
	    <th class='center' width='40px'>Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	   $qry = mysql_query("SELECT * FROM ms_ruangan WHERE kdkab='$kkb' ORDER BY rKode");
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      $jenis = getValue("jNama","_jruangan","jId='$d[rJenis]'");
	      $jlh = getJumlah("SELECT pInv FROM penempatan WHERE pRuang='$d[idruang]'");
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$jenis</td>
	      <td class='left'>$d[rKode]</td>
	      <td class='left'>$d[rNama]</td>
	      <td class='left'>$d[rPemilik]</td>
	      <td class='center'>$jlh</td>
	      <td class='center'>
	      	<a href='?page=pdinv&id=$d[idruang]' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
            	<span class='blue'><i class='icon-search bigger-120'></i></span>
            </a>
		   </td>";
		}
	      ?>
	     </tr>
	   <?php
	   } else {

	   $nmkab = strtoupper(getValue("nama_kabkot","kdkab","id_kabkot='$kd'"));
	echo "
	<div class='table-header'>DATA INVENTARIS PER RUANGAN MENURUT BPS $nmkab</div>";
	?>
	<div class='row-fluid'>
	<table id='myTable' class='table table-striped table-bordered table-hover'>
	<thead>
	    <tr>
	    <th class='center' width='40px'>No</th>
	    <th class='center'>Lantai</th>
	    <th class='center'>Kode Ruangan</th>
	    <th class='center'>Nama Ruangan</th>
	    <th class='center'>Penanggungjawab Ruangan</th>
	    <th class='center'>Jumlah Inventaris</th>
	    <th class='center' width='40px'>Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	   $qry = mysql_query("SELECT * FROM ms_ruangan WHERE kdkab='$kd' ORDER BY rKode");
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      $jenis = getValue("jNama","_jruangan","jId='$d[rJenis]'");
	      $jlh = getJumlah("SELECT pInv FROM penempatan WHERE pRuang='$d[idruang]'");
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$jenis</td>
	      <td class='left'>$d[rKode]</td>
	      <td class='left'>$d[rNama]</td>
	      <td class='left'>$d[rPemilik]</td>
	      <td class='center'>$jlh</td>
	      <td class='center'>
	      	<a href='?page=pdinv&id=$d[idruang]' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
            	<span class='blue'><i class='icon-search bigger-120'></i></span>
            </a>
		   </td>";
		}
	   }
	   ?>
	</tbody>
	</table>
	</div>
</div>
</div>