<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$nama_pelanggan     = ucwords(mysqli_escape_string($conn, trim($_POST['nama_pelanggan'])));
$email              = mysqli_escape_string($conn, trim($_POST['email']));
$nama_pengguna      = strtolower(mysqli_escape_string($conn, trim($_POST['nama_pengguna'])));
$kata_sandi         = mysqli_escape_string($conn, trim($_POST['kata_sandi']));
$ulangi_kata_sandi  = mysqli_escape_string($conn, trim($_POST['ulangi_kata_sandi']));

if ($kata_sandi != $ulangi_kata_sandi) {
    $pesan_gagal = "Kata Sandi yang dimasukkan tidak sama";
}else{
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
    $id_pelanggan = buat_kode_user($string, $init, $id_terakhir_tersimpan);

    // enkrip katasandi
    $kata_sandi = md5($kata_sandi);

    // simpan data
    $sql = "INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, email, nama_pengguna, kata_sandi) 
            VALUES ('$id_pelanggan', '$nama_pelanggan', '$email', '$nama_pengguna', '$kata_sandi')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Akun anda telah berhasil dibuat";
    }else{
        $pesan_gagal = "Registrasi gagal";
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