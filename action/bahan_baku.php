<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_bahan_baku      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_bahan_baku'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_bahan_baku    = strtolower(mysqli_escape_string($conn, trim($_POST['nama_bahan_baku'])));
    $jenis_bahan_baku   = mysqli_escape_string($conn, trim($_POST['jenis_bahan_baku']));
    $satuan             = strtolower(mysqli_escape_string($conn, trim($_POST['satuan'])));
}

if ($id_bahan_baku=='') {
    // init kode terkahir
    $init = 'BB';

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_bahan_baku
            FROM bahan_baku
            ORDER BY id_bahan_baku DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_bahan_baku'];
    }else{
        $id_terakhir_tersimpan = '000'.$init;
    }

    // panggil fungsi generate kode
    $id_bahan_baku = buat_kode($id_terakhir_tersimpan, $init);
    $safety_stock = 0;

    // simpan data
    $sql = "INSERT INTO bahan_baku (id_bahan_baku, nama_bahan_baku, jenis_bahan_baku, satuan, safety_stock)
            VALUES ('$id_bahan_baku', '$nama_bahan_baku', '$jenis_bahan_baku', '$satuan', '$safety_stock')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_bahan_baku!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE bahan_baku
            SET nama_bahan_baku='$nama_bahan_baku', jenis_bahan_baku='$jenis_bahan_baku', satuan='$satuan'
            WHERE id_bahan_baku='$id_bahan_baku'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM bahan_baku
            WHERE id_bahan_baku='$id_bahan_baku'";
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
