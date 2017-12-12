<?php
// buka koneksi
require_once '../config/connection.php';

function Tanggal($tanggal) {
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $tahun = substr($tanggal, 0, 4);
    $bulan = substr($tanggal, 5, 2);
    $tgl = substr($tanggal, 8, 2);

    $hasil = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
    return ($hasil);
}

$id_pelanggan = isset($_GET['id']) ? $_GET['id']: '';
$id_pelanggan = trim($id_pelanggan);
$status       = isset($_GET['s']) ? $_GET['s']: '';

// sql statement
if($id_pelanggan==''){
    $sql = "SELECT nomor_faktur, id_pelanggan, id_pegawai, status_pemesanan, status_pembayaran, tanggal_pemesanan, tanggal_pembayaran
            FROM pemesanan_produk
            ORDER BY tanggal_pemesanan DESC";
}else{
    $sql = "SELECT nomor_faktur, id_pelanggan, id_pegawai, status_pemesanan, status_pembayaran, tanggal_pemesanan, tanggal_pembayaran
    FROM pemesanan_produk
    WHERE id_pelanggan = '$id_pelanggan'
    ORDER BY tanggal_pemesanan DESC";

    if ($status=='false') {
        $sql = "SELECT nomor_faktur, id_pelanggan, id_pegawai, status_pemesanan, status_pembayaran, tanggal_pemesanan, tanggal_pembayaran
        FROM pemesanan_produk
        WHERE id_pelanggan = '$id_pelanggan' AND tanggal_pembayaran IS NULL AND bukti_pembayaran IS NULL
        ORDER BY tanggal_pemesanan DESC";
    }
}
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['nomor_faktur']      = $row['nomor_faktur'];
    $sub_array['id_pelanggan']      = $row['id_pelanggan'];
    $sub_array['id_pegawai']        = $row['id_pegawai'];
    $sub_array['status_pemesanan']  = strtoupper($row['status_pemesanan']);
    $sub_array['status_pembayaran'] = $row['status_pembayaran'];
    $sub_array['tanggal_pemesanan'] = $row['tanggal_pemesanan'];
    $sub_array['tanggal_pembayaran']= $row['tanggal_pembayaran'];
	  $sub_array['faktur']	        = ' <a href="./index.php?id='.$row['nomor_faktur'].'&menu=faktur" type="button" class="btn btn-warning btn-xs"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Detail</a>';

    // ubah tampilan data
    if ($sub_array['status_pemesanan'] == 'SP') {
        $sub_array['status_pemesanan'] = '<span class="label label-warning label-white middle">
                                                sedang diproses
                                            </span>';
        $sub_array['action']	        = ' <a href="./index.php?menu=pemesanan&faktur='.$row['nomor_faktur'].'" class="btn btn-warning btn-xs"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Detail</a>
                                          <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#kirim" onclick="return kirim(\''.$row['nomor_faktur'].'\')"><i class="ace-icon fa fa-truck bigger-120"></i> Update</button>';
    }else if ($sub_array['status_pemesanan'] == 'DK') {
        $sub_array['status_pemesanan'] = '<span class="label label-info label-white middle">
                                                proses pengiriman
                                            </span>';
        $sub_array['action']	        = ' <a href="./index.php?menu=pemesanan&faktur='.$row['nomor_faktur'].'" class="btn btn-warning btn-xs"><i class="ace-icon fa fa-file-text-o bigger-120"></i> Detail</a>
                                          <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#terima" onclick="return terima(\''.$row['nomor_faktur'].'\')"><i class="ace-icon fa fa-cube bigger-120"></i> Update</button>';
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

    if ($sub_array['tanggal_pemesanan'] != NULL) {
        $sub_array['tanggal_pemesanan'] = Tanggal($sub_array['tanggal_pemesanan']);
    }

    if ($sub_array['tanggal_pembayaran'] != NULL) {
        $sub_array['tanggal_pembayaran'] = Tanggal($sub_array['tanggal_pembayaran']);
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
