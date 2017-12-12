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

$nomor_faktur = isset($_GET['nomor_faktur']) ? $_GET['nomor_faktur']: '';
$nomor_faktur = trim($nomor_faktur);

// sql statement
$sql = "SELECT a.nomor_faktur, a.id_supplier, id_pegawai, status_pemesanan, status_pembayaran, tanggal_pemesanan, jumlah_pemesanan, b.id_bahan_baku as id_bahan_baku, nama_bahan_baku, harga_bahan_baku, satuan, a.id_supplier as id_supplier, nama_supplier, alamat, no_telp, email, waktu_pengiriman
        FROM pemesanan_bahan_baku a
        LEFT JOIN detail_pemesanan_bahan_baku b ON a.nomor_faktur = b.nomor_faktur
        LEFT JOIN bahan_baku c ON c.id_bahan_baku = b.id_bahan_baku
        LEFT JOIN supplier d ON d.id_supplier = a.id_supplier
        WHERE a.nomor_faktur = '$nomor_faktur'
        ORDER BY tanggal_pemesanan DESC";

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
    $sub_array['tanggal_pemesanan'] = strtoupper($row['tanggal_pemesanan']);
    $sub_array['jumlah_pemesanan']  = $row['jumlah_pemesanan'];
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'];
    $sub_array['nama_bahan_baku']   = $row['nama_bahan_baku'];
    $sub_array['harga_bahan_baku']  = $row['harga_bahan_baku'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['nama_supplier']     = $row['nama_supplier'];
    $sub_array['alamat']            = $row['alamat'];
    $sub_array['no_telp']           = $row['no_telp'];
    $sub_array['email']             = $row['email'];
    $sub_array['waktu_pengiriman']  = $row['waktu_pengiriman'];

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

    if ($sub_array['tanggal_pemesanan'] != NULL) {
        $sub_array['tanggal_pemesanan'] = Tanggal($sub_array['tanggal_pemesanan']);
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
