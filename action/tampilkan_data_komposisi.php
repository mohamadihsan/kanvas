<?php
session_start();

// buka koneksi
require_once '../config/connection.php';

$id_bahan_baku = isset($_SESSION['id_bahan_baku']) ? $_SESSION['id_bahan_baku'] : '';
$data = array();
if($id_bahan_baku == ''){

    $sub_array['id_bahan_baku']         = NULL;
    $sub_array['input_id_produk']       = NULL;
    $sub_array['input_id_bahan_baku']   = NULL;
    $sub_array['takaran']               = NULL;

    $data[] = $sub_array;

}else{

    for ($i=0; $i < count($_SESSION['id_bahan_baku']); $i++) {
        $sub_array['id_bahan_baku']         = $_SESSION['id_bahan_baku'][$i];
        $sub_array['input_id_produk']       = '<input type="hidden" name="id_produk" value="'.$_SESSION['id_produk'].'" class="form-control" required>';
        $sub_array['input_id_bahan_baku']   = '<input type="hidden" name="id_bahan_baku[]" value="'.$_SESSION['id_bahan_baku'][$i].'" class="form-control" required>';
        $sub_array['takaran']               = '<input type="text" name="takaran[]" class="form-control" placeholder="0.5" min="0" required>';

        $data[] = $sub_array;
    }

}

$results = array(
    "sEcho" => 1,
        "jumlahRecord" => count($data),
        "jumlahRecordDitampilkan" => count($data),
        "data"=>$data);

echo json_encode($results);
?>
