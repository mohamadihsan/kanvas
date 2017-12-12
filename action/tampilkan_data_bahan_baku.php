<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_bahan_baku, nama_bahan_baku, satuan, jenis_bahan_baku, safety_stock
        FROM bahan_baku
        ORDER BY id_bahan_baku ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'];
    $sub_array['nama_bahan_baku']   = $row['nama_bahan_baku'];
    $sub_array['jenis_bahan_baku']  = $row['jenis_bahan_baku'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['safety_stock']      = $row['safety_stock'];
	   $sub_array['action']		        = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_bahan_baku'].'\',\''.$row['nama_bahan_baku'].'\',\''.$row['satuan'].'\',\''.$row['jenis_bahan_baku'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
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
