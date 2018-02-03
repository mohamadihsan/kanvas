<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT
        	s.id_supplier,
        	s.nama_supplier,
        	s.waktu_pengiriman,
        	ds.id_bahan_baku,
        	bb.nama_bahan_baku,
        	ds.harga,
        	bb.satuan,
        	ds.minimal_order
        FROM
        	supplier s
        RIGHT JOIN detail_supplier ds ON ds.id_supplier = s.id_supplier
        LEFT JOIN bahan_baku bb ON bb.id_bahan_baku = ds.id_bahan_baku
        ORDER BY
        	ds.id_bahan_baku,
        	ds.harga,
        	s.waktu_pengiriman";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'].' - '.$row['nama_bahan_baku'];
    $sub_array['harga']            = $row['harga'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['waktu_pengiriman']      = $row['waktu_pengiriman'];
    $sub_array['minimal_order']            = $row['minimal_order'];
    $sub_array['id_supplier']  = $row['id_supplier'].' - '.$row['nama_supplier'];

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
