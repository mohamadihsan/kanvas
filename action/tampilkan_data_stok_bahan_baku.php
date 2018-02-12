<?php
// buka koneksi
require_once '../config/connection.php';

// sql statement
$sql = "SELECT
        	*, CASE
        WHEN data_stok.safety_stock > data_stok.stok THEN
        	'aman'
        ELSE
        	'tidak aman'
        END AS status_stok
        FROM
        	(
        		SELECT
        			bb.id_bahan_baku,
        			bb.nama_bahan_baku,
        			bb.satuan,
        			bb.safety_stock,
        			SUM(pbb.stok_awal) + SUM(pbb.jumlah_pembelian) - SUM(pbb.jumlah_pemakaian) AS stok
        		FROM
        			bahan_baku bb
        		LEFT JOIN persediaan_bahan_baku pbb ON pbb.id_bahan_baku = bb.id_bahan_baku
        		WHERE
        			DATE_FORMAT(pbb.tanggal, '%Y-%m') = (
        				DATE_FORMAT(
        					(SELECT CURRENT_DATE),
        					'%Y-%m'
        				)
        			)
        		GROUP BY
        			1,
        			2,
        			3,
        			4
        	) AS data_stok";
$result = mysqli_query($conn, $sql);
$data = array();
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sub_array['no']                = $no++;
    $sub_array['id_bahan_baku']     = $row['id_bahan_baku'];
    $sub_array['nama_bahan_baku']   = $row['nama_bahan_baku'];
    $sub_array['stok']              = $row['stok'];
    $sub_array['status_stok']       = $row['status_stok'];
    $sub_array['satuan']            = $row['satuan'];
    $sub_array['safety_stock']      = $row['safety_stock'];

    $data[] = $sub_array;
}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
