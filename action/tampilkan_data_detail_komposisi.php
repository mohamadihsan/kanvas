<?php
// buka koneksi
require_once '../config/connection.php';

$id_produk = isset($_GET['id']) ? $_GET['id']: '';
$id_produk = trim($id_produk);

// sql statement
if($id_produk==''){
    $sql = "SELECT k.id_produk, k.id_bahan_baku, k.takaran, p.nama_produk, b.nama_bahan_baku, b.satuan
            FROM komposisi k
            LEFT JOIN produk p ON p.id_produk = k.id_produk
            LEFT JOIN bahan_baku b ON b.id_bahan_baku = k.id_bahan_baku
            ORDER BY k.id_produk ASC";
}else{
    $sql = "SELECT k.id_produk, k.id_bahan_baku, k.takaran, p.nama_produk, b.nama_bahan_baku, b.satuan
            FROM komposisi k
            LEFT JOIN produk p ON p.id_produk = k.id_produk
            LEFT JOIN bahan_baku b ON b.id_bahan_baku = k.id_bahan_baku
            WHERE k.id_produk = '$id_produk'
            ORDER BY k.id_produk ASC";
}            
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_produk']         = $row['id_produk'].' - '.$row['nama_produk'];
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'].' - '.$row['nama_bahan_baku'];
    $sub_array['takaran']           = $row['takaran'].' '.$row['satuan'];
    
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>