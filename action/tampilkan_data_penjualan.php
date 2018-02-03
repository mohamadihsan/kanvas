<?php
// buka koneksi
require_once '../config/connection.php';
$periode = date('m Y');

// sql statement
$sql = "SELECT
        	a.jumlah_pelanggan,
        	b.jumlah_produk,
        	c.jumlah_pemesanan_bulan_ini
        FROM
        	(
        		SELECT
        			COUNT(pl.id_pelanggan) AS jumlah_pelanggan
        		FROM
        			pelanggan pl
        	) AS a
        JOIN (
        	SELECT
        		COUNT(pr.id_produk) AS jumlah_produk
        	FROM
        		produk pr
        ) AS b
        JOIN (
        	SELECT
        		COUNT(pp.nomor_faktur) AS jumlah_pemesanan_bulan_ini
        	FROM
        		pemesanan_produk pp
        	WHERE
        		DATE_FORMAT(
        			pp.tanggal_pemesanan,
        			'%m %Y'
        		) = '$periode'
        ) AS c";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['jumlah_produk']     = $row['jumlah_produk'];
    $sub_array['jumlah_pelanggan']   = $row['jumlah_pelanggan'];
    $sub_array['jumlah_pemesanan_bulan_ini']  = $row['jumlah_pemesanan_bulan_ini'];

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
