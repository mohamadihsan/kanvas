<?php
    session_start();

    // get id produk yg batal dibeli
    $id_produk = isset($_GET['id']) ? $_GET['id'] : '';

    if($id_produk != ''){
        // hitung produk yg sudah dimasukkan ke dalam keranjang
        $jumlah_produk_di_keranjang = count($_SESSION['id_produk']);
        $j = 0;
        for ($i=0; $i < $jumlah_produk_di_keranjang; $i++) {
            if ($_SESSION['id_produk'][$i] == $id_produk) {
                unset($_SESSION['id_produk'][$i]);
            }else{
              // buat session breadcrumb
              $_SESSION['id_produk'][$j] = $_SESSION['produk'][$i];
              $j++;
            }
        }
    }

    // kembali ke halaman utama
    header('location:../index.php?menu=keranjang');

?>
