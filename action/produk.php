<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_produk          = strtoupper(mysqli_escape_string($conn, trim($_POST['id_produk'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_produk    = ucwords(mysqli_escape_string($conn, trim($_POST['nama_produk'])));
    $jenis_produk   = ucwords(mysqli_escape_string($conn, trim($_POST['jenis_produk'])));
    $harga          = strtolower(mysqli_escape_string($conn, trim($_POST['harga'])));
}

if ($id_produk=='') {
    // init kode terkahir
    $init = 'PR';

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_produk
            FROM produk
            ORDER BY id_produk DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_produk'];
    }else{
        $id_terakhir_tersimpan = $init.'000';
    }

    // panggil fungsi generate kode
    $id_produk = buat_kode_produk($id_terakhir_tersimpan, $init);
    $stok = 0;
    $safety_stock = 0;

    // simpan data
    $sql = "INSERT INTO produk (id_produk, nama_produk, jenis_produk, harga, stok, safety_stock)
            VALUES ('$id_produk', '$nama_produk', '$jenis_produk', '$harga', '$stok', '$safety_stock')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_produk!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE produk
            SET nama_produk='$nama_produk', jenis_produk='$jenis_produk', harga='$harga'
            WHERE id_produk='$id_produk'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM produk
            WHERE id_produk='$id_produk'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil dihapus";
    }else{
        $pesan_gagal = "Data gagal dihapus";
    }
}

if (isset($pesan_berhasil)) {
    ?>
    <script type="text/javascript">
        $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Sukses!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_berhasil ?>',
                // (string | optional) the image to display on the left
                image: '../assets/images/berhasil.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
            });
        });
    </script>
    <?php
}else if(isset($pesan_gagal)){
    ?>
    <script type="text/javascript">
	    $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Gagal!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_gagal ?>',
                // (string | optional) the image to display on the left
                image: '../assets/images/gagal.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
	        });
        });
	</script>
    <?php
}
?>
