<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_produksi          = strtoupper(mysqli_escape_string($conn, trim($_POST['id_produksi'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_produk    = mysqli_escape_string($conn, trim($_POST['id_produk']));
    $jumlah_produksi   = mysqli_escape_string($conn, trim($_POST['jumlah_produksi']));
    $tanggal          = mysqli_escape_string($conn, trim($_POST['tanggal']));
}

if ($id_produksi=='') {

    $id_produksi = 'PRD'.date('dmyHi');

    // simpan data
    $sql = "INSERT INTO produksi (id_produksi, id_produk, jumlah_produksi, tanggal)
            VALUES ('$id_produksi', '$id_produk', '$jumlah_produksi', '$tanggal')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_produksi!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE produksi
            SET id_produk='$id_produk', jumlah_produksi='$jumlah_produksi', tanggal='$tanggal'
            WHERE id_produksi='$id_produksi'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM produksi
            WHERE id_produksi='$id_produksi'";
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
