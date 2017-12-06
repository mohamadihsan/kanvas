<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_barang_masuk, id_bahan_baku, jumlah, tanggal
        FROM barang_masuk
        ORDER BY id_barang_masuk ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_barang_masuk']  = $row['id_barang_masuk'];
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'];
    $sub_array['jumlah']            = $row['jumlah'];
    $sub_array['tanggal']           = $row['tanggal'];
	$sub_array['action']		    = ' <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_barang_masuk'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';   
	
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>