<?php 

function rupiah($angka){
	
	$hasil_rupiah = "Rp. " . number_format($angka,0,null,'.');
	return $hasil_rupiah;
 
}