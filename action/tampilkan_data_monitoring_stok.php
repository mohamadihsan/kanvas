<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT
        	id_produk,
        	nama_produk,
        	stok AS sisa
        FROM
        	produk
        WHERE
        	stok <= 0";
$result = mysqli_query($conn, $sql);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['id_produk'] = $row['id_produk'];
    $sub_array['nama_produk'] = $row['nama_produk'];
    $sub_array['sisa'] = $row['sisa'];

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
