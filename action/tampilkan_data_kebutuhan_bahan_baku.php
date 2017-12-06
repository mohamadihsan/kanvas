<?php
session_start();

// buka koneksi
require_once '../config/connection.php';

$id_produk  = isset($_GET['data']) ? $_GET['data'] : '';
$periode    = isset($_GET['periode']) ? $_GET['periode'] : '';
$peramalan  = isset($_GET['f']) ? $_GET['f'] : '';

$data = array();
$data_produk = array();
if($id_produk == '' OR $periode == '' OR $peramalan == ''){

    $sub_array_produk['code']         = '204';
    $sub_array_produk['status']       = 'error';
    $sub_array_produk['pesan']        = 'parameter produk tidak terdefinisi';

    $data_produk[] = $sub_array_produk;

}else{

    // retrieve data produk
    $sql = "SELECT id_produk, nama_produk, jenis_produk, kemasan, harga, stok_produk
            FROM produk
            WHERE id_produk='$id_produk'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sub_array_produk['id_produk'] = $row['id_produk'];
        $sub_array_produk['nama_produk'] = $row['nama_produk'];
        $sub_array_produk['jenis_produk'] = $row['jenis_produk'];
        $sub_array_produk['kemasan'] = $row['kemasan'];
        $sub_array_produk['harga'] = $row['harga'];
        $sub_array_produk['stok_produk'] = $row['stok_produk'].' buah ('.$row['stok_produk']/10 .' bal)';
        $sub_array_produk['periode'] = $periode;

        $data_produk[] = $sub_array_produk;

    }

    // retrieve komposisi produk
    $sql = "SELECT k.id_bahan_baku as id_bahan_baku, k.takaran as takaran, bb.nama_bahan_baku as nama_bahan_baku, bb.satuan as satuan
    FROM komposisi k
    LEFT JOIN bahan_baku bb ON k.id_bahan_baku=bb.id_bahan_baku
    WHERE k.id_produk='$id_produk'";
    $result = mysqli_query($conn, $sql);

    $no = 1;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sub_array['no']                = $no++;
            $sub_array['id_bahan_baku']     = $row['id_bahan_baku'];
            $sub_array['nama_bahan_baku']   = $row['nama_bahan_baku'];
            $sub_array['takaran']           = $row['takaran'] * $peramalan.' '.$row['satuan'];

            $data[] = $sub_array;
        }
    }else{
        $sub_array['code']     = '204';
        $sub_array['status']   = 'error';
        $sub_array['pesan']    = "Komposisi untuk produk ini belum didefiniskan";

        $data[] = $sub_array;
    }

}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data_produk"=>$data_produk,
        "data"=>$data);

echo json_encode($results);
?>
