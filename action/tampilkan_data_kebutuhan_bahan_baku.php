<?php
session_start();

// buka koneksi
require_once '../config/connection.php';

$id_produk  = isset($_GET['data']) ? $_GET['data'] : '';
$periode    = isset($_GET['periode']) ? $_GET['periode'] : '';
$peramalan  = isset($_GET['f']) ? $_GET['f'] : '';

// cari peramalan produk periode terakhir
$sql = "SELECT hasil_peramalan FROM peramalan WHERE id_produk='$id_produk' ORDER BY periode DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);
$hasil_peramalan = $row['hasil_peramalan'];

$data = array();
$data_produk = array();
if($id_produk == '' OR $periode == '' OR $peramalan == ''){

    $sub_array_produk['code']         = '204';
    $sub_array_produk['status']       = 'error';
    $sub_array_produk['pesan']        = 'parameter produk tidak terdefinisi';

    $data_produk[] = $sub_array_produk;

}else{

    // retrieve data produk
    $sql = "SELECT id_produk, nama_produk, jenis_produk, harga, stok
            FROM produk
            WHERE id_produk='$id_produk'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $sub_array_produk['id_produk'] = $row['id_produk'];
        $sub_array_produk['nama_produk'] = $row['nama_produk'];
        $sub_array_produk['jenis_produk'] = $row['jenis_produk'];
        $sub_array_produk['harga'] = $row['harga'];
        $sub_array_produk['stok'] = $row['stok'];
        $sub_array_produk['periode'] = $periode;

        // penentuan safety stock produk
        $rata_rata_pengadaan_per_bulan      = $hasil_peramalan/24;
        $lead_team = 4;
        $standar_deviasi_lead_team = 0.4;
        $standar_deviasi = 2.4;
        $service_level = 1.75;
        $sdl = sqrt(pow($rata_rata_pengadaan_per_bulan,2) * pow($standar_deviasi_lead_team,2) + $lead_team * pow($standar_deviasi,2));
        $safety_stock = ceil($service_level * $sdl);
        $sub_array_produk['safety_stock'] = $safety_stock;

        // update safety_stock
        $sql = "UPDATE produk SET safety_stock='$safety_stock' WHERE id_produk='$id_produk'";
        mysqli_query($conn, $sql);

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
            $id_bahan_baku = $row['id_bahan_baku'];
            $sub_array['no']                = $no++;
            $sub_array['id_bahan_baku']     = $row['id_bahan_baku'];
            $sub_array['nama_bahan_baku']   = $row['nama_bahan_baku'];
            $sub_array['takaran']           = $row['takaran'] * $peramalan.' '.$row['satuan'];

            // penentuan safety stock bahan baku
            $rata_rata_pengadaan_per_bulan      = $hasil_peramalan * $row['takaran']/24;
            $lead_team = 4;
            $standar_deviasi_lead_team = 0.4;
            $standar_deviasi = 2.4;
            $service_level = 1.75;
            $sdl = sqrt(pow($rata_rata_pengadaan_per_bulan,2) * pow($standar_deviasi_lead_team,2) + $lead_team * pow($standar_deviasi,2));
            $safety_stock = ceil($service_level * $sdl);
            $sub_array['safety_stock'] = $safety_stock;

            // update safety_stock
            $sql = "UPDATE bahan_baku SET safety_stock='$safety_stock' WHERE id_bahan_baku='$id_bahan_baku'";
            mysqli_query($conn, $sql);

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
