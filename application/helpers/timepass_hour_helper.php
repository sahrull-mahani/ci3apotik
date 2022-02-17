<?php

function hari($time)
{
    $time;
//   $hari = date($time);

  switch ($time) {
    case 'Sun':
      $hariIni = "minggu";
      break;

    case 'Mon':
      $hariIni = "senin";
      break;

    case 'Tue':
      $hariIni = "selasa";
      break;

    case 'Wed':
      $hariIni = "rabu";
      break;

    case 'Thu':
      $hariIni = "kamis";
      break;

    case 'Fri':
      $hariIni = "jum'at";
      break;

    case 'Sat':
      $hariIni = "sabtu";
      break;

    default:
      $hariIni = "tidak diketahui";
      break;
  }

  return $hariIni;
}

function bulan($time)
{

  switch ($time) {
    case 'Jan':
      $bulanIni = "Januari";
      break;

    case 'Feb':
      $bulanIni = "Februari";
      break;

    case 'Mar':
      $bulanIni = "Maret";
      break;

    case 'Apr':
      $bulanIni = "April";
      break;

    case 'mei':
      $bulanIni = "Mei";
      break;

    case 'Jun':
      $bulanIni = "Juni";
      break;

    case 'Jul':
      $bulanIni = "Juli";
      break;

    case 'Aug':
      $bulanIni = "Agustus";
      break;

    case 'Sep':
      $bulanIni = "September";
      break;

    case 'Oct':
      $bulanIni = "Oktober";
      break;

    case 'Nov':
      $bulanIni = "November";
      break;

    case 'Dec':
      $bulanIni = "December";
      break;

    default:
      $bulanIni = "Tidak diketahui";
      break;
  }
  return $bulanIni;
}

function timepassHour($timestamp)
{
    $time = date('Y-m-d H:i:s', $timestamp);
	$awal  = DateTime::createFromFormat('U', strtotime($time));
	$akhir = date_create(); // waktu sekarang
	$diff  = date_diff($awal, $akhir);

	$time = strtotime($time);
	$now = strtotime("now");
	
	$selisi = ($now + (60 * 60)) - $time;

	if ($selisi <= 60 * 60 * 24) {
		$waktu = date('H.i', $timestamp);
	} elseif ($selisi <= 60 * 60 * 24 * 7) {
		$waktu = hari(date('D', $timestamp));
	} elseif ($selisi > 60 * 60 * 24 * 7) {
		$waktu = date('d', $timestamp).'-'.bulan(date('M', $timestamp));
	} elseif ($diff->m >= 12) {
		$waktu = date('Y', $timestamp);
	} else {
		$waktu = "Waktu tidak diketahui";
	}
	
	return $waktu;
}