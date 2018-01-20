<?php
// buka koneksi
require_once '../config/connection.php';

//set default bahan baku
$sql = "SELECT id_bahan_baku FROM bahan_baku LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$data_id = $row['id_bahan_baku'];

$sql = "SELECT DATE_FORMAT(tanggal, '%Y') as periode FROM persediaan_bahan_baku ORDER BY tanggal DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$data_periode = $row['periode'];

// inisialisasi
$periode     = isset($_GET['periode']) ? $_GET['periode']: $data_periode;
$id_bahan_baku   = isset($_GET['id']) ? $_GET['id']: $data_id;

// sql statement
$sql = "SELECT
        	bb.nama_bahan_baku,
        	pbb.jumlah_pembelian,
        	DATE_FORMAT(pbb.tanggal, '%m') AS periode
        FROM
        	persediaan_bahan_baku pbb
        LEFT JOIN bahan_baku bb ON bb.id_bahan_baku = pbb.id_bahan_baku
        WHERE
        	DATE_FORMAT(pbb.tanggal, '%Y') = '$periode'
        ORDER BY
        	periode ASC";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $periode = $row['periode'];
    $sub_array['id_bahan_baku']   = $data_id;
    $sub_array['periode']   = $row['periode'];
    $sub_array['tahun']   = $data_periode;
    $sub_array['nama_bahan_baku']   = $row['nama_bahan_baku'];
    $sub_array['jumlah_pembelian']   = $row['jumlah_pembelian'];

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
