<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT
        	bb.id_bahan_baku,
        	bb.nama_bahan_baku,
        	pbb.jumlah_pemakaian,
        	pbb.jumlah_pembelian,
        	pbb.stok_awal,
        	pbb.tanggal
        FROM
        	persediaan_bahan_baku pbb
        LEFT JOIN bahan_baku bb ON bb.id_bahan_baku = pbb.id_bahan_baku
        ORDER BY
        	pbb.tanggal DESC";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $tanggal = date('Y-m-d', strtotime($row['tanggal']));
    $sub_array['no']                = $no++;
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'].' - '.$row['nama_bahan_baku'];
    $sub_array['stok_awal']  = $row['stok_awal'];
    $sub_array['jumlah_pembelian']            = $row['jumlah_pembelian'];
    $sub_array['jumlah_pemakaian']      = $row['jumlah_pemakaian'];
    $sub_array['tanggal']      = $tanggal;
	$sub_array['action']		        = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil" onclick="return ubah(\''.$row['id_bahan_baku'].'\',\''.$row['stok_awal'].'\',\''.$row['jumlah_pembelian'].'\',\''.$row['jumlah_pemakaian'].'\',\''.$tanggal.'\')"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i> Ubah</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['id_bahan_baku'].'\',\''.$tanggal.'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
