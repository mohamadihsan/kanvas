<?php
// buka koneksi
require_once '../config/connection.php';

//set default bahan baku
$sql = "SELECT id_produk FROM produk LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$data_id = $row['id_produk'];

$sql = "SELECT DATE_FORMAT(tanggal_pemesanan, '%Y') as periode FROM pemesanan_produk ORDER BY tanggal_pemesanan DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$data_periode = $row['periode'];

// inisialisasi
$periode     = isset($_GET['periode']) ? $_GET['periode']: $data_periode;
$id_produk   = isset($_GET['id']) ? $_GET['id']: $data_id;

// sql statement
$sql = "SELECT
        	y.periode,
        	x.hasil_peramalan,
        	y.jumlah_pemesanan
        FROM
        	(
        		SELECT
        			DATE_FORMAT(periode, '%m') AS periode,
        			SUM(hasil_peramalan) AS hasil_peramalan
        		FROM
        			peramalan
        		WHERE
        			DATE_FORMAT(periode, '%Y') = '$periode'
        		AND peramalan.id_produk = '$id_produk'
        		GROUP BY
        			1
        	) AS x
        RIGHT JOIN (
        	SELECT
        		DATE_FORMAT(pp.tanggal_pemesanan, '%m') AS periode,
        		SUM(dpp.jumlah_pemesanan) AS jumlah_pemesanan
        	FROM
        		pemesanan_produk pp
        	LEFT JOIN detail_pemesanan_produk dpp ON dpp.nomor_faktur = pp.nomor_faktur
        	WHERE
        		dpp.id_produk = '$id_produk'
        	AND DATE_FORMAT(pp.tanggal_pemesanan, '%Y') = '$periode'
        	GROUP BY
        		1
        ) AS y ON x.periode = y.periode
        ORDER BY
        	y.periode ASC";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $periode = $row['periode'];
    $sub_array['id_produk']   = $data_id;
    $sub_array['periode']   = $row['periode'];
    $sub_array['tahun']   = $data_periode;
    $sub_array['hasil_peramalan']   = $row['hasil_peramalan'];
    $sub_array['jumlah_pemesanan']   = $row['jumlah_pemesanan'];
    $per_minggu = ceil($row['hasil_peramalan']/4);

    $sub_array['peramalan_per_minggu'] = $per_minggu;

    if ($periode=='01') {
        $sub_array['periode'] = 'Januari';
    }else if ($periode=='02') {
        $sub_array['periode'] = 'Februari';
    }else if ($periode=='03') {
        $sub_array['periode'] = 'Maret';
    }else if ($periode=='04') {
        $sub_array['periode'] = 'April';
    }else if ($periode=='05') {
        $sub_array['periode'] = 'Mei';
    }else if ($periode=='06') {
        $sub_array['periode'] = 'Juni';
    }else if ($periode=='07') {
        $sub_array['periode'] = 'Juli';
    }else if ($periode=='08') {
        $sub_array['periode'] = 'Agustus';
    }else if ($periode=='09') {
        $sub_array['periode'] = 'September';
    }else if ($periode=='10') {
        $sub_array['periode'] = 'Oktober';
    }else if ($periode=='11') {
        $sub_array['periode'] = 'November';
    }else if ($periode=='12') {
        $sub_array['periode'] = 'Desember';
    }

    $data[] = $sub_array;
}

$results = $data;

echo json_encode($results);
?>
