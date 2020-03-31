<?php
include "koneksi.php";
date_default_timezone_set('Asia/Jakarta');

function getData($field,$tabel,$term){
	$dt = mysql_fetch_array(mysql_query("SELECT $field FROM $tabel WHERE $term"));
	return $dt;
}

function getValue($field,$table,$term){
	$z = mysql_fetch_array(mysql_query("SELECT $field FROM $table WHERE $term"));
	return $z[0];
}

function getValue2($field,$table,$term1,$term2){
	$z = mysql_fetch_array(mysql_query("SELECT $field FROM $table WHERE $term1 AND $term2"));
	return $z[0];
}

function getJumlah($query){
	$z = mysql_num_rows(mysql_query("$query"));
	return $z;
}

function getAktivitas($field,$tabel,$id){
	$z = mysql_num_rows(mysql_query("SELECT $field FROM $tabel WHERE $field='$id'"));
	return $z;
}

function getTahun(){
	$thn_s = date('Y');
	$start = 2005;
	$thn = array();
	for ($x = $start; $x <= $thn_s; $x++){
		array_push($thn, $x);
	}
	return $thn;
}

function getANum($field,$tabel,$term,$jslice){
	$q = mysql_fetch_array(mysql_query("SELECT MAX($field) as x FROM $tabel WHERE $term"));
	$d = $q['x'];
	$not = substr($d, $jslice,4);
	
	if ($not==""){
		$y = "0001";
	}else{
		$i = $not;
		$i++;
		if (strlen($i)==1){
			$y="000".$i;
		}elseif (strlen($i)==2){
			$y="00".$i;
		}elseif (strlen($i)==3){
			$y="0".$i;
		}else{
			$y=$i;
		}
	}
	return $y; 
}

function getANum2($field,$tabel,$term,$jslice){
	$q = mysql_fetch_array(mysql_query("SELECT MAX($field) as x FROM $tabel WHERE $term"));
	$d = $q['x'];
	$not = substr($d, $jslice,3);
	
	if ($not==""){
		$y = "001";
	}else{
		$i = $not;
		$i++;
		if (strlen($i)==1){
			$y="00".$i;
		}elseif (strlen($i)==2){
			$y="0".$i;
		}else{
			$y=$i;
		}
	}
	return $y; 
}

function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }     
        return $temp;
}
 
 
function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }     
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }     
    return $hasil;
}

?>