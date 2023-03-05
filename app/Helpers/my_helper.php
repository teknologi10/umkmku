<?php

/**
 * Author           : Alfikri
 * Created By       : Alfikri
 * E-Mail Primary   : alfikri.name@gmail.com
 * E-Mail Secondary : klinik.code@gmail.com
 * Blog             :  
 */

// Class rajaongkir
class rajaongkir
{

	private $key      = 'c3ccc1a385546a5b9af89abe5bda89eb'; // API Key dari rajaongkir
	private $city_url = 'https://api.rajaongkir.com/starter/city'; // Url untuk mengambil data kota
	private $cost_url = 'https://api.rajaongkir.com/starter/cost'; // Url untuk mengambil biaya ongkir

	// Untuk sorting array
	function array_sort_by_column(&$arr, $col, $dir = SORT_DESC)
	{
		$sort_col = array();
		foreach ($arr as $key => $row) {
			$sort_col[$key] = $row[$col];
		}

		array_multisort($sort_col, $dir, $arr);
	}

	// Untuk mengambil data kota
	function get_city()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $city_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: {$key}"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}

	// Untuk mengambil data biaya ongkir berdasarkan kota asal, kota tujuan, berat dan kurir
	function get_cost($id_kota_asal, $id_kota_tujuan, $berat, $courir)
	{

		$key      = 'c3ccc1a385546a5b9af89abe5bda89eb'; // API Key dari rajaongkir
		$city_url = 'https://api.rajaongkir.com/starter/city'; // Url untuk mengambil data kota
		$cost_url = 'https://api.rajaongkir.com/starter/cost'; // Url untuk mengambil biaya ongkir


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => $cost_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "origin=" . $id_kota_asal . "&destination=" . $id_kota_tujuan . "&weight=" . $berat . "&courier=" . $courir,
			CURLOPT_HTTPHEADER => array(
				"content-type: application/x-www-form-urlencoded",
				"key: {$key}"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			return "cURL Error #:" . $err;
		} else {
			return $response;
		}
	}
}



function nf($angka)
{
	return number_format($angka, 0, ",", ".");
}

function rupiah($angka)
{
	$fmt = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
	$formatAngka = $fmt->formatCurrency($angka, "IDR");

	return $formatAngka;
}

function jml_produk($id_toko)
{
	$db = \Config\Database::connect();

	$output = $db->table('katalog')
		->selectCount('id_penjual', 'total')
		->where('id_penjual', $id_toko)
		->get()->getRowArray();

	$jml = count($output);

	return $jml;
}

//format tanggal format aslinya return $result = $Hari[$hari].", ".$tgl." ".$Bulan[(int)$bulan-1]." ".$tahun." ".$waktu." WIB";
date_default_timezone_set("Asia/Jakarta");


function tglwaktu_lengkap($date)
{
	$Bulan = array(
		"Januari", "Februari", "Maret", "April",
		"Mei", "Juni", "Juli", "Agustus", "September",
		"Oktober", "November", "Dessember"
	);
	$Hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
	$tahun = substr($date, 2, 2);
	$bulan = substr($date, 5, 2);
	$tgl = substr($date, 8, 2);
	$waktu = substr($date, 11, 5);
	$hari = date("w", strtotime($date));
	return $result = $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . "<br>" . $waktu;
}

function tgl_lengkap($date)
{
	$Bulan = array(
		"Januari", "Februari", "Maret", "April",
		"Mei", "Juni", "Juli", "Agustus", "September",
		"Oktober", "November", "Dessember"
	);
	$Hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl = substr($date, 8, 2);
	$waktu = substr($date, 11, 5);
	$hari = date("w", strtotime($date));
	return $result = $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun;
}

function bulan($date)
{
	$Bulan = array(
		"Januari", "Februari", "Maret", "April",
		"Mei", "Juni", "Juli", "Agustus", "September",
		"Oktober", "November", "Dessember"
	);
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	return $result = $Bulan[(int)$bulan - 1] . " Tahun " . $tahun;
}

function judul_konten()
{
	return $judul = "Selamat Datang Di Aplikasi Sistem";
}

function cek_lhp($id)
{
	$db = \Config\Database::connect();
	$output = $db->table('lhp')->where('kode_material', $id)->orderBy('id', 'desc')->get()->getRowArray();
	if ($output) {
		$sisa = $output['sisa_pro'];
		if ($sisa <= 0) {
			$pilihan = 'disabled="disabled"';
		} else {
			$pilihan = '';
		}
	} else {
		$pilihan = '';
	}

	return $pilihan;
}

function kumulasi($id, $kode)
{
	$db = \Config\Database::connect();

	$output = $db->table('lhp')->where('id', $id)->where('kode_material', $kode)->get()->getRowArray();
	$t_pro = $db->table('lhp')->select('sum(ri_pro) as t')->where('id <=', $id)->where('kode_material', $kode)->get()->getRowArray();
	// dd($t_pro);
	$jml = $t_pro['t'];

	return $jml;
}

function label_grafik($date)
{
	$Bulan = array(
		"Januari", "Februari", "Maret", "April",
		"Mei", "Juni", "Juli", "Agustus", "September",
		"Oktober", "November", "Dessember"
	);
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	return $result = $Bulan[(int)$bulan - 1] . "-" . $tahun;
}

function keuntungan()
{
	$db = \Config\Database::connect();

	$blibli = $db->table('umum_blibli')->select('sum(penjualan) as blibli')->get()->getRowArray();
	$shopee = $db->table('umum_shopee')->select('sum(penjualan) as shopee')->get()->getRowArray();
	$tokped = $db->table('umum_tokped')->select('sum(pendapatan_bersih) as tokped')->get()->getRowArray();
	// dd($t_pro);
	$jml = $blibli['blibli'] + $shopee['shopee'] + $tokped['tokped'];

	return $jml;
}

function karyawan()
{
	$db = \Config\Database::connect();

	$blibli = $db->table('user')->get()->getResultArray();

	// dd($t_pro);
	$jml = count($blibli);

	return $jml;
}
