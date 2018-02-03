<?php
// buka koneksi
require_once '../config/connection.php';

$id_supplier = isset($_GET['id']) ? $_GET['id']: '';
$id_supplier = trim($id_supplier);

// sql statement
if ($id_supplier=='') {
    $sql = "SELECT sp.id_supplier, sp.id_bahan_baku, b.nama_bahan_baku, b.satuan, sp.harga, sp.minimal_order
        FROM detail_supplier sp
        LEFT JOIN bahan_baku b ON b.id_bahan_baku = sp.id_bahan_baku
        ORDER BY sp.id_bahan_baku ASC";
}else{
    $sql = "SELECT sp.id_supplier, sp.id_bahan_baku, b.nama_bahan_baku, b.satuan, sp.harga, sp.minimal_order
        FROM detail_supplier sp
        LEFT JOIN bahan_baku b ON b.id_bahan_baku = sp.id_bahan_baku
        WHERE sp.id_supplier = '$id_supplier'
        ORDER BY sp.id_bahan_baku ASC";
}

$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_supplier']       = $row['id_supplier'];
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'];
    $sub_array['nama_bahan_baku']   = $row['nama_bahan_baku'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['harga']             = $row['harga'];
    $sub_array['minimal_order']     = $row['minimal_order'];
	$sub_array['action']		    = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_bahan_baku'].'\',\''.$row['harga'].'\',\''.$row['minimal_order'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_bahan_baku'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
