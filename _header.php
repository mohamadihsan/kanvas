<!DOCTYPE html>
<html lang="in">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>Tracking</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- page specific plugin styles -->
		<link rel="stylesheet" href="assets/css/bootstrap-duallistbox.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-multiselect.min.css" />
		<link rel="stylesheet" href="assets/css/select2.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css">

		<!-- dataTables -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>

		<!-- gritter notification -->
		<link rel="stylesheet" href="assets/css/jquery.gritter.min.css" />

		<?php
		function Tanggal($tanggal) {
			$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
			$tahun = substr($tanggal, 0, 4);
			$bulan = substr($tanggal, 5, 2);
			$tgl = substr($tanggal, 8, 2);

			$hasil = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
			return ($hasil);
		}

		function Rupiah($rupiah) {
			//format rupiah
			$jumlah_desimal = "2";
			$pemisah_desimal = ",";
			$pemisah_ribuan = ".";

			$hasil = number_format($rupiah, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan);
			return ($hasil);
		}
		?>
	</head>

	<body class="skin-1 no-skin">

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>
