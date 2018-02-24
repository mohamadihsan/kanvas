<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT id_peramalan, peramalan.id_produk, produk.nama_produk, DATE_FORMAT(periode, '%m-%Y') as periode, hasil_peramalan
        FROM peramalan
        LEFT JOIN produk ON produk.id_produk = peramalan.id_produk
        ORDER BY periode DESC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_peramalan']      = $row['id_peramalan'];
    $sub_array['id_produk']         = $row['id_produk'];
    $sub_array['nama_produk']         = $row['nama_produk'];
    $sub_array['periode']           = $row['periode'];
    $sub_array['hasil_peramalan']   = $row['hasil_peramalan'];
	//$sub_array['action_detail']	    = ' <button type="button" class="btn btn-success btn-xs" data-toggle="collapse" data-target=".tampil_detail" onclick="return detail(\''.$row['id_peramalan'].'\')"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Kebutuhan Bahan Baku</button>';
  $sub_array['action_detail']	    = ' <a href="./index.php?menu=peramalan&data='.$row['id_produk'].'&f='.$row['hasil_peramalan'].'&periode='.$row['periode'].'" class="btn btn-success btn-xs"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Kebutuhan Bahan Baku</a>';
  $sub_array['action_hapus']	    = ' <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_peramalan'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
