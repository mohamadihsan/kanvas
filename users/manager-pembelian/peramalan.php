<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Peramalan Kebutuhan Bahan Baku</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Peramalan Kebutuhan Bahan Baku
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Pengolahan Data
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div id="" class="collapse tampil_detail">
                        <div class="well">
                        Kebutuhan Bahan Baku
                        <button data-toggle="collapse" data-target=".tampil_detail" class="btn btn-sm"><i class="ace-icon fa fa-close bigger-110"></i> Tutup</button>

                        </div>
                    </div>

                    <?php
                    if (isset($_GET['data']) && isset($_GET['periode'])) {

                        // retrieve data dari API
                        $file = file_get_contents($url_api."tampilkan_data_kebutuhan_bahan_baku.php?data=".$_GET['data']."&f=".$_GET['f']."&periode=".$_GET['periode']);
                        $json = json_decode($file, true);
                        ?>
                        <div id="" class="">
                            <div class="well">
                                <caption><h4>Kebutuhan Bahan Baku</h4></caption>
                                <table class="table table-responsive">
                                    <tr>
                                        <th width="20%">ID PRODUK</th>
                                        <th>: <?= $json['data_produk'][0]['id_produk'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>NAMA PRODUK</th>
                                        <th>: <?= $json['data_produk'][0]['nama_produk'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>JENIS PRODUK</th>
                                        <th>: <?= $json['data_produk'][0]['jenis_produk'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>KEMASAN</th>
                                        <th>: <?= $json['data_produk'][0]['kemasan'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>HARGA PRODUK</th>
                                        <th>: <?= "Rp".Rupiah($json['data_produk'][0]['harga']) ?></th>
                                    </tr>
                                    <tr>
                                        <th>STOK SAAT INI</th>
                                        <th>: <?= $json['data_produk'][0]['stok_produk'] ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">PERAMALAN KEBUTUHAN BAHAN BAKU YANG HARUS DISEDIAKAN UNTUK PERIODE <?= $json['data_produk'][0]['periode'] ?> :</th>
                                    </tr>

                                    <?php
                                    if (!isset($json['data'][0]['pesan'])) {
                                        $i=0;
                                        while ($i < count($json['data'])) {
                                            $takaran[$i] = $json['data'][$i]['takaran'];
                                            $bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'].' - '.$json['data'][$i]['nama_bahan_baku'];
                                            ?>
                                              <tr>
                                                  <td colspan="2"><?= $bahan_baku[$i].' sebanyak '.$takaran[$i] ?></td>
                                              </tr>
                                            <?php
                                            $i++;
                                        }
                                    }else{ ?>
                                      <tr>
                                          <td colspan="2"><?= $json['data'][0]['pesan'] ?></td>
                                      </tr>
                                      <?php
                                    }
                                    ?>
                                    <tfoot>
                                        <tr>
                                            <td><a href="./index.php?menu=peramalan" class="btn btn-sm btn-primary">Tampilkan List Peramalan</a></td>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                        <?php
                    }else { ?>

                      <div class="clearfix">
                          <div class="pull-right tableTools-container"></div>
                      </div>
                      <div class="table-header">
                          Daftar data "Peramalan"
                      </div>
                      <!-- div.table-responsive -->

                      <!-- div.dataTables_borderWrap -->
                      <div class="table table-responsive">
                          <table id="mytable" class="display" width="100%" cellspacing="0">
                              <thead>
                                  <tr class="">
                                      <th width="7%" class="text-center">No</th>
                                      <th width="15%" class="text-left">Periode</th>
                                      <th width="50%" class="text-left">ID Produk</th>
                                      <th width="15%" class="text-left">Hasil Peramalan</th>
                                      <th width="10%" class="text-center"></th>
                                  </tr>
                              </thead>
                          </table>
                      </div>
                      <!-- PAGE CONTENT ENDS -->
                      <?php
                    } ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<script>
    function detail(id_peramalan) {

    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_peramalan.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'periode' } ,
                            { mData: 'id_produk' } ,
                            { mData: 'hasil_peramalan' },
                            { mData: 'action_detail'}
                    ]
        });

        //Callback handler for form submit event
        $(".myform").submit(function(e)
        {

        var formObj = $(this);
        var formURL = formObj.attr("action");
        var formData = new FormData(this);
        $.ajax({
            url: formURL,
            type: 'POST',
            data:  formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function (){
                       $("#loading").show(1000).html("<img src='../assets/images/loading.gif' height='100'>");
                       },
            success: function(data, textStatus, jqXHR){
                    $("#result").html(data);
                    $("#loading").hide();
                    $("#hapus").modal('hide');
                    $('#mytable').DataTable().ajax.reload();
            },
                error: function(jqXHR, textStatus, errorThrown){
         }
        });
            e.preventDefault(); //Prevent Default action.
            e.unbind();
        });

    });
</script>
