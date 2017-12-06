<?php
// buka koneksi
require_once '../config/connection.php';

if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $id_bahan_baku  = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_baku'])));
    $jumlah         = strtolower(mysqli_escape_string($conn, trim($_POST['jumlah'])));

    // simpan data
    $sql = "INSERT INTO barang_keluar (id_bahan_baku, jumlah)
            VALUES ('$id_bahan_baku', '$jumlah')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    $id_barang_keluar    = strtolower(mysqli_escape_string($conn, trim($_POST['id_barang_keluar'])));

    // hapus data
    $sql = "DELETE FROM barang_keluar
            WHERE id_barang_keluar='$id_barang_keluar'";
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