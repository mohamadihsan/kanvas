<?php
// buka koneksi
require_once '../config/connection.php';

$id_pelanggan	= isset($_GET['id']) ? $_GET['id']: '';
$id_pelanggan = trim($id_pelanggan);

// sql statement
if($id_pelanggan==''){
    $sql = "SELECT id_pelanggan, nama_pelanggan, alamat, no_telp, email
            FROM pelanggan
            ORDER BY id_pelanggan ASC";
}else{
    $sql = "SELECT id_pelanggan, nama_pelanggan, alamat, no_telp, email
            FROM pelanggan
            WHERE id_pelanggan = '$id_pelanggan'";
}
$result = mysqli_query($conn, $sql);
$data = array();
$no=1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_pelanggan']      = $row['id_pelanggan'];
    $sub_array['nama_pelanggan']    = $row['nama_pelanggan'];
    $sub_array['alamat']            = $row['alamat'];
    $sub_array['no_telp']           = $row['no_telp'];
    $sub_array['email']             = $row['email'];
    $sub_array['action']	          = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_pelanggan'].'\',\''.$row['nama_pelanggan'].'\',\''.$row['alamat'].'\',\''.$row['no_telp'].'\',\''.$row['email'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_pelanggan'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';


    $data[] = $sub_array;
}

$results = array("data"=>$data);

echo json_encode($results);
?>
