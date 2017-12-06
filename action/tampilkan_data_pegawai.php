<?php
// buka koneksi
require_once '../config/connection.php';

$id_pegawai	= isset($_GET['id']) ? $_GET['id']: '';
$id_pegawai = trim($id_pegawai);

// sql statement
if($id_pegawai==''){
    $sql = "SELECT id_pegawai, nama_pegawai, alamat, no_telp, email, jabatan, nama_pengguna
            FROM pegawai
            ORDER BY id_pegawai ASC";
}else{
    $sql = "SELECT id_pegawai, nama_pegawai, alamat, no_telp, email, jabatan, nama_pengguna
            FROM pegawai 
            WHERE id_pegawai = '$id_pegawai'";
}
$result = mysqli_query($conn, $sql);
$data = array();
$no=1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']             = $no++; 
    $sub_array['id_pegawai']     = $row['id_pegawai'];
    $sub_array['nama_pegawai']   = $row['nama_pegawai'];
    $sub_array['alamat']         = $row['alamat'];
    $sub_array['no_telp']        = $row['no_telp'];
    $sub_array['email']          = $row['email'];
    $sub_array['jabatan']        = $row['jabatan'];
    $sub_array['nama_pengguna']  = $row['nama_pengguna'];
	$sub_array['action']	     = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_pegawai'].'\',\''.$row['nama_pegawai'].'\',\''.$row['alamat'].'\',\''.$row['no_telp'].'\',\''.$row['email'].'\',\''.$row['jabatan'].'\',\''.$row['nama_pengguna'].'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                     <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_pegawai'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';   
	
    $data[] = $sub_array;
}

$results = array("data"=>$data);

echo json_encode($results);
?>