<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_pelanggan          = strtoupper(mysqli_escape_string($conn, trim($_POST['id_pelanggan'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_pelanggan   = ucwords(mysqli_escape_string($conn, trim($_POST['nama_pelanggan'])));
    $alamat           = mysqli_escape_string($conn, trim($_POST['alamat']));
    $no_telp          = mysqli_escape_string($conn, trim($_POST['no_telp']));
    $email            = mysqli_escape_string($conn, trim($_POST['email']));
}

if ($id_pelanggan=='') {
    // init kode terkahir
    $init = 'PEL';
    $string = date('my');

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_pelanggan
            FROM pelanggan
            ORDER BY id_pelanggan DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_pelanggan'];
    }else{
        $id_terakhir_tersimpan = $string.''.$init.'0000';
    }

    // panggil fungsi generate kode
    $id_pelanggan = buat_kode_pelanggan($string, $init, $id_terakhir_tersimpan);
    
    // simpan data
    $sql = "INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, alamat, no_telp, email)
            VALUES ('$id_pelanggan', '$nama_pelanggan', '$alamat', '$no_telp', '$email')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_pelanggan!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE pelanggan
            SET nama_pelanggan='$nama_pelanggan', alamat='$alamat', no_telp='$no_telp', email='$email'
            WHERE id_pelanggan='$id_pelanggan'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM pelanggan
            WHERE id_pelanggan='$id_pelanggan'";
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
