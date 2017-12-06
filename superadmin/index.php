<?php
// route untuk manage user pegawai

session_start();

$jabatan = strtolower(isset($_SESSION['jabatan']) ? $_SESSION['jabatan'] : '');
//$jabatan 	= 'pemilik';
$menu 		= isset($_GET['menu']) ? $_GET['menu']: '';
$sub 		= isset($_GET['sub']) ? $_GET['sub']: '';
$base_url 	= 'http://127.0.0.1/kanvas/';
$url_api 	= 'http://127.0.0.1/kanvas/action/';

if ($jabatan!='') {
	// load _header
	include_once '../users/_header.php';
}

switch ($jabatan) {

	case 'administrator':
			include_once '../users/administrator/_sidebar.php';
			// load content
			switch ($menu) {

				case 'pengguna':
					include_once '../users/administrator/pengguna.php';
					break;

				default:
					include_once '../users/administrator/beranda.php';
					break;
			}
		break;

	default:
			include_once '../users/general-pages/login_administrator.php';
		break;
}

if ($jabatan!='') {
	// load footer
	include_once '../users/_footer.php';
}

?>
