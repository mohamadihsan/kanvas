<?php
session_start();
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_bahan_baku      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_baku'])));
$id_supplier        = mysqli_escape_string($conn, trim($_SESSION['id_supplier']));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $harga          = mysqli_escape_string($conn, trim($_POST['harga']));
    $minimal_order  = mysqli_escape_string($conn, trim($_POST['minimal_order']));

    // Cek apakah sudah tercatat atau belum
    $sql = "SELECT id_bahan_baku
            FROM detail_supplier
            WHERE id_bahan_baku = '$id_bahan_baku' AND id_supplier = '$id_supplier'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // perbaharui data
        $sql = "UPDATE detail_supplier
                SET harga='$harga', minimal_order='$minimal_order'
                WHERE id_bahan_baku='$id_bahan_baku' AND id_supplier = '$id_supplier'";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data berhasil diperbaharui";
        }else{
            $pesan_gagal = "Data gagal diperbaharui";
        }
    }else{
        // simpan data
        $sql = "INSERT INTO detail_supplier (id_supplier, id_bahan_baku, harga, minimal_order)
                VALUES ('$id_supplier', '$id_bahan_baku', '$harga', '$minimal_order')";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data berhasil disimpan";
        }else{
            $pesan_gagal = "Data gagal disimpan";
        }
    }

}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM detail_supplier
            WHERE id_bahan_baku='$id_bahan_baku' AND id_supplier = '$id_supplier'";
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
