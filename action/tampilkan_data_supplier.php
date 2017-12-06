<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_supplier, nama_supplier, alamat, no_telp, email, waktu_pengiriman, nama_pengguna
        FROM supplier
        ORDER BY id_supplier ASC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_supplier']       = $row['id_supplier'];
    $sub_array['nama_supplier']     = $row['nama_supplier'];
    $sub_array['alamat']            = $row['alamat'];
    $sub_array['no_telp']           = $row['no_telp'];
    $sub_array['email']             = $row['email'];
    $sub_array['waktu_pengiriman']  = $row['waktu_pengiriman'].' hari';
    $sub_array['nama_pengguna']     = $row['nama_pengguna'];
	$sub_array['action']	        = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_supplier'].'\',\''.$row['nama_supplier'].'\',\''.$row['alamat'].'\',\''.$row['no_telp'].'\',\''.$row['email'].'\',\''.$row['waktu_pengiriman'].'\',\''.$row['nama_pengguna'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_supplier'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';   
	
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>