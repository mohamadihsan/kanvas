<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active"></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <?php
                    // retrieve data dari API
                    $file = file_get_contents($url_api."tampilkan_data_pemesanan_yang_belum_dibayar.php");
                    $json = json_decode($file, true);
                    $i=0;
                    while ($i < count($json['data'])) {
                        $jumlah_pemesanan = $json['data'][$i]['jumlah_pemesanan'];
                        $jumlah_yang_belum_dibayar = $json['data'][$i]['jumlah_yang_belum_dibayar'];
                        $i++;
                    }
                    ?>

                    <caption><h5><b>Data Pemesanan dan Pembayaran </b></h5></caption>
					<div class="infobox infobox-green">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-money"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $jumlah_yang_belum_dibayar ?></span>
							<div class="infobox-content">Belum dibayar</div>
						</div>
					</div>

					<div class="infobox infobox-pink">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-file-text"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $jumlah_pemesanan ?></span>
							<div class="infobox-content">Pemesanan</div>
						</div>
                    </div>


                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
