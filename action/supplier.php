<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_supplier      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_supplier'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_supplier      = strtoupper(mysqli_escape_string($conn, trim($_POST['nama_supplier'])));
    $alamat             = strtolower(mysqli_escape_string($conn, trim($_POST['alamat'])));
    $no_telp            = strtolower(mysqli_escape_string($conn, trim($_POST['no_telp'])));
    $email              = strtolower(mysqli_escape_string($conn, trim($_POST['email'])));
    $waktu_pengiriman   = strtolower(mysqli_escape_string($conn, trim($_POST['waktu_pengiriman'])));
    $nama_pengguna      = strtolower(mysqli_escape_string($conn, trim($_POST['nama_pengguna'])));
    $kata_sandi         = md5(strtolower(mysqli_escape_string($conn, trim($_POST['kata_sandi']))));
}

if ($id_supplier=='') {
    // init kode terkahir
    $init = 'SUP';
    $string = date('my');

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_supplier 
            FROM supplier
            ORDER BY id_supplier DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_supplier'];
    }else{
        $id_terakhir_tersimpan = $string.''.$init.'0000';
    }        

    // panggil fungsi generate kode
    $id_supplier = buat_kode_user($string, $init, $id_terakhir_tersimpan);
    
    // simpan data
    $sql = "INSERT INTO supplier (id_supplier, nama_supplier, alamat, no_telp, email, waktu_pengiriman, nama_pengguna, kata_sandi)
            VALUES ('$id_supplier', '$nama_supplier', '$alamat', '$no_telp', '$email', '$waktu_pengiriman', '$nama_pengguna', '$kata_sandi')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_supplier!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE supplier 
            SET nama_supplier='$nama_supplier', alamat='$alamat', no_telp='$no_telp', email='$email', waktu_pengiriman='$waktu_pengiriman', nama_pengguna='$nama_pengguna', kata_sandi='$kata_sandi'
            WHERE id_supplier='$id_supplier'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM supplier
            WHERE id_supplier='$id_supplier'";
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