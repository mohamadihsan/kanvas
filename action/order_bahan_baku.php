<?php
session_start();
// buka koneksi
require_once '../config/connection.php';

$nomor_faktur = date('dmy').'FAK'.date('i-s');
$id_pelanggan = mysqli_escape_string($conn, trim($_POST['id_pelanggan']));
$id_pegawai = $_SESSION['id_pegawai'];
$status_pemesanan = 'sp';
$status_pembayaran = 0;


// simpan data
$sql = "INSERT INTO pemesanan_produk (nomor_faktur, id_pelanggan, id_pegawai, status_pemesanan, status_pembayaran)
        VALUES ('$nomor_faktur', '$id_pelanggan', '$id_pegawai', '$status_pemesanan', '$status_pembayaran')";
if(mysqli_query($conn, $sql)){

    //detail pesanan
    $id_produk          = $_POST['id_produk'];
    $jumlah_pemesanan   = $_POST['jumlah_pemesanan'];
    $i=0;

    while ($i < count($id_produk)) {
        // retrieve harga
        $sql = "SELECT harga
                FROM produk
                WHERE id_produk = '$id_produk[$i]'
                LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $harga = $data['harga'];

        // insert detail pesanan
        $sql = "INSERT INTO detail_pemesanan_produk (nomor_faktur, id_produk, jumlah_pemesanan, harga_produk)
                VALUES ('$nomor_faktur', '$id_produk[$i]', '$jumlah_pemesanan[$i]', '$harga')";
        if(mysqli_query($conn, $sql)){
            $pesan_berhasil = "Data berhasil disimpan";
        }else{
            $pesan_gagal = "Detail pesanna gagal disimpan";
        }

        $i++;
    }

}else{
    $pesan_gagal = "Data gagal disimpan";
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
