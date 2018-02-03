<?php
// buka koneksi
require_once '../config/connection.php';
// sql statement
$sql = "SELECT
        	*
        FROM
        	(
        		SELECT
        			COUNT(pp.nomor_faktur) AS jumlah_pemesanan
        		FROM
        			pemesanan_produk pp
        	) AS pemesanan
        JOIN (
        	SELECT
        		COUNT(pp.nomor_faktur) AS jumlah_yang_belum_dibayar
        	FROM
        		pemesanan_produk pp
        	WHERE
        		status_pembayaran = '0'
        ) AS piutang";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['jumlah_pemesanan']     = $row['jumlah_pemesanan'];
    $sub_array['jumlah_yang_belum_dibayar']     = $row['jumlah_yang_belum_dibayar'];

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
