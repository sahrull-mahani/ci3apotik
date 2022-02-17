<?php

function timepass($time)
{
    $time = date('Y-m-d H:i:s', $time);
	$awal  = DateTime::createFromFormat('U', strtotime($time));
	$akhir = date_create(); // waktu sekarang
	$diff  = date_diff($awal, $akhir);

	$time = strtotime($time);
	$now = strtotime("now");
	
	$selisi = ($now + (60 * 60)) - $time;

	$y = $akhir->diff($awal)->y;
	$m = $akhir->diff($awal)->m;
	$d = $akhir->diff($awal)->d;
	$h = $akhir->diff($awal)->h;
	$i = $akhir->diff($awal)->i;
	$s = $akhir->diff($awal)->s;

	if ($selisi < 60) {
		$waktu = date('s', $selisi) . " detik lalu";
	} elseif ($selisi <= 60 * 60) {
		$waktu = date('i', $selisi) . " menit lalu";
	} elseif ($selisi <= 60 * 60 * 24) {
		$waktu = $h . " jam lalu";
	} elseif ($diff->m < 1) {
		$waktu = $d . " hari lalu";
	} elseif ($diff->m >= 1) {
		$waktu = $m . " bulan " . ($d > 0 ? $d . " hari lalu" : "lalu");
	} elseif ($diff->m >= 12) {
		$waktu = $y . " tahun lalu";
	} else {
		$waktu = "Waktu tidak diketahui";
	}
	
	return ltrim($waktu, 0);
}