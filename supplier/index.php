<?php
// route untuk manage user pegawai
session_start();
$session_id_supplier = isset($_SESSION['id_supplier']) ? $_SESSION['id_supplier'] : '';
$menu       = isset($_GET['menu']) ? $_GET['menu']: '';
$sub        = isset($_GET['sub']) ? $_GET['sub']: '';
$base_url   = 'http://localhost/kanvas/';
$url_api    = 'http://localhost/kanvas/action/';

if ($session_id_supplier!='') {

    // load _header
    include_once '../users/_header.php';

    // load _sidebar
    include_once '../users/supplier/_sidebar.php';

    // load content
    switch ($menu) {
        case 'pemesanan':
            include_once '../users/supplier/pemesanan_barang.php';
            break;

        case 'barang':
            include_once '../users/supplier/barang.php';
            break;

        case 'profil':
            include_once '../users/general-pages/profil.php';
            break;

        default:
            include_once '../users/supplier/beranda.php';
            break;
    }

    // load footer
    include_once '../users/_footer.php';

}else{

    // load form login
    include_once '../users/general-pages/login_supplier.php';

}

?>
