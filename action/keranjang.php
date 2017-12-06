<?php
    session_start();

    // buat session produk yang dibeli
    $id_produk = isset($_GET['id']) ? $_GET['id'] : '';
    $session_produk = isset($_SESSION['id_produk']) ? $_SESSION['id_produk'] : null;
    $jumlah_produk_di_keranjang = 0;

    if($id_produk != ''){
        // hitung produk yg sudah dimasukkan ke dalam keranjang
        $jumlah_produk_di_keranjang = count($session_produk);

        // buat session
        $_SESSION['id_produk'][$jumlah_produk_di_keranjang] = $id_produk;

        // update jumlah produk di dalam keranjang
        $jumlah_produk_di_keranjang = $jumlah_produk_di_keranjang + 1;

    }

    // kembali ke halaman utama
    header('location:../index.php?menu=keranjang');

?>
