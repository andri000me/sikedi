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
?>
	<div class="table-header">
	   DATA INVENTARIS PER RUANGAN
	</div>
	<div class="row-fluid">
	<table id="myTable" class="table table-striped table-bordered table-hover">
	<thead>
	    <tr>
	    <th class="center" width="40px">No</th>
	    <th class="center" width="100px">Lantai</th>
	    <th class="center" width="140px">Kode Ruangan</th>
	    <th class="center" width="300px">Nama Ruangan</th>
	    <th class="center" width="300px">Penanggungjawab Ruangan</th>
	    <th class="center">Jumlah Inventaris</th>
	    <th class="center" width="40px">Aksi</th>
	    </tr>
	</thead>
	<tbody>
	 <?php
	   $qry = mysql_query("SELECT * FROM ms_ruangan WHERE kdkab='$kd' ORDER BY rKode");
		while ($d = mysql_fetch_array($qry)){
	      $no++;
	      $jenis = getValue("jNama","_jruangan","jId='$d[rJenis]'");
	      $jlh = getJumlah("SELECT pInv FROM penempatan WHERE pRuang='$d[rKode]'");
	      echo "
	      <tr>
	      <td class='center'>$no</td>
	      <td class='left'>$jenis</td>
	      <td class='left'>$d[rKode]</td>
	      <td class='left'>$d[rNama]</td>
	      <td class='left'>$d[rPemilik]</td>
	      <td class='center'>$jlh</td>
	      <td class='center'>
	      	<a href='?page=pdinv&id=$d[rKode]' class='tooltip-success' data-rel='tooltip' data-original-title='Detail Inventaris'>
            	<span class='blue'><i class='icon-search bigger-120'></i></span>
            </a>
		   </td>";
	      ?>
	     </tr>
	   <?php
	   }
	   ?>
	</tbody>
	</table>
	</div>
</div>
</div>