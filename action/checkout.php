<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';
session_start();

$id_pelanggan       = strtoupper(mysqli_escape_string($conn, trim($_POST['id_pelanggan'])));
$id_produk          = $_POST['id_produk'];
$jumlah_pemesanan   = $_POST['jumlah_pemesanan'];
$harga_produk       = $_POST['harga_produk'];

$string = date('dmy');
$init = "FAK";

// retrieve ID terakhir yg tersimpan
$sql = "SELECT nomor_faktur
        FROM pemesanan_produk
        ORDER BY nomor_faktur DESC
        LIMIT 1";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_assoc($result);
    $id_terakhir_tersimpan = $data['nomor_faktur'];
}else{
    $id_terakhir_tersimpan = $init.''.$string.'0000';
}

// panggil fungsi generate kode
$nomor_faktur = buat_kode_faktur_pemesanan_produk($string, $init, $id_terakhir_tersimpan);

// simpan data
$sql = "INSERT INTO pemesanan_produk (nomor_faktur, id_pelanggan)
        VALUES ('$nomor_faktur', '$id_pelanggan')";
if(mysqli_query($conn, $sql)){

    $i=0;
    while ($i < count($_POST['id_produk'])) {
        $sql = "INSERT INTO detail_pemesanan_produk (nomor_faktur, id_produk, jumlah_pemesanan, harga_produk)
                VALUES ('$nomor_faktur', '$id_produk[$i]', '$jumlah_pemesanan[$i]', '$harga_produk[$i]')";
        if (mysqli_query($conn, $sql)) {
            $pesan_berhasil = true;
            echo $i;
        }else{
            $pesan_gagal = true;
        }

        // unset session produk
        unset($_SESSION['id_produk'][$i]);

        $i++;
    }

    // pesan


}else{
    $pesan_gagal = true;
}

if ($pesan_berhasil == true) {
    header('location:../index.php?data=sukses');
}else if($pesan_gagal == true){
    header('location:../index.php?data=gagal ');
}
?>
