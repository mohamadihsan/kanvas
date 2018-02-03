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
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <h5><b>Filter :</b></h5>
                    <form action="" method="get">
                        <select name="id" class="form-control select2" required>
                            <?php
                            // retrieve data dari API
                            $file = file_get_contents($url_api."tampilkan_data_bahan_baku.php");
                            $json = json_decode($file, true);
                            $i=0;
                            while ($i < count($json['data'])) {
                                $id_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'];
                                $nama_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'].' - '.$json['data'][$i]['nama_bahan_baku'];
                                ?>
                                <option value="<?= $id_bahan_baku[$i] ?>" <?php if(isset($_GET['id'])){ if($_GET['id']==$id_bahan_baku[$i]) echo 'selected'; } ?>> <?= $nama_bahan_baku[$i] ?></option>
                                <?php
                                $i++;
                            }
                            ?>
                        </select>
                        <select name="periode" class="form-control select2" required>
                            <?php
                            // retrieve data dari API
                            $file = file_get_contents($url_api."tampilkan_data_tahun_peramalan.php");
                            $json = json_decode($file, true);
                            $i=0;
                            if (count($json['data']) == 0) {
                                ?><option value="<?= date('Y')?>"><?= date('Y') ?></option><?php
                            }else{
                                while ($i < count($json['data'])) {
                                    $tahun[$i] = $json['data'][$i]['tahun'];
                                    ?>
                                    <option value="<?= $tahun[$i] ?>" <?php if(isset($_GET['periode'])){ if($_GET['periode']==$tahun[$i]) echo 'selected'; } ?>> <?= $tahun[$i] ?></option>
                                    <?php
                                    if ($i==count($json['data'])-1) {
                                        ?><option value="<?= $tahun[$i]+1 ?>" <?php if(isset($_GET['periode'])){ if($_GET['periode']==$tahun[$i]+1) echo 'selected'; } ?>> <?= $tahun[$i]+1 ?></option><?php
                                    }

                                    $i++;
                                }
                            }
                            ?>

                        </select>
                        <button type="submit" class="btn btn-sm">Filter</button>
                    </form>

                    <div style="width:100%;">
                        <canvas id="canvas"></canvas>
                    </div>

                </div>
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<?php
if (isset($_GET['periode'])) {
    $periode = $_GET['periode'];
    $id = $_GET['id'];
    $param = "?periode=".$periode."&id=".$id;
}else{
    $param = '';
}
?>
<script>
$(document).ready(function(){
    $.ajax({
        url: "<?= $url_api ?>tampilkan_data_grafik_pembelian_bahan_baku.php<?= $param ?>",
        method: "GET",
        success: function(data) {
            console.log(data);
            var periode = [];
            var jumlah_pembelian = [];
            var tahun;
            var id_bahan_baku;
            var obj = JSON.parse(data);
            $.each(obj, function(key, val) {
                periode.push(val.periode);
                jumlah_pembelian.push(val.jumlah_pembelian);

                tahun = val.tahun;
                id_bahan_baku = val.id_bahan_baku;
            })

            var chartdata = {
                labels: periode,
                datasets : [
                    {
                        label: "Data Pembelian Bahan Baku",
                        backgroundColor: window.chartColors.blue,
                        borderColor: window.chartColors.blue,
                        fill: false,
                        data: jumlah_pembelian
                    }
                ],
            };

            var ctx = $("#canvas");

            var barGraph = new Chart(ctx, {
                type: 'line',
                options: {
                    responsive: true,
                    title:{
                        display:true,
                        text:'Grafik Penjualan Produk ' + id_bahan_baku + ' ' + tahun
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Periode'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Jumlah'
                            },
                            ticks: {
                                beginAtZero: true,
                                steps: 10
                            }
                        }]
                    }
                },
                data: chartdata
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});
</script>
