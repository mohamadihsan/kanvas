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
$sql = "SELECT a.nomor_faktur, a.id_pelanggan, id_pegawai, status_pemesanan, status_pembayaran, tanggal_pemesanan, tanggal_pembayaran, jumlah_pemesanan, b.id_produk as id_produk, nama_produk, harga_produk, a.id_pelanggan as id_pelanggan, nama_pelanggan, alamat, no_telp, email
        FROM pemesanan_produk a
        LEFT JOIN detail_pemesanan_produk b ON a.nomor_faktur = b.nomor_faktur
        LEFT JOIN produk c ON c.id_produk = b.id_produk
        LEFT JOIN pelanggan d ON d.id_pelanggan = a.id_pelanggan
        WHERE a.nomor_faktur = '$nomor_faktur'
        ORDER BY tanggal_pemesanan DESC";

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
    $sub_array['jumlah_pemesanan']  = $row['jumlah_pemesanan'];
    $sub_array['id_produk']         = $row['id_produk'];
    $sub_array['nama_produk']       = $row['nama_produk'];
    $sub_array['harga_produk']      = $row['harga_produk'];
    $sub_array['nama_pelanggan']    = $row['nama_pelanggan'];
    $sub_array['alamat']            = $row['alamat'];
    $sub_array['no_telp']           = $row['no_telp'];
    $sub_array['email']             = $row['email'];

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
