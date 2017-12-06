<?php
// buka koneksi
require_once '../config/connection.php';

$id_supplier = isset($_GET['id']) ? $_GET['id']: '';
$id_supplier = trim($id_supplier);

// sql statement
if($id_supplier==''){
    $sql = "SELECT nomor_faktur, id_supplier, id_pegawai, status_pemesanan, status_pembayaran, tanggal_pemesanan
            FROM pemesanan_bahan_baku
            ORDER BY tanggal_pemesanan DESC";
}else{
    $sql = "SELECT nomor_faktur, id_supplier, id_pegawai, status_pemesanan, status_pembayaran, tanggal_pemesanan
            FROM pemesanan_bahan_baku
            WHERE id_supplier = '$id_supplier'
            ORDER BY tanggal_pemesanan DESC";
}

$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['nomor_faktur']      = $row['nomor_faktur'];
    $sub_array['id_supplier']       = $row['id_supplier'];
    $sub_array['id_pegawai']        = $row['id_pegawai'];
    $sub_array['status_pemesanan']  = $row['status_pemesanan'];
    $sub_array['status_pembayaran'] = $row['status_pembayaran'];
    $sub_array['tanggal_pemesanan'] = $row['tanggal_pemesanan'];
	$sub_array['action']	        = ' <button type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target=".tampil_detail" onclick="return detail(\''.$row['nomor_faktur'].'\')"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Detail</button>
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#hapus" onclick="return hapus(\''.$row['nomor_faktur'].'\')"><i class="ace-icon fa fa-trash-o bigger-120"></i> Hapus</button>';  
    $sub_array['action_diterima']    = ' <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#terima" onclick="return terima(\''.$row['nomor_faktur'].'\')"><i class="ace-icon fa fa-check-square bigger-120"></i> Terima</button>';   
    
    // ubah tampilan data
    if ($sub_array['status_pemesanan'] == 'SP') {
        $sub_array['status_pemesanan'] = '<span class="label label-info label-white middle">
                                                sedang diproses
                                            </span>';
    }else{
        $sub_array['status_pemesanan'] = '<span class="label label-info label-white middle">
                                                <i class="ace-icon fa fa-check-square bigger-120"></i>
                                                barang sudah diterima
                                            </span>';
    }

    if ($sub_array['status_pembayaran'] == 0) {
        $sub_array['status_pembayaran'] = '<span class="label label-warning label-white middle">
                                                <i class="ace-icon fa fa-exclamation-triangle bigger-120"></i>
                                                belum dibayar
                                            </span>';
    }else{
        $sub_array['status_pembayaran'] = '<span class="label label-success label-white middle">
                                                <i class="ace-icon fa fa-check-square bigger-120"></i>
                                                sudah dibayar
                                            </span>';
    }
    
    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>