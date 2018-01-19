<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_bahan_baku      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_baku'])));
$tanggal      = mysqli_escape_string($conn, trim($_POST['tanggal']));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $stok_awal    = mysqli_escape_string($conn, trim($_POST['stok_awal']));
    $jumlah_pembelian   = mysqli_escape_string($conn, trim($_POST['jumlah_pembelian']));
    $jumlah_pemakaian             = mysqli_escape_string($conn, trim($_POST['jumlah_pemakaian']));
}

if ($id_bahan_baku!='' && mysqli_escape_string($conn, trim($_POST['hapus']))=='0') {
    // init kode terkahir
    $init = 'BB';

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT *
            FROM persediaan_bahan_baku
            WHERE
                id_bahan_baku='$id_bahan_baku' AND
                DATE_FORMAT(tanggal, '%Y-%m-%d')='$tanggal'
            ";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){

        // perbaharui data
        $sql = "UPDATE persediaan_bahan_baku
                SET stok_awal='$stok_awal', jumlah_pembelian='$jumlah_pembelian', jumlah_pemakaian='$jumlah_pemakaian'
                WHERE id_bahan_baku='$id_bahan_baku' AND DATE_FORMAT(tanggal, '%Y-%m-%d')='$tanggal'";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data berhasil diperbaharui";
        }else{
            $pesan_gagal = "Data gagal diperbaharui";
        }

    }else{

        // simpan data
        $sql = "INSERT INTO persediaan_bahan_baku (id_bahan_baku, stok_awal, jumlah_pembelian, jumlah_pemakaian, tanggal)
                VALUES ('$id_bahan_baku', '$stok_awal', '$jumlah_pembelian', '$jumlah_pemakaian', '$tanggal')";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data berhasil disimpan";
        }else{
            $pesan_gagal = "Data gagal disimpan";
        }

    }


}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM persediaan_bahan_baku
            WHERE id_bahan_baku='$id_bahan_baku' AND DATE_FORMAT(tanggal, '%Y-%m-%d')='$tanggal'";
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
