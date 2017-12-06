<?php
// buka koneksi
require_once '../config/connection.php';
include_once 'generate_kode.php';

$id_pegawai      = strtoupper(mysqli_escape_string($conn, trim($_POST['id_pegawai'])));
if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    $nama_pegawai       = ucwords(mysqli_escape_string($conn, trim($_POST['nama_pegawai'])));
    $alamat             = strtolower(mysqli_escape_string($conn, trim($_POST['alamat'])));
    $no_telp            = strtolower(mysqli_escape_string($conn, trim($_POST['no_telp'])));
    $email              = strtolower(mysqli_escape_string($conn, trim($_POST['email'])));
    $jabatan            = strtolower(mysqli_escape_string($conn, trim($_POST['jabatan'])));
    $nama_pengguna      = strtolower(mysqli_escape_string($conn, trim($_POST['nama_pengguna'])));
    $kata_sandi         = md5(strtolower(mysqli_escape_string($conn, trim($_POST['kata_sandi']))));
}

if ($id_pegawai=='') {
    // init kode terkahir
    if ($jabatan == "pemilik") {
        $init = 10;
    }else if ($jabatan == "manager") {
        $init = 20;
    }else if ($jabatan == "kepala pemasaran") {
        $init = 30;
    }else if ($jabatan == "kepala administrasi") {
        $init = 31;
    }else if ($jabatan == "kepala produksi") {
        $init = 32;
    }else if ($jabatan == "kepala gudang dan pengadaan") {
        $init = 33;
    }else if ($jabatan == "staff keuangan") {
        $init = 40;
    }else if ($jabatan == "staff kepegawaian") {
        $init = 41;
    }else if ($jabatan == "staff gudang") {
        $init = 42;
    }
    
    $string = date('ym');

    // retrieve ID terakhir yg tersimpan
    $sql = "SELECT id_pegawai 
            FROM pegawai
            ORDER BY id_pegawai DESC
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_assoc($result);
        $id_terakhir_tersimpan = $data['id_pegawai'];
    }else{
        $id_terakhir_tersimpan = $init.''.$string.'000';
    }        

    // panggil fungsi generate kode
    $id_pegawai = buat_kode_pegawai($init, $string, $id_terakhir_tersimpan);
    
    // simpan data
    $sql = "INSERT INTO pegawai (id_pegawai, nama_pegawai, alamat, no_telp, email, jabatan, nama_pengguna, kata_sandi)
            VALUES ('$id_pegawai', '$nama_pegawai', '$alamat', '$no_telp', '$email', '$jabatan', '$nama_pengguna', '$kata_sandi')";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil disimpan";
    }else{
        $pesan_gagal = "Data gagal disimpan";
    }
}else if($id_pegawai!='' AND empty(mysqli_escape_string($conn, trim($_POST['hapus'])))){
    // perbaharui data
    $sql = "UPDATE pegawai 
            SET nama_pegawai='$nama_pegawai', alamat='$alamat', no_telp='$no_telp', email='$email', jabatan='$jabatan', nama_pengguna='$nama_pengguna', kata_sandi='$kata_sandi'
            WHERE id_pegawai='$id_pegawai'";
    if(mysqli_query($conn, $sql)){
        $pesan_berhasil = "Data berhasil diperbaharui";
    }else{
        $pesan_gagal = "Data gagal diperbaharui";
    }
}else if(mysqli_escape_string($conn, trim($_POST['hapus']))=='1'){
    // hapus data
    $sql = "DELETE FROM pegawai
            WHERE id_pegawai='$id_pegawai'";
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