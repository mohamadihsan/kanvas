<?php
// buka koneksi
require_once '../config/connection.php';

$id_produk = isset($_GET['id']) ? $_GET['id']: '';

$sql = "SELECT
        	pr.id_produksi,
        	pr.jumlah_produksi,
        	pr.tanggal,
        	p.id_produk,
        	p.nama_produk
        FROM
        	produksi pr
        LEFT JOIN produk p ON p.id_produk = pr.id_produk";

$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $tanggal                        = date('Y-m-d', strtotime($row['tanggal']));
    $sub_array['no']                = $no++;
    $sub_array['id_produksi']       = $row['id_produksi'];
    $sub_array['id_produk']         = $row['id_produk'].' '.$row['nama_produk'];
    $sub_array['jumlah_produksi']   = $row['jumlah_produksi'];
    $sub_array['tanggal']           = $tanggal;
	$sub_array['action']	          = '   <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_produksi'].'\',\''.$row['id_produk'].'\',\''.$row['jumlah_produksi'].'\',\''.$tanggal.'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_produksi'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
