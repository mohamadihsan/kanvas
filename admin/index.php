<?php
// route untuk manage user pegawai

session_start();

$jabatan = strtolower(isset($_SESSION['jabatan']) ? $_SESSION['jabatan'] : '');
//$jabatan 	= 'pemilik';
$menu 		= isset($_GET['menu']) ? $_GET['menu']: '';
$sub 		= isset($_GET['sub']) ? $_GET['sub']: '';
$base_url 	= 'http://localhost/kanvas/';
$url_api 	= 'http://localhost/kanvas/action/';

if ($jabatan!='') {
	// load _header
	include_once '../users/_header.php';
}

switch ($jabatan) {

	case 'manager produksi':
			include_once '../users/manager-produksi/_sidebar.php';
			// load content
			switch ($menu) {
				case 'bahan-baku':
					include_once '../users/manager-produksi/bahan_baku.php';
					break;

				case 'detail_komposisi':
					include_once '../users/manager-produksi/detail_komposisi.php';
					break;

				case 'produk':
					include_once '../users/manager-produksi/produk.php';
					break;

				case 'komposisi':
					include_once '../users/manager-produksi/komposisi.php';
					break;

				case 'peramalan':
					include_once '../users/manager-produksi/peramalan.php';
					break;

				case 'produksi':
					include_once '../users/manager-produksi/produksi.php';
					break;

				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				default:
					include_once '../users/manager-produksi/beranda.php';
					break;
			}
		break;

	case 'manager pembelian':
			include_once '../users/manager-pembelian/_sidebar.php';
			// load content
			switch ($menu) {
				case 'bahan-baku':
					include_once '../users/manager-pembelian/bahan_baku.php';
					break;

				case 'form-pemesanan':
					include_once '../users/manager-pembelian/form_pemesanan.php';
					break;

				case 'daftar-harga':
					include_once '../users/manager-pembelian/daftar_harga_bahan_baku.php';
					break;

				case 'produk':
					include_once '../users/manager-pembelian/produk.php';
					break;

				case 'supplier':
					include_once '../users/manager-pembelian/supplier.php';
					break;

				case 'persediaan':
					include_once '../users/manager-pembelian/persediaan.php';
					break;

				case 'peramalan':
					include_once '../users/manager-pembelian/peramalan.php';
					break;

				case 'pemesanan':
					include_once '../users/manager-pembelian/pemesanan_bahan_baku.php';
					break;

				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				default:
					include_once '../users/manager-pembelian/beranda.php';
					break;
			}
		break;

	case 'manager keuangan':
			include_once '../users/manager-keuangan/_sidebar.php';
			// load content
			switch ($menu) {
				case 'pembayaran':
					include_once '../users/manager-keuangan/pembayaran.php';
					break;

				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				case 'validasi_pengadaan':
					include_once '../users/manager-keuangan/validasi_pengadaan.php';
					break;

				default:
					include_once '../users/manager-keuangan/beranda.php';
					break;
			}
		break;

	case 'manager pemasaran':
			include_once '../users/manager-pemasaran/_sidebar.php';
			// load content
			switch ($menu) {

				case 'pelanggan':
					include_once '../users/manager-pemasaran/pelanggan.php';
					break;

				case 'form-pemesanan':
					include_once '../users/manager-pemasaran/form_pemesanan.php';
					break;

				case 'produk':
					include_once '../users/manager-pemasaran/produk.php';
					break;

				case 'distribusi':
					include_once '../users/manager-pemasaran/distribusi.php';
					break;

				case 'pemesanan':
					include_once '../users/manager-pemasaran/pemesanan_produk.php';
					break;

				case 'profil':
					include_once '../users/general-pages/profil.php';
					break;

				default:
					include_once '../users/manager-pemasaran/beranda.php';
					break;
			}
		break;

	default:
			include_once '../users/general-pages/login_pegawai.php';
		break;
}

if ($jabatan!='') {
	// load footer
	include_once '../users/_footer.php';
}

?>
