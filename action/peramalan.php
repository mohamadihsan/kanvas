<?php
// buka koneksi
require_once '../config/connection.php';



if(mysqli_escape_string($conn, trim($_POST['hapus']))=='0'){
    // init
    $id_produk  = strtoupper(mysqli_escape_string($conn, trim($_POST['id_produk'])));
    $bulan      = strtoupper(mysqli_escape_string($conn, trim($_POST['bulan'])));
    $tahun      = strtoupper(mysqli_escape_string($conn, trim($_POST['tahun'])));
    $periode    = $bulan.'-'.$tahun;
    $periode_bulan_sebelumnya = date('Y-m-d', strtotime('01-'.$periode));
    $periode_1bulan_sebelumnya = date('m-Y', strtotime('-1 month', strtotime($periode_bulan_sebelumnya)));
    $periode_2bulan_sebelumnya = date('m-Y', strtotime('-2 month', strtotime($periode_bulan_sebelumnya)));
    $periode_3bulan_sebelumnya = date('m-Y', strtotime('-3 month', strtotime($periode_bulan_sebelumnya)));
    //$alpha      = 0.1;

    if ($id_produk == 'SEMUA') {
        $sql = "SELECT id_produk FROM produk";
        $result = mysqli_query($conn, $sql);
        $jumlah_produk = mysqli_num_rows($result);
        if ($jumlah_produk > 0) {
            $i = 0;
            while ($row=mysqli_fetch_assoc($result)) {
                $produk[$i] = $row['id_produk'];

                $i++;
            }
        }
    }

    if ($jumlah_produk == 0) {
        $jumlah_produk = 1;
    }
    $j = 0;
    while ($j < $jumlah_produk) {

        // jumlah pemesanan sebulan sebelum periode yang dicari
        $sql = "SELECT SUM(jumlah_pemesanan) as jumlah_pemesanan
                FROM detail_pemesanan_produk dpp
                LEFT JOIN pemesanan_produk pp ON pp.nomor_faktur = dpp.nomor_faktur
                WHERE dpp.id_produk = '$produk[$j]'
                AND DATE_FORMAT(tanggal_pemesanan,'%m-%Y') = '$periode_1bulan_sebelumnya'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $jumlah_pemesanan_1bulan_sebelumnya = $data['jumlah_pemesanan'];
        if ($jumlah_pemesanan_1bulan_sebelumnya == NULL) {
            $jumlah_pemesanan_1bulan_sebelumnya = 0;
        }

        // jumlah pemesanan 2 bulan sebelum periode yang dicari
        $sql = "SELECT SUM(jumlah_pemesanan) as jumlah_pemesanan
                FROM detail_pemesanan_produk dpp
                LEFT JOIN pemesanan_produk pp ON pp.nomor_faktur = dpp.nomor_faktur
                WHERE dpp.id_produk = '$produk[$j]'
                AND DATE_FORMAT(tanggal_pemesanan,'%m-%Y') = '$periode_2bulan_sebelumnya'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $jumlah_pemesanan_2bulan_sebelumnya = $data['jumlah_pemesanan'];
        if ($jumlah_pemesanan_2bulan_sebelumnya == NULL) {
            $jumlah_pemesanan_2bulan_sebelumnya = 0;
        }

        // jumlah pemesanan 3 bulan sebelum periode yang dicari
        $sql = "SELECT SUM(jumlah_pemesanan) as jumlah_pemesanan
                FROM detail_pemesanan_produk dpp
                LEFT JOIN pemesanan_produk pp ON pp.nomor_faktur = dpp.nomor_faktur
                WHERE dpp.id_produk = '$produk[$j]'
                AND DATE_FORMAT(tanggal_pemesanan,'%m-%Y') = '$periode_3bulan_sebelumnya'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $jumlah_pemesanan_3bulan_sebelumnya = $data['jumlah_pemesanan'];
        if ($jumlah_pemesanan_3bulan_sebelumnya == NULL) {
            $jumlah_pemesanan_3bulan_sebelumnya = 0;
        }

        // jumlah peramalan 1 bulan yang lalu dari periode yang dicari
        // $sql = "SELECT hasil_peramalan
        //         FROM peramalan
        //         WHERE DATE_FORMAT(periode,'%m-%Y') = '$periode_1bulan_sebelumnya'";
        // $result = mysqli_query($conn, $sql);
        // if (mysqli_num_rows($result) > 0) {
        //     $data = mysqli_fetch_assoc($result);
        //     $hasil_peramalan_bulan_sebelumnya = $data['hasil_peramalan'];
        // }else{
        //     $hasil_peramalan_bulan_sebelumnya = $jumlah_pemesanan;
        // }

        // rumus single exponential smoothing
        //$hasil_peramalan = ceil(($alpha * $jumlah_pemesanan) + (1 - $alpha) * $hasil_peramalan_bulan_sebelumnya);

        // rumus single moving average
        $hasil_peramalan = ceil(($jumlah_pemesanan_1bulan_sebelumnya + $jumlah_pemesanan_2bulan_sebelumnya + $jumlah_pemesanan_3bulan_sebelumnya)/3);

        $periode = $tahun.'-'.$bulan.'-01';
        // cek data apakah sudah tersedia atau belum
        $sql = "SELECT id_peramalan
                FROM peramalan
                WHERE periode='$periode' AND id_produk='$produk[$j]'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            $id_peramalan = $data['id_peramalan'];

            // update data
            $sql = "UPDATE peramalan
                    SET hasil_peramalan = '$hasil_peramalan'
                    WHERE id_peramalan = '$id_peramalan'";
            mysqli_query($conn, $sql);
        }else{
            // simpan data
            $sql = "INSERT INTO peramalan (periode, id_produk, hasil_peramalan)
                    VALUES ('$periode', '$produk[$j]', '$hasil_peramalan')";
            if(mysqli_query($conn, $sql)){
                $pesan_berhasil = "Data peramalan telah disimpan";
            }else{
                $pesan_gagal = "Data peramalan gagal disimpan";
            }
        }

        $j++;
    }

}else{
    $id_peramalan  = strtoupper(mysqli_escape_string($conn, trim($_POST['id_peramalan'])));
    // hapus data
    $sql = "DELETE FROM peramalan
            WHERE id_peramalan='$id_peramalan'";
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
